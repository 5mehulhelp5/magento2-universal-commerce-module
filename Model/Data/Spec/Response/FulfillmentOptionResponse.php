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

use Magebit\UniversalCommerce\Api\Data\Spec\Response\FulfillmentOptionResponseInterface;
use Magebit\UniversalCommerce\Model\Data\DataTransferObject;

/**
 * Fulfillment Option Response Model
 */
class FulfillmentOptionResponse extends DataTransferObject implements FulfillmentOptionResponseInterface
{
    /**
     * @inheritDoc
     */
    public function getCarrier(): ?string
    {
        return $this->getDataStringOrNull(self::CARRIER);
    }

    /**
     * @inheritDoc
     */
    public function setCarrier(?string $carrier): FulfillmentOptionResponseInterface
    {
        return $this->setData(self::CARRIER, $carrier);
    }

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
    public function setDescription(?string $description): FulfillmentOptionResponseInterface
    {
        return $this->setData(self::DESCRIPTION, $description);
    }

    /**
     * @inheritDoc
     */
    public function getEarliestFulfillmentTime(): ?string
    {
        return $this->getDataStringOrNull(self::EARLIEST_FULFILLMENT_TIME);
    }

    /**
     * @inheritDoc
     */
    public function setEarliestFulfillmentTime(?string $earliestFulfillmentTime): FulfillmentOptionResponseInterface
    {
        return $this->setData(self::EARLIEST_FULFILLMENT_TIME, $earliestFulfillmentTime);
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
    public function setId(string $id): FulfillmentOptionResponseInterface
    {
        return $this->setData(self::ID, $id);
    }

    /**
     * @inheritDoc
     */
    public function getLatestFulfillmentTime(): ?string
    {
        return $this->getDataStringOrNull(self::LATEST_FULFILLMENT_TIME);
    }

    /**
     * @inheritDoc
     */
    public function setLatestFulfillmentTime(?string $latestFulfillmentTime): FulfillmentOptionResponseInterface
    {
        return $this->setData(self::LATEST_FULFILLMENT_TIME, $latestFulfillmentTime);
    }

    /**
     * @inheritDoc
     */
    public function getSubtotal(): ?float
    {
        $subtotal = $this->getData(self::SUBTOTAL);
        return $subtotal !== null ? (float) $subtotal : null;
    }

    /**
     * @inheritDoc
     */
    public function setSubtotal(?float $subtotal): FulfillmentOptionResponseInterface
    {
        return $this->setData(self::SUBTOTAL, $subtotal);
    }

    /**
     * @inheritDoc
     */
    public function getTax(): ?float
    {
        $tax = $this->getData(self::TAX);
        return $tax !== null ? (float) $tax : null;
    }

    /**
     * @inheritDoc
     */
    public function setTax(?float $tax): FulfillmentOptionResponseInterface
    {
        return $this->setData(self::TAX, $tax);
    }

    /**
     * @inheritDoc
     */
    public function getTitle(): string
    {
        return $this->getDataString(self::TITLE);
    }

    /**
     * @inheritDoc
     */
    public function setTitle(string $title): FulfillmentOptionResponseInterface
    {
        return $this->setData(self::TITLE, $title);
    }

    /**
     * @inheritDoc
     */
    public function getTotal(): float
    {
        return (float) $this->getData(self::TOTAL);
    }

    /**
     * @inheritDoc
     */
    public function setTotal(float $total): FulfillmentOptionResponseInterface
    {
        return $this->setData(self::TOTAL, $total);
    }
}
