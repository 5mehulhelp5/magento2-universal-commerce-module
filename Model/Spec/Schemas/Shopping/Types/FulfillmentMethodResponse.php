<?php

/**
 * @author Magebit <info@magebit.com>
 * @copyright Copyright (c) Magebit, Ltd. (https://magebit.com)
 * @license https://magebit.com/code-license
 */

declare(strict_types=1);

namespace Magebit\UniversalCommerce\Model\Spec\Schemas\Shopping\Types;

use Magebit\UniversalCommerce\Model\DataTransferObject;
use Magebit\UcpSpec\MutableApi\Schemas\Shopping\Types\FulfillmentMethodResponseInterface;
use Magebit\UcpSpec\MutableApi\Schemas\Shopping\Types\FulfillmentDestinationResponseInterface;
use Magebit\UcpSpec\MutableApi\Schemas\Shopping\Types\FulfillmentGroupResponseInterface;

class FulfillmentMethodResponse extends DataTransferObject implements FulfillmentMethodResponseInterface
{
    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->getDataString(FulfillmentMethodResponseInterface::KEY_ID);
    }

    /**
     * @param string $id
     * @return self
     */
    public function setId(string $id): self
    {
        $this->setData(FulfillmentMethodResponseInterface::KEY_ID, $id);
        return $this;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->getDataString(FulfillmentMethodResponseInterface::KEY_TYPE);
    }

    /**
     * @param string $type
     * @return self
     */
    public function setType(string $type): self
    {
        $this->setData(FulfillmentMethodResponseInterface::KEY_TYPE, $type);
        return $this;
    }

    /**
     * @return string[]
     */
    public function getLineItemIds(): array
    {
        return $this->getDataArray(FulfillmentMethodResponseInterface::KEY_LINE_ITEM_IDS);
    }

    /**
     * @param string[] $lineItemIds
     * @return self
     */
    public function setLineItemIds(array $lineItemIds): self
    {
        $this->setData(FulfillmentMethodResponseInterface::KEY_LINE_ITEM_IDS, $lineItemIds);
        return $this;
    }

    /**
     * @return FulfillmentDestinationResponseInterface[]|null
     */
    public function getDestinations(): array|null
    {
        return $this->getDataArrayOfTypeOrNull(
            FulfillmentMethodResponseInterface::KEY_DESTINATIONS,
            FulfillmentDestinationResponseInterface::class
        );
    }

    /**
     * @param FulfillmentDestinationResponseInterface[]|null $destinations
     * @return self
     */
    public function setDestinations(?array $destinations): self
    {
        $this->setData(FulfillmentMethodResponseInterface::KEY_DESTINATIONS, $destinations);
        return $this;
    }

    /**
     * @return string|null
     */
    public function getSelectedDestinationId(): string|null
    {
        return $this->getDataStringOrNull(FulfillmentMethodResponseInterface::KEY_SELECTED_DESTINATION_ID);
    }

    /**
     * @param string|null $selectedDestinationId
     * @return self
     */
    public function setSelectedDestinationId(?string $selectedDestinationId): self
    {
        $this->setData(FulfillmentMethodResponseInterface::KEY_SELECTED_DESTINATION_ID, $selectedDestinationId);
        return $this;
    }

    /**
     * @return FulfillmentGroupResponseInterface[]|null
     */
    public function getGroups(): array|null
    {
        return $this->getDataArrayOfTypeOrNull(
            FulfillmentMethodResponseInterface::KEY_GROUPS,
            FulfillmentGroupResponseInterface::class
        );
    }

    /**
     * @param FulfillmentGroupResponseInterface[]|null $groups
     * @return self
     */
    public function setGroups(?array $groups): self
    {
        $this->setData(FulfillmentMethodResponseInterface::KEY_GROUPS, $groups);
        return $this;
    }
}
