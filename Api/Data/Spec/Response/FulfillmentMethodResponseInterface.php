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
 * Fulfillment Method Response Interface
 * Represents a selected fulfillment method
 */
interface FulfillmentMethodResponseInterface
{
    public const DESTINATIONS = 'destinations';
    public const GROUPS = 'groups';
    public const ID = 'id';
    public const LINE_ITEM_IDS = 'line_item_ids';
    public const SELECTED_DESTINATION_ID = 'selected_destination_id';
    public const TYPE = 'type';

    /**
     * Get destinations
     *
     * @return FulfillmentDestinationResponseInterface[]|null
     */
    public function getDestinations(): ?array;

    /**
     * Set destinations
     *
     * @param FulfillmentDestinationResponseInterface[]|null $destinations
     * @return $this
     */
    public function setDestinations(?array $destinations): self;

    /**
     * Get groups
     *
     * @return FulfillmentGroupResponseInterface[]|null
     */
    public function getGroups(): ?array;

    /**
     * Set groups
     *
     * @param FulfillmentGroupResponseInterface[]|null $groups
     * @return $this
     */
    public function setGroups(?array $groups): self;

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
     * Get selected destination ID
     *
     * @return string|null
     */
    public function getSelectedDestinationId(): ?string;

    /**
     * Set selected destination ID
     *
     * @param string|null $selectedDestinationId
     * @return $this
     */
    public function setSelectedDestinationId(?string $selectedDestinationId): self;

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
