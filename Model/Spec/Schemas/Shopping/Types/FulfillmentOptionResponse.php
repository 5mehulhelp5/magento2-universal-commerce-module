<?php

/**
 * @author Magebit <info@magebit.com>
 * @copyright Copyright (c) Magebit, Ltd. (https://magebit.com)
 * @license https://magebit.com/code-license
 */

declare(strict_types=1);

namespace Magebit\UniversalCommerce\Model\Spec\Schemas\Shopping\Types;

use Magebit\UniversalCommerce\Model\DataTransferObject;
use Magebit\UcpSpec\MutableApi\Schemas\Shopping\Types\FulfillmentOptionResponseInterface;
use Magebit\UcpSpec\MutableApi\Schemas\Shopping\Types\TotalResponseInterface;

class FulfillmentOptionResponse extends DataTransferObject implements FulfillmentOptionResponseInterface
{
    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->getDataString(FulfillmentOptionResponseInterface::KEY_ID);
    }

    /**
     * @param string $id
     * @return self
     */
    public function setId(string $id): self
    {
        $this->setData(FulfillmentOptionResponseInterface::KEY_ID, $id);
        return $this;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->getDataString(FulfillmentOptionResponseInterface::KEY_TITLE);
    }

    /**
     * @param string $title
     * @return self
     */
    public function setTitle(string $title): self
    {
        $this->setData(FulfillmentOptionResponseInterface::KEY_TITLE, $title);
        return $this;
    }

    /**
     * @return string|null
     */
    public function getDescription(): string|null
    {
        return $this->getDataStringOrNull(FulfillmentOptionResponseInterface::KEY_DESCRIPTION);
    }

    /**
     * @param string|null $description
     * @return self
     */
    public function setDescription(?string $description): self
    {
        $this->setData(FulfillmentOptionResponseInterface::KEY_DESCRIPTION, $description);
        return $this;
    }

    /**
     * @return string|null
     */
    public function getCarrier(): string|null
    {
        return $this->getDataStringOrNull(FulfillmentOptionResponseInterface::KEY_CARRIER);
    }

    /**
     * @param string|null $carrier
     * @return self
     */
    public function setCarrier(?string $carrier): self
    {
        $this->setData(FulfillmentOptionResponseInterface::KEY_CARRIER, $carrier);
        return $this;
    }

    /**
     * @return string|null
     */
    public function getEarliestFulfillmentTime(): string|null
    {
        return $this->getDataStringOrNull(FulfillmentOptionResponseInterface::KEY_EARLIEST_FULFILLMENT_TIME);
    }

    /**
     * @param string|null $earliestFulfillmentTime
     * @return self
     */
    public function setEarliestFulfillmentTime(?string $earliestFulfillmentTime): self
    {
        $this->setData(FulfillmentOptionResponseInterface::KEY_EARLIEST_FULFILLMENT_TIME, $earliestFulfillmentTime);
        return $this;
    }

    /**
     * @return string|null
     */
    public function getLatestFulfillmentTime(): string|null
    {
        return $this->getDataStringOrNull(FulfillmentOptionResponseInterface::KEY_LATEST_FULFILLMENT_TIME);
    }

    /**
     * @param string|null $latestFulfillmentTime
     * @return self
     */
    public function setLatestFulfillmentTime(?string $latestFulfillmentTime): self
    {
        $this->setData(FulfillmentOptionResponseInterface::KEY_LATEST_FULFILLMENT_TIME, $latestFulfillmentTime);
        return $this;
    }

    /**
     * @return TotalResponseInterface[]
     */
    public function getTotals(): array
    {
        return $this->getDataArrayOfType(
            FulfillmentOptionResponseInterface::KEY_TOTALS,
            TotalResponseInterface::class
        );
    }

    /**
     * @param TotalResponseInterface[] $totals
     * @return self
     */
    public function setTotals(array $totals): self
    {
        $this->setData(FulfillmentOptionResponseInterface::KEY_TOTALS, $totals);
        return $this;
    }
}
