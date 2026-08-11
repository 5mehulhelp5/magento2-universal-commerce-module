<?php

/**
 * This file is part of the Magebit_UniversalCommerce package.
 *
 * @copyright Copyright (c) 2026 Magebit, Ltd. (https://magebit.com/)
 * @author    Magebit <info@magebit.com>
 * @license   MIT
 */

declare(strict_types=1);

namespace Magebit\UniversalCommerce\Test\Unit\Model\Stub;

/**
 * Magento's Address\Total resolves these through __call, so it cannot be mocked.
 */
class TotalRow
{
    /**
     * @param string $code
     * @param string $title
     * @param float $value
     */
    public function __construct(
        private readonly string $code,
        private readonly string $title,
        private readonly float $value
    ) {
    }

    /**
     * @return string
     */
    public function getCode(): string
    {
        return $this->code;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @return float
     */
    public function getValue(): float
    {
        return $this->value;
    }
}
