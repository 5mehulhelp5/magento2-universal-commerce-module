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
 * Fulfillment Group Response Interface
 * Represents a fulfillment group
 */
interface FulfillmentGroupResponseInterface
{
    public const ID = 'id';
    public const LINE_ITEM_IDS = 'line_item_ids';
    public const OPTIONS = 'options';
    public const SELECTED_OPTION_ID = 'selected_option_id';

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
     * Get options
     *
     * @return FulfillmentOptionResponseInterface[]|null
     */
    public function getOptions(): ?array;

    /**
     * Set options
     *
     * @param FulfillmentOptionResponseInterface[]|null $options
     * @return $this
     */
    public function setOptions(?array $options): self;

    /**
     * Get selected option ID
     *
     * @return string|null
     */
    public function getSelectedOptionId(): ?string;

    /**
     * Set selected option ID
     *
     * @param string|null $selectedOptionId
     * @return $this
     */
    public function setSelectedOptionId(?string $selectedOptionId): self;
}
