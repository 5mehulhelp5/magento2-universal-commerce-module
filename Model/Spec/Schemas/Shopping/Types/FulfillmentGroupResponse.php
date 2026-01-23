<?php

/**
 * @author Magebit <info@magebit.com>
 * @copyright Copyright (c) Magebit, Ltd. (https://magebit.com)
 * @license https://magebit.com/code-license
 */

declare(strict_types=1);

namespace Magebit\UniversalCommerce\Model\Spec\Schemas\Shopping\Types;

use Magebit\UniversalCommerce\Model\DataTransferObject;
use Magebit\UcpSpec\MutableApi\Schemas\Shopping\Types\FulfillmentGroupResponseInterface;
use Magebit\UcpSpec\MutableApi\Schemas\Shopping\Types\FulfillmentOptionResponseInterface;

class FulfillmentGroupResponse extends DataTransferObject implements FulfillmentGroupResponseInterface
{
    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->getDataString(FulfillmentGroupResponseInterface::KEY_ID);
    }

    /**
     * @param string $id
     * @return self
     */
    public function setId(string $id): self
    {
        $this->setData(FulfillmentGroupResponseInterface::KEY_ID, $id);
        return $this;
    }

    /**
     * @return string[]
     */
    public function getLineItemIds(): array
    {
        return $this->getDataArray(FulfillmentGroupResponseInterface::KEY_LINE_ITEM_IDS);
    }

    /**
     * @param string[] $lineItemIds
     * @return self
     */
    public function setLineItemIds(array $lineItemIds): self
    {
        $this->setData(FulfillmentGroupResponseInterface::KEY_LINE_ITEM_IDS, $lineItemIds);
        return $this;
    }

    /**
     * @return FulfillmentOptionResponseInterface[]|null
     */
    public function getOptions(): array|null
    {
        return $this->getDataArrayOfTypeOrNull(
            FulfillmentGroupResponseInterface::KEY_OPTIONS,
            FulfillmentOptionResponseInterface::class
        );
    }

    /**
     * @param FulfillmentOptionResponseInterface[]|null $options
     * @return self
     */
    public function setOptions(?array $options): self
    {
        $this->setData(FulfillmentGroupResponseInterface::KEY_OPTIONS, $options);
        return $this;
    }

    /**
     * @return string|null
     */
    public function getSelectedOptionId(): string|null
    {
        return $this->getDataStringOrNull(FulfillmentGroupResponseInterface::KEY_SELECTED_OPTION_ID);
    }

    /**
     * @param string|null $selectedOptionId
     * @return self
     */
    public function setSelectedOptionId(?string $selectedOptionId): self
    {
        $this->setData(FulfillmentGroupResponseInterface::KEY_SELECTED_OPTION_ID, $selectedOptionId);
        return $this;
    }
}
