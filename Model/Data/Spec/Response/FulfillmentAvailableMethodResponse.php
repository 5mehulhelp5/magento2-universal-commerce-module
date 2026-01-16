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

use Magebit\UniversalCommerce\Api\Data\Spec\Response\FulfillmentAvailableMethodResponseInterface;
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
        return $this->getDataStringOrNull(self::DESCRIPTION);
    }

    /**
     * @inheritDoc
     */
    public function setDescription(?string $description): FulfillmentAvailableMethodResponseInterface
    {
        return $this->setData(self::DESCRIPTION, $description);
    }

    /**
     * @inheritDoc
     */
    public function getFulfillableOn(): ?string
    {
        return $this->getDataStringOrNull(self::FULFILLABLE_ON);
    }

    /**
     * @inheritDoc
     */
    public function setFulfillableOn(?string $fulfillableOn): FulfillmentAvailableMethodResponseInterface
    {
        return $this->setData(self::FULFILLABLE_ON, $fulfillableOn);
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
    public function setLineItemIds(array $lineItemIds): FulfillmentAvailableMethodResponseInterface
    {
        return $this->setData(self::LINE_ITEM_IDS, $lineItemIds);
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
    public function setType(string $type): FulfillmentAvailableMethodResponseInterface
    {
        return $this->setData(self::TYPE, $type);
    }
}
