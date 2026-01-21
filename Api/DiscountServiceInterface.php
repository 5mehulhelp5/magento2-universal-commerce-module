<?php

/**
 * @author Magebit <info@magebit.com>
 * @copyright Copyright (c) Magebit, Ltd. (https://magebit.com)
 * @license https://magebit.com/code-license
 */

declare(strict_types=1);

namespace Magebit\UniversalCommerce\Api;

use Magebit\UcpSpec\MutableApi\Schemas\Shopping\DiscountAppliedDiscountInterface;
use Magento\Quote\Api\Data\CartInterface;

interface DiscountServiceInterface
{
    /**
     * Apply discount codes to quote
     *
     * @param CartInterface $quote
     * @param string[]|null $codes Discount codes to apply (null = no change, [] = clear all)
     * @return void
     */
    public function applyDiscountCodes(CartInterface $quote, ?array $codes): void;

    /**
     * Get applied discounts from quote
     *
     * @param CartInterface $quote
     * @return DiscountAppliedDiscountInterface[]
     */
    public function getAppliedDiscounts(CartInterface $quote): array;
}
