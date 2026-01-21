<?php

/**
 * @author Magebit <info@magebit.com>
 * @copyright Copyright (c) Magebit, Ltd. (https://magebit.com)
 * @license https://magebit.com/code-license
 */

declare(strict_types=1);

namespace Magebit\UniversalCommerce\Service;

use Magebit\UniversalCommerce\Api\DiscountServiceInterface;
use Magebit\UcpSpec\MutableApi\Schemas\Shopping\DiscountAllocationInterface;
use Magebit\UcpSpec\MutableApi\Schemas\Shopping\DiscountAllocationInterfaceFactory;
use Magebit\UcpSpec\MutableApi\Schemas\Shopping\DiscountAppliedDiscountInterface;
use Magebit\UcpSpec\MutableApi\Schemas\Shopping\DiscountAppliedDiscountInterfaceFactory;
use Magebit\UniversalCommerce\Helper\PriceConverter;
use Magento\Quote\Api\Data\CartInterface;
use Magento\Quote\Model\Quote;
use Magento\SalesRule\Api\RuleRepositoryInterface;
use Psr\Log\LoggerInterface;

/**
 * Discount Service
 *
 * Handles discount code application and extraction from Magento quotes
 */
class DiscountService implements DiscountServiceInterface
{
    /**
     * @param DiscountAppliedDiscountInterfaceFactory $appliedDiscountFactory
     * @param DiscountAllocationInterfaceFactory $allocationFactory
     * @param RuleRepositoryInterface $ruleRepository
     * @param PriceConverter $priceConverter
     * @param LoggerInterface $logger
     */
    public function __construct(
        private readonly DiscountAppliedDiscountInterfaceFactory $appliedDiscountFactory,
        private readonly DiscountAllocationInterfaceFactory $allocationFactory,
        private readonly RuleRepositoryInterface $ruleRepository,
        private readonly PriceConverter $priceConverter,
        private readonly LoggerInterface $logger
    ) {
    }

    /**
     * Apply discount codes to quote
     *
     * Magento only supports ONE coupon code per quote. If multiple codes provided,
     * we try each in order and apply the first valid one.
     *
     * @param CartInterface $quote
     * @param string[]|null $codes Discount codes to apply (null = no change, [] = clear all)
     * @return void
     */
    public function applyDiscountCodes(CartInterface $quote, ?array $codes): void
    {
        /** @var Quote $quote */

        if ($codes === null) {
            // No change requested
            return;
        }

        if (empty($codes)) {
            // Clear all discount codes
            $quote->setCouponCode('');
            $quote->collectTotals();
            return;
        }

        // Magento only supports one coupon code, so try codes in order
        // and apply the first valid one
        $appliedCode = null;
        $originalCouponCode = $quote->getCouponCode();

        foreach ($codes as $code) {
            if (!is_string($code) || empty(trim($code))) {
                continue;
            }

            $code = trim($code);
            $quote->setCouponCode($code);
            $quote->collectTotals();

            // Check if coupon was successfully applied
            if ($quote->getCouponCode() === $code) {
                $appliedCode = $code;

                // Log warning if multiple codes were provided
                if (count($codes) > 1) {
                    $this->logger->warning('Multiple discount codes provided, only first valid code applied', [
                        'applied_code' => $code,
                        'all_codes' => $codes,
                    ]);
                }
                break;
            }
        }

        // If no code was successfully applied, restore original or clear
        if ($appliedCode === null) {
            $quote->setCouponCode($originalCouponCode ?? '');
            $quote->collectTotals();
        }
    }

    /**
     * Get applied discounts from quote
     *
     * @param CartInterface $quote
     * @return DiscountAppliedDiscountInterface[]
     */
    public function getAppliedDiscounts(CartInterface $quote): array
    {
        /** @var Quote $quote */
        $appliedDiscounts = [];

        // Get discount amount from shipping address (where Magento stores it)
        $shippingAddress = $quote->getShippingAddress();
        $discountAmount = (float) ($shippingAddress->getDiscountAmount() ?? 0);

        // If no discount, return empty array
        if ($discountAmount <= 0) {
            return $appliedDiscounts;
        }

        $couponCode = $quote->getCouponCode();
        $isAutomatic = empty($couponCode);

        // Get discount title from sales rule if coupon code exists
        $title = 'Discount';
        if ($couponCode) {
            try {
                // Try to find the rule by coupon code
                // Note: This is a simplified approach. In production, you might need
                // to query the sales rule collection to find the rule by coupon code
                $title = $couponCode;

                // If we can get rule ID from quote, fetch rule details
                $appliedRuleIds = $quote->getAppliedRuleIds();
                if ($appliedRuleIds) {
                    $ruleIds = explode(',', $appliedRuleIds);
                    if (!empty($ruleIds)) {
                        try {
                            $rule = $this->ruleRepository->getById((int) $ruleIds[0]);
                            $title = $rule->getName() ?: $couponCode;
                        } catch (\Exception $e) {
                            $this->logger->debug('Could not fetch sales rule details', [
                                'rule_id' => $ruleIds[0],
                                'exception' => $e->getMessage(),
                            ]);
                        }
                    }
                }
            } catch (\Exception $e) {
                $this->logger->debug('Error fetching discount rule information', [
                    'coupon_code' => $couponCode,
                    'exception' => $e->getMessage(),
                ]);
            }
        } else {
            // Automatic discount (catalog price rule)
            $title = 'Automatic Discount';
        }

        // Create applied discount object
        /** @var DiscountAppliedDiscountInterface $appliedDiscount */
        $appliedDiscount = $this->appliedDiscountFactory->create();
        $appliedDiscount->setTitle($title);
        $appliedDiscount->setAmount($this->priceConverter->toCents(abs($discountAmount)));
        $appliedDiscount->setAutomatic($isAutomatic);

        if (!$isAutomatic) {
            $appliedDiscount->setCode($couponCode);
        }

        // Create allocation to subtotal
        /** @var DiscountAllocationInterface $allocation */
        $allocation = $this->allocationFactory->create();
        $allocation->setPath('subtotal');
        $allocation->setAmount($this->priceConverter->toCents(abs($discountAmount)));

        $appliedDiscount->setAllocations([$allocation]);
        $appliedDiscounts[] = $appliedDiscount;

        return $appliedDiscounts;
    }
}
