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
use Magebit\UcpSpec\MutableApi\Schemas\Shopping\DiscountDiscountsObjectInterface;
use Magebit\UcpSpec\MutableApi\Schemas\Shopping\DiscountDiscountsObjectInterfaceFactory;

class QuoteToDiscountResponse
{
    /**
     * @param DiscountDiscountsObjectInterfaceFactory $discountsObjectFactory
     */
    public function __construct(
        protected readonly DiscountDiscountsObjectInterfaceFactory $discountsObjectFactory,
    ) {
    }

    /**
     * Convert quote to discount response
     *
     * @param CartInterface $quote
     * @return DiscountDiscountsObjectInterface|null
     */
    public function convert(CartInterface $quote): ?DiscountDiscountsObjectInterface
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

        /** @var DiscountDiscountsObjectInterface $discountsObject */
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
