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

use Magebit\UcpSpec\MutableApi\Schemas\Shopping\Types\FulfillmentOptionResponseInterface;
use Magebit\UniversalCommerce\Model\Data\DataTransferObject;

/**
 * Fulfillment Option Response Model
 */
class FulfillmentOptionResponse extends DataTransferObject implements FulfillmentOptionResponseInterface
{
    /**
     * @inheritDoc
     */
    public function getTitle(): string
    {
        return $this->getDataString(self::KEY_TITLE);
    }

    /**
     * @inheritDoc
     */
    public function setTitle(string $title): FulfillmentOptionResponseInterface
    {
        return $this->setData(self::KEY_TITLE, $title);
    }

    /**
     * @inheritDoc
     */
    public function getCarrier(): ?string
    {
        return $this->getDataStringOrNull(self::KEY_CARRIER);
    }

    /**
     * @inheritDoc
     */
    public function setCarrier(?string $carrier): FulfillmentOptionResponseInterface
    {
        return $this->setData(self::KEY_CARRIER, $carrier);
    }

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
    public function setDescription(?string $description): FulfillmentOptionResponseInterface
    {
        return $this->setData(self::KEY_DESCRIPTION, $description);
    }

    /**
     * @inheritDoc
     */
    public function getEarliestFulfillmentTime(): ?string
    {
        return $this->getDataStringOrNull(self::KEY_EARLIEST_FULFILLMENT_TIME);
    }

    /**
     * @inheritDoc
     */
    public function setEarliestFulfillmentTime(?string $earliestFulfillmentTime): FulfillmentOptionResponseInterface
    {
        return $this->setData(self::KEY_EARLIEST_FULFILLMENT_TIME, $earliestFulfillmentTime);
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
    public function setId(string $id): FulfillmentOptionResponseInterface
    {
        return $this->setData(self::KEY_ID, $id);
    }

    /**
     * @inheritDoc
     */
    public function getLatestFulfillmentTime(): ?string
    {
        return $this->getDataStringOrNull(self::KEY_LATEST_FULFILLMENT_TIME);
    }

    /**
     * @inheritDoc
     */
    public function setLatestFulfillmentTime(?string $latestFulfillmentTime): FulfillmentOptionResponseInterface
    {
        return $this->setData(self::KEY_LATEST_FULFILLMENT_TIME, $latestFulfillmentTime);
    }

    /**
     * @inheritDoc
     */
    public function getTotals(): array
    {
        return $this->getData(self::KEY_TOTALS) ?? [];
    }

    /**
     * @inheritDoc
     */
    public function setTotals(array $totals): FulfillmentOptionResponseInterface
    {
        return $this->setData(self::KEY_TOTALS, $totals);
    }
}
