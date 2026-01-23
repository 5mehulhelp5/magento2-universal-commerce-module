<?php

/**
 * @author Magebit <info@magebit.com>
 * @copyright Copyright (c) Magebit, Ltd. (https://magebit.com)
 * @license https://magebit.com/code-license
 */

declare(strict_types=1);

namespace Magebit\UniversalCommerce\Model\Spec\Schemas\Shopping\Types;

use Magebit\UniversalCommerce\Model\DataTransferObject;
use Magebit\UcpSpec\MutableApi\Schemas\Shopping\Types\FulfillmentAvailableMethodResponseInterface;

class FulfillmentAvailableMethodResponse extends DataTransferObject implements FulfillmentAvailableMethodResponseInterface
{
    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->getDataString(FulfillmentAvailableMethodResponseInterface::KEY_TYPE);
    }

    /**
     * @param string $type
     * @return self
     */
    public function setType(string $type): self
    {
        $this->setData(FulfillmentAvailableMethodResponseInterface::KEY_TYPE, $type);
        return $this;
    }

    /**
     * @return string[]
     */
    public function getLineItemIds(): array
    {
        return $this->getDataArray(FulfillmentAvailableMethodResponseInterface::KEY_LINE_ITEM_IDS);
    }

    /**
     * @param string[] $lineItemIds
     * @return self
     */
    public function setLineItemIds(array $lineItemIds): self
    {
        $this->setData(FulfillmentAvailableMethodResponseInterface::KEY_LINE_ITEM_IDS, $lineItemIds);
        return $this;
    }

    /**
     * @return string|null
     */
    public function getFulfillableOn(): string|null
    {
        return $this->getDataStringOrNull(FulfillmentAvailableMethodResponseInterface::KEY_FULFILLABLE_ON);
    }

    /**
     * @param string|null $fulfillableOn
     * @return self
     */
    public function setFulfillableOn(?string $fulfillableOn): self
    {
        $this->setData(FulfillmentAvailableMethodResponseInterface::KEY_FULFILLABLE_ON, $fulfillableOn);
        return $this;
    }

    /**
     * @return string|null
     */
    public function getDescription(): string|null
    {
        return $this->getDataStringOrNull(FulfillmentAvailableMethodResponseInterface::KEY_DESCRIPTION);
    }

    /**
     * @param string|null $description
     * @return self
     */
    public function setDescription(?string $description): self
    {
        $this->setData(FulfillmentAvailableMethodResponseInterface::KEY_DESCRIPTION, $description);
        return $this;
    }
}
