<?php

/**
 * @author Magebit <info@magebit.com>
 * @copyright Copyright (c) Magebit, Ltd. (https://magebit.com)
 * @license https://magebit.com/code-license
 */

declare(strict_types=1);

namespace Magebit\UniversalCommerce\Model\Spec\Schemas\Shopping\Types;

use Magebit\UniversalCommerce\Model\DataTransferObject;
use Magebit\UcpSpec\MutableApi\Schemas\Shopping\Types\FulfillmentMethodCreateRequestInterface;
use Magebit\UcpSpec\MutableApi\Schemas\Shopping\Types\FulfillmentDestinationRequestInterface;
use Magebit\UcpSpec\MutableApi\Schemas\Shopping\Types\FulfillmentGroupCreateRequestInterface;

class FulfillmentMethodCreateRequest extends DataTransferObject implements FulfillmentMethodCreateRequestInterface
{
    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->getDataString(FulfillmentMethodCreateRequestInterface::KEY_TYPE);
    }

    /**
     * @param string $type
     * @return self
     */
    public function setType(string $type): self
    {
        $this->setData(FulfillmentMethodCreateRequestInterface::KEY_TYPE, $type);
        return $this;
    }

    /**
     * @return string[]|null
     */
    public function getLineItemIds(): array|null
    {
        $value = $this->getData(FulfillmentMethodCreateRequestInterface::KEY_LINE_ITEM_IDS);
        return is_array($value) ? $value : null;
    }

    /**
     * @param string[]|null $lineItemIds
     * @return self
     */
    public function setLineItemIds(?array $lineItemIds): self
    {
        $this->setData(FulfillmentMethodCreateRequestInterface::KEY_LINE_ITEM_IDS, $lineItemIds);
        return $this;
    }

    /**
     * @return FulfillmentDestinationRequestInterface[]|null
     */
    public function getDestinations(): array|null
    {
        return $this->getDataArrayOfTypeOrNull(
            FulfillmentMethodCreateRequestInterface::KEY_DESTINATIONS,
            FulfillmentDestinationRequestInterface::class
        );
    }

    /**
     * @param FulfillmentDestinationRequestInterface[]|null $destinations
     * @return self
     */
    public function setDestinations(?array $destinations): self
    {
        $this->setData(FulfillmentMethodCreateRequestInterface::KEY_DESTINATIONS, $destinations);
        return $this;
    }

    /**
     * @return string|null
     */
    public function getSelectedDestinationId(): string|null
    {
        return $this->getDataStringOrNull(FulfillmentMethodCreateRequestInterface::KEY_SELECTED_DESTINATION_ID);
    }

    /**
     * @param string|null $selectedDestinationId
     * @return self
     */
    public function setSelectedDestinationId(?string $selectedDestinationId): self
    {
        $this->setData(FulfillmentMethodCreateRequestInterface::KEY_SELECTED_DESTINATION_ID, $selectedDestinationId);
        return $this;
    }

    /**
     * @return FulfillmentGroupCreateRequestInterface[]|null
     */
    public function getGroups(): array|null
    {
        return $this->getDataArrayOfTypeOrNull(
            FulfillmentMethodCreateRequestInterface::KEY_GROUPS,
            FulfillmentGroupCreateRequestInterface::class
        );
    }

    /**
     * @param FulfillmentGroupCreateRequestInterface[]|null $groups
     * @return self
     */
    public function setGroups(?array $groups): self
    {
        $this->setData(FulfillmentMethodCreateRequestInterface::KEY_GROUPS, $groups);
        return $this;
    }
}
