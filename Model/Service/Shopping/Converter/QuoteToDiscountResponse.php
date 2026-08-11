<?php

/**
 * This file is part of the Magebit_UniversalCommerce package.
 *
 * @copyright Copyright (c) 2026 Magebit, Ltd. (https://magebit.com/)
 * @author    Magebit <info@magebit.com>
 * @license   MIT
 */

declare(strict_types=1);

namespace Magebit\UniversalCommerce\Model\Service\Shopping\Converter;

use Magento\Quote\Api\Data\CartInterface;
use Magento\Quote\Model\Quote;
use Magebit\UcpSpec\Api\Shopping\DiscountResponseDiscountsObjectInterface;
use Magebit\UcpSpec\Api\Shopping\DiscountResponseDiscountsObjectInterfaceFactory;

class QuoteToDiscountResponse
{
    /**
     * @param DiscountResponseDiscountsObjectInterfaceFactory $discountsObjectFactory
     */
    public function __construct(
        protected readonly DiscountResponseDiscountsObjectInterfaceFactory $discountsObjectFactory,
    ) {
    }

    /**
     * Convert quote to discount response
     *
     * @param CartInterface $quote
     * @return DiscountResponseDiscountsObjectInterface|null
     */
    public function convert(CartInterface $quote): ?DiscountResponseDiscountsObjectInterface
    {
        /** @var Quote $quote */
        $shippingAddress = $quote->getShippingAddress();
        if (!$shippingAddress) {
            return null;
        }

        $couponCode = $quote->getCouponCode();
        $discountAmount = (float) $shippingAddress->getDiscountAmount();

        // If no discount and no coupon code, return null
        if (!$couponCode && $discountAmount <= 0) {
            return null;
        }

        /** @var DiscountResponseDiscountsObjectInterface $discountsObject */
        $discountsObject = $this->discountsObjectFactory->create();

        // Set codes array (echo back submitted codes)
        if ($couponCode) {
            $discountsObject->setCodes([$couponCode]);
        } else {
            $discountsObject->setCodes([]);
        }

        return $discountsObject;
    }
}
