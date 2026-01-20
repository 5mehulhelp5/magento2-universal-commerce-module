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

use Magebit\UcpSpec\MutableApi\Schemas\Shopping\Types\FulfillmentAvailableMethodResponseInterface;
use Magebit\UniversalCommerce\Model\Data\DataTransferObject;

/**
 * Fulfillment Available Method Response Model
 */
class FulfillmentAvailableMethodResponse extends DataTransferObject implements FulfillmentAvailableMethodResponseInterface
{
    /**
     * @inheritDoc
     */
    public function getDescription(): ?string
    {
        return $this->getDataStringOrNull(self::KEY_DESCRIPTION);
    }

    /**
     * @inheritDoc
     */
    public function setDescription(?string $description): FulfillmentAvailableMethodResponseInterface
    {
        return $this->setData(self::KEY_DESCRIPTION, $description);
    }

    /**
     * @inheritDoc
     */
    public function getFulfillableOn(): ?string
    {
        return $this->getDataStringOrNull(self::KEY_FULFILLABLE_ON);
    }

    /**
     * @inheritDoc
     */
    public function setFulfillableOn(?string $fulfillableOn): FulfillmentAvailableMethodResponseInterface
    {
        return $this->setData(self::KEY_FULFILLABLE_ON, $fulfillableOn);
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
    public function setLineItemIds(array $lineItemIds): FulfillmentAvailableMethodResponseInterface
    {
        return $this->setData(self::KEY_LINE_ITEM_IDS, $lineItemIds);
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
    public function setType(string $type): FulfillmentAvailableMethodResponseInterface
    {
        return $this->setData(self::KEY_TYPE, $type);
    }
}
