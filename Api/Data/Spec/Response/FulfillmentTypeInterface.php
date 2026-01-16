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
 * Fulfillment Type Interface
 * Defines type constants for fulfillment methods
 */
interface FulfillmentTypeInterface
{
    public const TYPE_PICKUP = 'pickup';
    public const TYPE_SHIPPING = 'shipping';
}
