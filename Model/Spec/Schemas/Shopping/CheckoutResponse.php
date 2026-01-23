<?php

/**
 * This file is part of the Magebit_UniversalCommerce package.
 *
 * @copyright Copyright (c) 2026 Magebit, Ltd. (https://magebit.com/)
 * @author    Magebit <info@magebit.com>
 * @license   MIT
 */

declare(strict_types=1);

namespace Magebit\UniversalCommerce\Model\Spec\Schemas\Shopping;

use Magebit\UniversalCommerce\Model\DataTransferObject;
use Magebit\UcpSpec\MutableApi\Schemas\Shopping\CheckoutResponseInterface;
use Magebit\UcpSpec\MutableApi\Schemas\UcpResponseCheckoutInterface;
use Magebit\UcpSpec\MutableApi\Schemas\Shopping\Types\LineItemResponseInterface;
use Magebit\UcpSpec\MutableApi\Schemas\Shopping\Types\BuyerInterface;
use Magebit\UcpSpec\MutableApi\Schemas\Shopping\Types\TotalResponseInterface;
use Magebit\UcpSpec\MutableApi\Schemas\Shopping\Types\MessageInterface;
use Magebit\UcpSpec\MutableApi\Schemas\Shopping\Types\LinkInterface;
use Magebit\UcpSpec\MutableApi\Schemas\Shopping\Types\OrderConfirmationInterface;
use Magebit\UcpSpec\MutableApi\Schemas\Shopping\PaymentResponseInterface;

class CheckoutResponse extends DataTransferObject implements CheckoutResponseInterface
{
    /**
     * @return UcpResponseCheckoutInterface
     */
    public function getUcp(): UcpResponseCheckoutInterface
    {
        return $this->getDataOfType(CheckoutResponseInterface::KEY_UCP, UcpResponseCheckoutInterface::class);
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->getDataString(CheckoutResponseInterface::KEY_ID);
    }

    /**
     * @return LineItemResponseInterface[]
     */
    public function getLineItems(): array
    {
        return $this->getDataArrayOfType(
            CheckoutResponseInterface::KEY_LINE_ITEMS,
            LineItemResponseInterface::class
        );
    }

    /**
     * @return BuyerInterface|null
     */
    public function getBuyer(): BuyerInterface|null
    {
        return $this->getDataOfTypeOrNull(CheckoutResponseInterface::KEY_BUYER, BuyerInterface::class);
    }

    /**
     * @return string
     */
    public function getStatus(): string
    {
        return $this->getDataString(CheckoutResponseInterface::KEY_STATUS);
    }

    /**
     * @return string
     */
    public function getCurrency(): string
    {
        return $this->getDataString(CheckoutResponseInterface::KEY_CURRENCY);
    }

    /**
     * @return TotalResponseInterface[]
     */
    public function getTotals(): array
    {
        return $this->getDataArrayOfType(
            CheckoutResponseInterface::KEY_TOTALS,
            TotalResponseInterface::class
        );
    }

    /**
     * @return MessageInterface[]|null
     */
    public function getMessages(): array|null
    {
        return $this->getDataArrayOfTypeOrNull(
            CheckoutResponseInterface::KEY_MESSAGES,
            MessageInterface::class
        );
    }

    /**
     * @return LinkInterface[]
     */
    public function getLinks(): array
    {
        return $this->getDataArrayOfType(
            CheckoutResponseInterface::KEY_LINKS,
            LinkInterface::class
        );
    }

    /**
     * @return string|null
     */
    public function getExpiresAt(): string|null
    {
        return $this->getDataStringOrNull(CheckoutResponseInterface::KEY_EXPIRES_AT);
    }

    /**
     * @return string|null
     */
    public function getContinueUrl(): string|null
    {
        return $this->getDataStringOrNull(CheckoutResponseInterface::KEY_CONTINUE_URL);
    }

    /**
     * @return PaymentResponseInterface
     */
    public function getPayment(): PaymentResponseInterface
    {
        return $this->getDataOfType(CheckoutResponseInterface::KEY_PAYMENT, PaymentResponseInterface::class);
    }

    /**
     * @return OrderConfirmationInterface|null
     */
    public function getOrder(): OrderConfirmationInterface|null
    {
        return $this->getDataOfTypeOrNull(CheckoutResponseInterface::KEY_ORDER, OrderConfirmationInterface::class);
    }

    /**
     * @param UcpResponseCheckoutInterface $ucp
     * @return self
     */
    public function setUcp(UcpResponseCheckoutInterface $ucp): self
    {
        $this->setData(CheckoutResponseInterface::KEY_UCP, $ucp);
        return $this;
    }

    /**
     * @param string $id
     * @return self
     */
    public function setId(string $id): self
    {
        $this->setData(CheckoutResponseInterface::KEY_ID, $id);
        return $this;
    }

    /**
     * @param LineItemResponseInterface[] $lineItems
     * @return self
     */
    public function setLineItems(array $lineItems): self
    {
        $this->setData(CheckoutResponseInterface::KEY_LINE_ITEMS, $lineItems);
        return $this;
    }

    /**
     * @param BuyerInterface|null $buyer
     * @return self
     */
    public function setBuyer(?BuyerInterface $buyer): self
    {
        $this->setData(CheckoutResponseInterface::KEY_BUYER, $buyer);
        return $this;
    }

    /**
     * @param string $status
     * @return self
     */
    public function setStatus(string $status): self
    {
        $this->setData(CheckoutResponseInterface::KEY_STATUS, $status);
        return $this;
    }

    /**
     * @param string $currency
     * @return self
     */
    public function setCurrency(string $currency): self
    {
        $this->setData(CheckoutResponseInterface::KEY_CURRENCY, $currency);
        return $this;
    }

    /**
     * @param TotalResponseInterface[] $totals
     * @return self
     */
    public function setTotals(array $totals): self
    {
        $this->setData(CheckoutResponseInterface::KEY_TOTALS, $totals);
        return $this;
    }

    /**
     * @param MessageInterface[]|null $messages
     * @return self
     */
    public function setMessages(?array $messages): self
    {
        $this->setData(CheckoutResponseInterface::KEY_MESSAGES, $messages);
        return $this;
    }

    /**
     * @param LinkInterface[] $links
     * @return self
     */
    public function setLinks(array $links): self
    {
        $this->setData(CheckoutResponseInterface::KEY_LINKS, $links);
        return $this;
    }

    /**
     * @param string|null $expiresAt
     * @return self
     */
    public function setExpiresAt(?string $expiresAt): self
    {
        $this->setData(CheckoutResponseInterface::KEY_EXPIRES_AT, $expiresAt);
        return $this;
    }

    /**
     * @param string|null $continueUrl
     * @return self
     */
    public function setContinueUrl(?string $continueUrl): self
    {
        $this->setData(CheckoutResponseInterface::KEY_CONTINUE_URL, $continueUrl);
        return $this;
    }

    /**
     * @param PaymentResponseInterface $payment
     * @return self
     */
    public function setPayment(PaymentResponseInterface $payment): self
    {
        $this->setData(CheckoutResponseInterface::KEY_PAYMENT, $payment);
        return $this;
    }

    /**
     * @param OrderConfirmationInterface|null $order
     * @return self
     */
    public function setOrder(?OrderConfirmationInterface $order): self
    {
        $this->setData(CheckoutResponseInterface::KEY_ORDER, $order);
        return $this;
    }
}
