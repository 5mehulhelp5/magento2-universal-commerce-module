<?php

/**
 * This file is part of the Magebit_UniversalCommerce package.
 *
 * @copyright Copyright (c) 2026 Magebit, Ltd. (https://magebit.com/)
 * @author    Magebit <info@magebit.com>
 * @license   MIT
 */

declare(strict_types=1);

namespace Magebit\UniversalCommerce\Api\Data\Spec;

/**
 * Card Number Type Constants
 * Represents valid card number types
 */
interface CardNumberTypeInterface
{
    public const DPAN = 'dpan';
    public const FPAN = 'fpan';
    public const NETWORK_TOKEN = 'network_token';
}
