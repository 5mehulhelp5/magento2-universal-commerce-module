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
 * Line Item Create Request Interface
 * Represents a line item in a create request
 */
interface LineItemCreateRequestInterface
{
    public const ITEM = 'item';
    public const QUANTITY = 'quantity';

    /**
     * Get item
     *
     * @return ItemCreateRequestInterface
     */
    public function getItem(): ItemCreateRequestInterface;

    /**
     * Set item
     *
     * @param ItemCreateRequestInterface $item
     * @return $this
     */
    public function setItem(ItemCreateRequestInterface $item): self;

    /**
     * Get quantity
     *
     * @return int
     */
    public function getQuantity(): int;

    /**
     * Set quantity
     *
     * @param int $quantity
     * @return $this
     */
    public function setQuantity(int $quantity): self;
}
