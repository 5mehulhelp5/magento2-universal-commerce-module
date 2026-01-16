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
 * Line Item Response Interface
 * Represents a line item in the checkout response
 */
interface LineItemResponseInterface
{
    public const ID = 'id';
    public const ITEM = 'item';
    public const PARENT_ID = 'parent_id';
    public const QUANTITY = 'quantity';
    public const TOTALS = 'totals';

    /**
     * Get ID
     *
     * @return string
     */
    public function getId(): string;

    /**
     * Set ID
     *
     * @param string $id
     * @return $this
     */
    public function setId(string $id): self;

    /**
     * Get item
     *
     * @return ItemResponseInterface
     */
    public function getItem(): ItemResponseInterface;

    /**
     * Set item
     *
     * @param ItemResponseInterface $item
     * @return $this
     */
    public function setItem(ItemResponseInterface $item): self;

    /**
     * Get parent ID
     *
     * @return string|null
     */
    public function getParentId(): ?string;

    /**
     * Set parent ID
     *
     * @param string|null $parentId
     * @return $this
     */
    public function setParentId(?string $parentId): self;

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

    /**
     * Get totals
     *
     * @return TotalResponseInterface[]
     */
    public function getTotals(): array;

    /**
     * Set totals
     *
     * @param TotalResponseInterface[] $totals
     * @return $this
     */
    public function setTotals(array $totals): self;
}
