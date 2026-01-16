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
 * Total Response Interface
 * Represents a total line in the checkout response
 */
interface TotalResponseInterface
{
    public const AMOUNT = 'amount';
    public const DISPLAY_TEXT = 'display_text';
    public const TYPE = 'type';

    /**
     * Get amount
     *
     * @return float
     */
    public function getAmount(): float;

    /**
     * Set amount
     *
     * @param float $amount
     * @return $this
     */
    public function setAmount(float $amount): self;

    /**
     * Get display text
     *
     * @return string|null
     */
    public function getDisplayText(): ?string;

    /**
     * Set display text
     *
     * @param string|null $displayText
     * @return $this
     */
    public function setDisplayText(?string $displayText): self;

    /**
     * Get type
     *
     * @return string
     */
    public function getType(): string;

    /**
     * Set type
     *
     * @param string $type
     * @return $this
     */
    public function setType(string $type): self;
}
