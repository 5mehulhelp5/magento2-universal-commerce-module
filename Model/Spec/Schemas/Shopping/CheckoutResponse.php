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
use Magebit\UcpSpec\Api\Schemas\Shopping\CheckoutResponseInterface;
use Magebit\UcpSpec\Api\Schemas\UcpResponseCheckoutInterface;
use Magebit\UcpSpec\Api\Schemas\Shopping\Types\LineItemResponseInterface;
use Magebit\UcpSpec\Api\Schemas\Shopping\Types\BuyerInterface;
use Magebit\UcpSpec\Api\Schemas\Shopping\Types\TotalResponseInterface;
use Magebit\UcpSpec\Api\Schemas\Shopping\Types\MessageInterface;
use Magebit\UcpSpec\Api\Schemas\Shopping\Types\LinkInterface;
use Magebit\UcpSpec\Api\Schemas\Shopping\Types\OrderConfirmationInterface;

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
     * @return array<LineItemResponseInterface>
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
     * @return array<TotalResponseInterface>
     */
    public function getTotals(): array
    {
        return $this->getDataArrayOfType(
            CheckoutResponseInterface::KEY_TOTALS,
            TotalResponseInterface::class
        );
    }

    /**
     * @return array<MessageInterface>|null
     */
    public function getMessages(): array|null
    {
        return $this->getDataArrayOfTypeOrNull(
            CheckoutResponseInterface::KEY_MESSAGES,
            MessageInterface::class
        );
    }

    /**
     * @return array<LinkInterface>
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
}
