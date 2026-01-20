<?php

/**
 * This file is part of the Magebit_UniversalCommerce package.
 *
 * @copyright Copyright (c) 2026 Magebit, Ltd. (https://magebit.com/)
 * @author    Magebit <info@magebit.com>
 * @license   MIT
 */

declare(strict_types=1);

namespace Magebit\UniversalCommerce\Model\Data\Spec\Schemas\Shopping\Types;

use Magebit\UcpSpec\Api\Schemas\Shopping\Types\FulfillmentMethodResponseInterface;
use Magebit\UcpSpec\Api\Schemas\Shopping\Types\FulfillmentDestinationResponseInterface;
use Magebit\UcpSpec\Api\Schemas\Shopping\Types\FulfillmentDestinationResponseInterfaceFactory;
use Magebit\UcpSpec\Api\Schemas\Shopping\Types\FulfillmentGroupResponseInterface;
use Magebit\UcpSpec\Api\Schemas\Shopping\Types\FulfillmentGroupResponseInterfaceFactory;
use Magebit\UniversalCommerce\Model\Data\DataTransferObject;

/**
 * Fulfillment Method Response Model
 */
class FulfillmentMethodResponse extends DataTransferObject implements FulfillmentMethodResponseInterface
{
    /**
     * @param FulfillmentDestinationResponseInterfaceFactory $destinationFactory
     * @param FulfillmentGroupResponseInterfaceFactory $groupFactory
     * @param array<mixed> $data
     */
    public function __construct(
        private readonly FulfillmentDestinationResponseInterfaceFactory $destinationFactory,
        private readonly FulfillmentGroupResponseInterfaceFactory $groupFactory,
        array $data = []
    ) {
        parent::__construct($data);
    }

    /**
     * @inheritDoc
     */
    public function getDestinations(): ?array
    {
        $destinations = $this->getData(self::KEY_DESTINATIONS);
        if ($destinations === null) {
            return null;
        }

        return $this->getDataInstanceArray(
            self::KEY_DESTINATIONS,
            FulfillmentDestinationResponseInterface::class,
            $this->destinationFactory->create(...)
        );
    }

    /**
     * @inheritDoc
     */
    public function setDestinations(?array $destinations): FulfillmentMethodResponseInterface
    {
        return $this->setData(self::KEY_DESTINATIONS, $destinations);
    }

    /**
     * @inheritDoc
     */
    public function getGroups(): ?array
    {
        $groups = $this->getData(self::KEY_GROUPS);
        if ($groups === null) {
            return null;
        }

        return $this->getDataInstanceArray(
            self::KEY_GROUPS,
            FulfillmentGroupResponseInterface::class,
            $this->groupFactory->create(...)
        );
    }

    /**
     * @inheritDoc
     */
    public function setGroups(?array $groups): FulfillmentMethodResponseInterface
    {
        return $this->setData(self::KEY_GROUPS, $groups);
    }

    /**
     * @inheritDoc
     */
    public function getId(): string
    {
        return $this->getDataString(self::KEY_ID);
    }

    /**
     * @inheritDoc
     */
    public function setId(string $id): FulfillmentMethodResponseInterface
    {
        return $this->setData(self::KEY_ID, $id);
    }

    /**
     * @inheritDoc
     */
    public function getLineItemIds(): array
    {
        return $this->getData(self::KEY_LINE_ITEM_IDS) ?? [];
    }

    /**
     * @inheritDoc
     */
    public function setLineItemIds(array $lineItemIds): FulfillmentMethodResponseInterface
    {
        return $this->setData(self::KEY_LINE_ITEM_IDS, $lineItemIds);
    }

    /**
     * @inheritDoc
     */
    public function getSelectedDestinationId(): ?string
    {
        return $this->getDataStringOrNull(self::KEY_SELECTED_DESTINATION_ID);
    }

    /**
     * @inheritDoc
     */
    public function setSelectedDestinationId(?string $selectedDestinationId): FulfillmentMethodResponseInterface
    {
        return $this->setData(self::KEY_SELECTED_DESTINATION_ID, $selectedDestinationId);
    }

    /**
     * @inheritDoc
     */
    public function getType(): string
    {
        return $this->getDataString(self::KEY_TYPE);
    }

    /**
     * @inheritDoc
     */
    public function setType(string $type): FulfillmentMethodResponseInterface
    {
        return $this->setData(self::KEY_TYPE, $type);
    }
}
