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
 * Fulfillment Available Method Response Interface
 * Represents an available fulfillment method
 */
interface FulfillmentAvailableMethodResponseInterface
{
    public const DESCRIPTION = 'description';
    public const FULFILLABLE_ON = 'fulfillable_on';
    public const LINE_ITEM_IDS = 'line_item_ids';
    public const TYPE = 'type';

    /**
     * Get description
     *
     * @return string|null
     */
    public function getDescription(): ?string;

    /**
     * Set description
     *
     * @param string|null $description
     * @return $this
     */
    public function setDescription(?string $description): self;

    /**
     * Get fulfillable on
     *
     * @return string|null
     */
    public function getFulfillableOn(): ?string;

    /**
     * Set fulfillable on
     *
     * @param string|null $fulfillableOn
     * @return $this
     */
    public function setFulfillableOn(?string $fulfillableOn): self;

    /**
     * Get line item IDs
     *
     * @return string[]
     */
    public function getLineItemIds(): array;

    /**
     * Set line item IDs
     *
     * @param string[] $lineItemIds
     * @return $this
     */
    public function setLineItemIds(array $lineItemIds): self;

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
