<?php

/**
 * @author Magebit <info@magebit.com>
 * @copyright Copyright (c) Magebit, Ltd. (https://magebit.com)
 * @license https://magebit.com/code-license
 */

declare(strict_types=1);

namespace Magebit\UniversalCommerce\Model\Spec\Schemas\Shopping;

use Magebit\UniversalCommerce\Model\DataTransferObject;
use Magebit\UcpSpec\MutableApi\Schemas\Shopping\FulfillmentCheckoutInterface;
use Magebit\UcpSpec\MutableApi\Schemas\UcpResponseCheckoutInterface;
use Magebit\UcpSpec\MutableApi\Schemas\Shopping\Types\LineItemResponseInterface;
use Magebit\UcpSpec\MutableApi\Schemas\Shopping\Types\BuyerInterface;
use Magebit\UcpSpec\MutableApi\Schemas\Shopping\Types\TotalResponseInterface;
use Magebit\UcpSpec\MutableApi\Schemas\Shopping\Types\MessageInterface;
use Magebit\UcpSpec\MutableApi\Schemas\Shopping\Types\LinkInterface;
use Magebit\UcpSpec\MutableApi\Schemas\Shopping\Types\OrderConfirmationInterface;
use Magebit\UcpSpec\MutableApi\Schemas\Shopping\PaymentResponseInterface;
use Magebit\UcpSpec\MutableApi\Schemas\Shopping\FulfillmentFulfillmentInterface;
use Magebit\UcpSpec\MutableApi\Schemas\Shopping\DiscountDiscountsObjectInterface;

class FulfillmentCheckout extends DataTransferObject implements FulfillmentCheckoutInterface
{
    /**
     * @return UcpResponseCheckoutInterface
     */
    public function getUcp(): UcpResponseCheckoutInterface
    {
        return $this->getDataOfType(FulfillmentCheckoutInterface::KEY_UCP, UcpResponseCheckoutInterface::class);
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->getDataString(FulfillmentCheckoutInterface::KEY_ID);
    }

    /**
     * @return LineItemResponseInterface[]
     */
    public function getLineItems(): array
    {
        return $this->getDataArrayOfType(
            FulfillmentCheckoutInterface::KEY_LINE_ITEMS,
            LineItemResponseInterface::class
        );
    }

    /**
     * @return BuyerInterface|null
     */
    public function getBuyer(): BuyerInterface|null
    {
        return $this->getDataOfTypeOrNull(FulfillmentCheckoutInterface::KEY_BUYER, BuyerInterface::class);
    }

    /**
     * @return string
     */
    public function getStatus(): string
    {
        return $this->getDataString(FulfillmentCheckoutInterface::KEY_STATUS);
    }

    /**
     * @return string
     */
    public function getCurrency(): string
    {
        return $this->getDataString(FulfillmentCheckoutInterface::KEY_CURRENCY);
    }

    /**
     * @return TotalResponseInterface[]
     */
    public function getTotals(): array
    {
        return $this->getDataArrayOfType(
            FulfillmentCheckoutInterface::KEY_TOTALS,
            TotalResponseInterface::class
        );
    }

    /**
     * @return MessageInterface[]|null
     */
    public function getMessages(): array|null
    {
        return $this->getDataArrayOfTypeOrNull(
            FulfillmentCheckoutInterface::KEY_MESSAGES,
            MessageInterface::class
        );
    }

    /**
     * @return LinkInterface[]
     */
    public function getLinks(): array
    {
        return $this->getDataArrayOfType(
            FulfillmentCheckoutInterface::KEY_LINKS,
            LinkInterface::class
        );
    }

    /**
     * @return string|null
     */
    public function getExpiresAt(): string|null
    {
        return $this->getDataStringOrNull(FulfillmentCheckoutInterface::KEY_EXPIRES_AT);
    }

    /**
     * @return string|null
     */
    public function getContinueUrl(): string|null
    {
        return $this->getDataStringOrNull(FulfillmentCheckoutInterface::KEY_CONTINUE_URL);
    }

    /**
     * @return PaymentResponseInterface
     */
    public function getPayment(): PaymentResponseInterface
    {
        return $this->getDataOfType(FulfillmentCheckoutInterface::KEY_PAYMENT, PaymentResponseInterface::class);
    }

    /**
     * @return OrderConfirmationInterface|null
     */
    public function getOrder(): OrderConfirmationInterface|null
    {
        return $this->getDataOfTypeOrNull(FulfillmentCheckoutInterface::KEY_ORDER, OrderConfirmationInterface::class);
    }

    /**
     * @return FulfillmentFulfillmentInterface|null
     */
    public function getFulfillment(): FulfillmentFulfillmentInterface|null
    {
        return $this->getDataOfTypeOrNull(
            FulfillmentCheckoutInterface::KEY_FULFILLMENT,
            FulfillmentFulfillmentInterface::class
        );
    }

    /**
     * @param UcpResponseCheckoutInterface $ucp
     * @return self
     */
    public function setUcp(UcpResponseCheckoutInterface $ucp): self
    {
        $this->setData(FulfillmentCheckoutInterface::KEY_UCP, $ucp);
        return $this;
    }

    /**
     * @param string $id
     * @return self
     */
    public function setId(string $id): self
    {
        $this->setData(FulfillmentCheckoutInterface::KEY_ID, $id);
        return $this;
    }

    /**
     * @param LineItemResponseInterface[] $lineItems
     * @return self
     */
    public function setLineItems(array $lineItems): self
    {
        $this->setData(FulfillmentCheckoutInterface::KEY_LINE_ITEMS, $lineItems);
        return $this;
    }

    /**
     * @param BuyerInterface|null $buyer
     * @return self
     */
    public function setBuyer(?BuyerInterface $buyer): self
    {
        $this->setData(FulfillmentCheckoutInterface::KEY_BUYER, $buyer);
        return $this;
    }

    /**
     * @param string $status
     * @return self
     */
    public function setStatus(string $status): self
    {
        $this->setData(FulfillmentCheckoutInterface::KEY_STATUS, $status);
        return $this;
    }

    /**
     * @param string $currency
     * @return self
     */
    public function setCurrency(string $currency): self
    {
        $this->setData(FulfillmentCheckoutInterface::KEY_CURRENCY, $currency);
        return $this;
    }

    /**
     * @param TotalResponseInterface[] $totals
     * @return self
     */
    public function setTotals(array $totals): self
    {
        $this->setData(FulfillmentCheckoutInterface::KEY_TOTALS, $totals);
        return $this;
    }

    /**
     * @param MessageInterface[]|null $messages
     * @return self
     */
    public function setMessages(?array $messages): self
    {
        $this->setData(FulfillmentCheckoutInterface::KEY_MESSAGES, $messages);
        return $this;
    }

    /**
     * @param LinkInterface[] $links
     * @return self
     */
    public function setLinks(array $links): self
    {
        $this->setData(FulfillmentCheckoutInterface::KEY_LINKS, $links);
        return $this;
    }

    /**
     * @param string|null $expiresAt
     * @return self
     */
    public function setExpiresAt(?string $expiresAt): self
    {
        $this->setData(FulfillmentCheckoutInterface::KEY_EXPIRES_AT, $expiresAt);
        return $this;
    }

    /**
     * @param string|null $continueUrl
     * @return self
     */
    public function setContinueUrl(?string $continueUrl): self
    {
        $this->setData(FulfillmentCheckoutInterface::KEY_CONTINUE_URL, $continueUrl);
        return $this;
    }

    /**
     * @param PaymentResponseInterface $payment
     * @return self
     */
    public function setPayment(PaymentResponseInterface $payment): self
    {
        $this->setData(FulfillmentCheckoutInterface::KEY_PAYMENT, $payment);
        return $this;
    }

    /**
     * @param OrderConfirmationInterface|null $order
     * @return self
     */
    public function setOrder(?OrderConfirmationInterface $order): self
    {
        $this->setData(FulfillmentCheckoutInterface::KEY_ORDER, $order);
        return $this;
    }

    /**
     * @param FulfillmentFulfillmentInterface|null $fulfillment
     * @return self
     */
    public function setFulfillment(?FulfillmentFulfillmentInterface $fulfillment): self
    {
        $this->setData(FulfillmentCheckoutInterface::KEY_FULFILLMENT, $fulfillment);
        return $this;
    }

    /**
     * @return DiscountDiscountsObjectInterface|null
     */
    public function getDiscounts(): DiscountDiscountsObjectInterface|null
    {
        return $this->getDataOfTypeOrNull('discounts', DiscountDiscountsObjectInterface::class);
    }

    /**
     * @param DiscountDiscountsObjectInterface|null $discounts
     * @return self
     */
    public function setDiscounts(?DiscountDiscountsObjectInterface $discounts): self
    {
        $this->setData('discounts', $discounts);
        return $this;
    }
}
