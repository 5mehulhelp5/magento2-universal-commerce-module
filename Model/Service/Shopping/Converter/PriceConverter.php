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

class PriceConverter
{
    /**
     * @param float $price
     * @return int
     */
    public function convert(float $price): int
    {
        return (int) ($price * 100);
    }
}
