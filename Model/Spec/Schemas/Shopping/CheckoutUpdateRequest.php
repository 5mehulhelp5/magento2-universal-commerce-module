<?php

/**
 * @author Magebit <info@magebit.com>
 * @copyright Copyright (c) Magebit, Ltd. (https://magebit.com)
 * @license https://magebit.com/code-license
 */

declare(strict_types=1);

namespace Magebit\UniversalCommerce\Model\Spec\Schemas\Shopping;

use Magebit\UniversalCommerce\Model\DataTransferObject;
use Magebit\UniversalCommerce\Api\Service\Shopping\CheckoutUpdateRequestInterface;
use Magebit\UcpSpec\MutableApi\Schemas\Shopping\PaymentUpdateRequestInterface;
use Magebit\UcpSpec\MutableApi\Schemas\Shopping\Types\LineItemUpdateRequestInterface;
use Magebit\UcpSpec\MutableApi\Schemas\Shopping\Types\BuyerInterface;
use Magebit\UcpSpec\MutableApi\Schemas\Shopping\Types\FulfillmentRequestInterface;

class CheckoutUpdateRequest extends DataTransferObject implements CheckoutUpdateRequestInterface
{
    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->getDataString(CheckoutUpdateRequestInterface::KEY_ID);
    }

    /**
     * @param string $id
     * @return self
     */
    public function setId(string $id): self
    {
        $this->setData(CheckoutUpdateRequestInterface::KEY_ID, $id);
        return $this;
    }

    /**
     * @return LineItemUpdateRequestInterface[]
     */
    public function getLineItems(): array
    {
        return $this->getDataArrayOfType(
            CheckoutUpdateRequestInterface::KEY_LINE_ITEMS,
            LineItemUpdateRequestInterface::class
        );
    }

    /**
     * @param LineItemUpdateRequestInterface[] $lineItems
     * @return self
     */
    public function setLineItems(array $lineItems): self
    {
        $this->setData(CheckoutUpdateRequestInterface::KEY_LINE_ITEMS, $lineItems);
        return $this;
    }

    /**
     * @return BuyerInterface|null
     */
    public function getBuyer(): BuyerInterface|null
    {
        return $this->getDataOfTypeOrNull(CheckoutUpdateRequestInterface::KEY_BUYER, BuyerInterface::class);
    }

    /**
     * @param BuyerInterface|null $buyer
     * @return self
     */
    public function setBuyer(?BuyerInterface $buyer): self
    {
        $this->setData(CheckoutUpdateRequestInterface::KEY_BUYER, $buyer);
        return $this;
    }

    /**
     * @return string
     */
    public function getCurrency(): string
    {
        return $this->getDataString(CheckoutUpdateRequestInterface::KEY_CURRENCY);
    }

    /**
     * @param string $currency
     * @return self
     */
    public function setCurrency(string $currency): self
    {
        $this->setData(CheckoutUpdateRequestInterface::KEY_CURRENCY, $currency);
        return $this;
    }

    /**
     * @return PaymentUpdateRequestInterface
     */
    public function getPayment(): PaymentUpdateRequestInterface
    {
        return $this->getDataOfType(CheckoutUpdateRequestInterface::KEY_PAYMENT, PaymentUpdateRequestInterface::class);
    }

    /**
     * @param PaymentUpdateRequestInterface $payment
     * @return self
     */
    public function setPayment(PaymentUpdateRequestInterface $payment): self
    {
        $this->setData(CheckoutUpdateRequestInterface::KEY_PAYMENT, $payment);
        return $this;
    }

    /**
     * @return FulfillmentRequestInterface|null
     */
    public function getFulfillment(): ?FulfillmentRequestInterface
    {
        return $this->getDataOfTypeOrNull('fulfillment', FulfillmentRequestInterface::class);
    }

    /**
     * @param FulfillmentRequestInterface|null $fulfillment
     * @return self
     */
    public function setFulfillment(?FulfillmentRequestInterface $fulfillment): self
    {
        $this->setData('fulfillment', $fulfillment);
        return $this;
    }
}
