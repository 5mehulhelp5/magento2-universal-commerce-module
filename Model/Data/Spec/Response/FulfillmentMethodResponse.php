<?php

/**
 * This file is part of the Magebit_UniversalCommerce package.
 *
 * @copyright Copyright (c) 2026 Magebit, Ltd. (https://magebit.com/)
 * @author    Magebit <info@magebit.com>
 * @license   MIT
 */

declare(strict_types=1);

namespace Magebit\UniversalCommerce\Model\Data\Spec\Response;

use Magebit\UniversalCommerce\Api\Data\Spec\Response\FulfillmentMethodResponseInterface;
use Magebit\UniversalCommerce\Api\Data\Spec\Response\FulfillmentDestinationResponseInterface;
use Magebit\UniversalCommerce\Api\Data\Spec\Response\FulfillmentDestinationResponseInterfaceFactory;
use Magebit\UniversalCommerce\Api\Data\Spec\Response\FulfillmentGroupResponseInterface;
use Magebit\UniversalCommerce\Api\Data\Spec\Response\FulfillmentGroupResponseInterfaceFactory;
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
        $destinations = $this->getData(self::DESTINATIONS);
        if ($destinations === null) {
            return null;
        }

        return $this->getDataInstanceArray(
            self::DESTINATIONS,
            FulfillmentDestinationResponseInterface::class,
            $this->destinationFactory->create(...)
        );
    }

    /**
     * @inheritDoc
     */
    public function setDestinations(?array $destinations): FulfillmentMethodResponseInterface
    {
        return $this->setData(self::DESTINATIONS, $destinations);
    }

    /**
     * @inheritDoc
     */
    public function getGroups(): ?array
    {
        $groups = $this->getData(self::GROUPS);
        if ($groups === null) {
            return null;
        }

        return $this->getDataInstanceArray(
            self::GROUPS,
            FulfillmentGroupResponseInterface::class,
            $this->groupFactory->create(...)
        );
    }

    /**
     * @inheritDoc
     */
    public function setGroups(?array $groups): FulfillmentMethodResponseInterface
    {
        return $this->setData(self::GROUPS, $groups);
    }

    /**
     * @inheritDoc
     */
    public function getId(): string
    {
        return $this->getDataString(self::ID);
    }

    /**
     * @inheritDoc
     */
    public function setId(string $id): FulfillmentMethodResponseInterface
    {
        return $this->setData(self::ID, $id);
    }

    /**
     * @inheritDoc
     */
    public function getLineItemIds(): array
    {
        return $this->getData(self::LINE_ITEM_IDS) ?? [];
    }

    /**
     * @inheritDoc
     */
    public function setLineItemIds(array $lineItemIds): FulfillmentMethodResponseInterface
    {
        return $this->setData(self::LINE_ITEM_IDS, $lineItemIds);
    }

    /**
     * @inheritDoc
     */
    public function getSelectedDestinationId(): ?string
    {
        return $this->getDataStringOrNull(self::SELECTED_DESTINATION_ID);
    }

    /**
     * @inheritDoc
     */
    public function setSelectedDestinationId(?string $selectedDestinationId): FulfillmentMethodResponseInterface
    {
        return $this->setData(self::SELECTED_DESTINATION_ID, $selectedDestinationId);
    }

    /**
     * @inheritDoc
     */
    public function getType(): string
    {
        return $this->getDataString(self::TYPE);
    }

    /**
     * @inheritDoc
     */
    public function setType(string $type): FulfillmentMethodResponseInterface
    {
        return $this->setData(self::TYPE, $type);
    }
}
