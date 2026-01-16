<?php

/**
 * This file is part of the Magebit_UniversalCommerce package.
 *
 * @copyright Copyright (c) 2026 Magebit, Ltd. (https://magebit.com/)
 * @author    Magebit <info@magebit.com>
 * @license   MIT
 */

declare(strict_types=1);

namespace Magebit\UniversalCommerce\Api\Data\Spec\Response;

/**
 * Total Response Type Interface
 * Defines type constants for total line items
 */
interface TotalResponseTypeInterface
{
    public const TYPE_DISCOUNT = 'discount';
    public const TYPE_FEE = 'fee';
    public const TYPE_FULFILLMENT = 'fulfillment';
    public const TYPE_ITEMS_DISCOUNT = 'items_discount';
    public const TYPE_SUBTOTAL = 'subtotal';
    public const TYPE_TAX = 'tax';
    public const TYPE_TOTAL = 'total';
}
