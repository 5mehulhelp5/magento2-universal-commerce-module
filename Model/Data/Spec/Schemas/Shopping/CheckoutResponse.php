<?php

/**
 * This file is part of the Magebit_UniversalCommerce package.
 *
 * @copyright Copyright (c) 2026 Magebit, Ltd. (https://magebit.com/)
 * @author    Magebit <info@magebit.com>
 * @license   MIT
 */

declare(strict_types=1);

namespace Magebit\UniversalCommerce\Model\Data\Spec\Schemas\Shopping;

use Magebit\UcpSpec\MutableApi\Schemas\Shopping\CheckoutResponseInterface;
use Magebit\UcpSpec\MutableApi\Schemas\Shopping\Types\BuyerInterface;
use Magebit\UcpSpec\MutableApi\Schemas\Shopping\Types\BuyerInterfaceFactory;
use Magebit\UcpSpec\MutableApi\Schemas\Shopping\Types\LineItemResponseInterface;
use Magebit\UcpSpec\MutableApi\Schemas\Shopping\Types\LineItemResponseInterfaceFactory;
use Magebit\UcpSpec\MutableApi\Schemas\Shopping\Types\LinkInterface;
use Magebit\UcpSpec\MutableApi\Schemas\Shopping\Types\LinkInterfaceFactory;
use Magebit\UcpSpec\MutableApi\Schemas\Shopping\Types\MessageInterface;
use Magebit\UcpSpec\MutableApi\Schemas\Shopping\Types\MessageInterfaceFactory;
use Magebit\UcpSpec\MutableApi\Schemas\Shopping\PaymentResponseInterface;
use Magebit\UcpSpec\MutableApi\Schemas\Shopping\PaymentResponseInterfaceFactory;
use Magebit\UcpSpec\MutableApi\Schemas\Shopping\Types\TotalResponseInterface;
use Magebit\UcpSpec\MutableApi\Schemas\Shopping\Types\TotalResponseInterfaceFactory;
use Magebit\UcpSpec\MutableApi\Schemas\UcpResponseCheckoutInterface;
use Magebit\UcpSpec\MutableApi\Schemas\UcpResponseCheckoutInterfaceFactory;
use Magebit\UcpSpec\MutableApi\Schemas\Shopping\Types\OrderConfirmationInterface;
use Magebit\UcpSpec\MutableApi\Schemas\Shopping\Types\OrderConfirmationInterfaceFactory;
use Magebit\UcpSpec\MutableApi\Schemas\Shopping\DiscountDiscountsObjectInterface;
use Magebit\UcpSpec\MutableApi\Schemas\Shopping\DiscountDiscountsObjectInterfaceFactory;
use Magebit\UniversalCommerce\Model\Data\DataTransferObject;

/**
 * Checkout Response Model
 */
class CheckoutResponse extends DataTransferObject implements CheckoutResponseInterface
{
    /**
     * Custom fields not in UCP spec interface
     */
    public const KEY_ORDER_ID = 'order_id';
    public const KEY_ORDER_PERMALINK_URL = 'order_permalink_url';

    /**
     * Discount capability extension field
     */
    public const KEY_DISCOUNTS = 'discounts';

    /**
     * @param BuyerInterfaceFactory $buyerFactory
     * @param LineItemResponseInterfaceFactory $lineItemFactory
     * @param LinkInterfaceFactory $linkFactory
     * @param MessageInterfaceFactory $messageFactory
     * @param PaymentResponseInterfaceFactory $paymentFactory
     * @param TotalResponseInterfaceFactory $totalFactory
     * @param UcpResponseCheckoutInterfaceFactory $ucpFactory
     * @param OrderConfirmationInterfaceFactory $orderFactory
     * @param DiscountDiscountsObjectInterfaceFactory $discountsFactory
     * @param array<mixed> $data
     */
    public function __construct(
        private readonly BuyerInterfaceFactory $buyerFactory,
        private readonly LineItemResponseInterfaceFactory $lineItemFactory,
        private readonly LinkInterfaceFactory $linkFactory,
        private readonly MessageInterfaceFactory $messageFactory,
        private readonly PaymentResponseInterfaceFactory $paymentFactory,
        private readonly TotalResponseInterfaceFactory $totalFactory,
        private readonly UcpResponseCheckoutInterfaceFactory $ucpFactory,
        private readonly OrderConfirmationInterfaceFactory $orderFactory,
        private readonly DiscountDiscountsObjectInterfaceFactory $discountsFactory,
        array $data = []
    ) {
        parent::__construct($data);
    }

    /**
     * @inheritDoc
     */
    public function getBuyer(): ?BuyerInterface
    {
        return $this->getDataInstance(self::KEY_BUYER, BuyerInterface::class, $this->buyerFactory->create(...));
    }

    /**
     * @inheritDoc
     */
    public function setBuyer(?BuyerInterface $buyer): CheckoutResponseInterface
    {
        return $this->setData(self::KEY_BUYER, $buyer);
    }

    /**
     * @inheritDoc
     */
    public function getContinueUrl(): ?string
    {
        return $this->getDataStringOrNull(self::KEY_CONTINUE_URL);
    }

    /**
     * @inheritDoc
     */
    public function setContinueUrl(?string $continueUrl): CheckoutResponseInterface
    {
        return $this->setData(self::KEY_CONTINUE_URL, $continueUrl);
    }

    /**
     * @inheritDoc
     */
    public function getCurrency(): string
    {
        return $this->getDataString(self::KEY_CURRENCY);
    }

    /**
     * @inheritDoc
     */
    public function setCurrency(string $currency): CheckoutResponseInterface
    {
        return $this->setData(self::KEY_CURRENCY, $currency);
    }

    /**
     * @inheritDoc
     */
    public function getExpiresAt(): ?string
    {
        return $this->getDataStringOrNull(self::KEY_EXPIRES_AT);
    }

    /**
     * @inheritDoc
     */
    public function setExpiresAt(?string $expiresAt): CheckoutResponseInterface
    {
        return $this->setData(self::KEY_EXPIRES_AT, $expiresAt);
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
    public function setId(string $id): CheckoutResponseInterface
    {
        return $this->setData(self::KEY_ID, $id);
    }

    /**
     * @inheritDoc
     */
    public function getLineItems(): array
    {
        return $this->getDataInstanceArray(
            self::KEY_LINE_ITEMS,
            LineItemResponseInterface::class,
            $this->lineItemFactory->create(...)
        );
    }

    /**
     * @inheritDoc
     */
    public function setLineItems(array $lineItems): CheckoutResponseInterface
    {
        return $this->setData(self::KEY_LINE_ITEMS, $lineItems);
    }

    /**
     * @inheritDoc
     */
    public function getLinks(): array
    {
        return $this->getDataInstanceArray(
            self::KEY_LINKS,
            LinkInterface::class,
            $this->linkFactory->create(...)
        );
    }

    /**
     * @inheritDoc
     */
    public function setLinks(array $links): CheckoutResponseInterface
    {
        return $this->setData(self::KEY_LINKS, $links);
    }

    /**
     * @inheritDoc
     */
    public function getMessages(): ?array
    {
        $messages = $this->getData(self::KEY_MESSAGES);
        if ($messages === null) {
            return null;
        }

        return $this->getDataInstanceArray(
            self::KEY_MESSAGES,
            MessageInterface::class,
            $this->messageFactory->create(...)
        );
    }

    /**
     * @inheritDoc
     */
    public function setMessages(?array $messages): CheckoutResponseInterface
    {
        return $this->setData(self::KEY_MESSAGES, $messages);
    }

    /**
     * @inheritDoc
     */
    public function getPayment(): PaymentResponseInterface
    {
        return $this->getDataInstance(self::KEY_PAYMENT, PaymentResponseInterface::class, $this->paymentFactory->create(...));
    }

    /**
     * @inheritDoc
     */
    public function setPayment(PaymentResponseInterface $payment): CheckoutResponseInterface
    {
        return $this->setData(self::KEY_PAYMENT, $payment);
    }

    /**
     * @inheritDoc
     */
    public function getStatus(): string
    {
        return $this->getDataString(self::KEY_STATUS);
    }

    /**
     * @inheritDoc
     */
    public function setStatus(string $status): CheckoutResponseInterface
    {
        return $this->setData(self::KEY_STATUS, $status);
    }

    /**
     * @inheritDoc
     */
    public function getTotals(): array
    {
        return $this->getDataInstanceArray(
            self::KEY_TOTALS,
            TotalResponseInterface::class,
            $this->totalFactory->create(...)
        );
    }

    /**
     * @inheritDoc
     */
    public function setTotals(array $totals): CheckoutResponseInterface
    {
        return $this->setData(self::KEY_TOTALS, $totals);
    }

    /**
     * @inheritDoc
     */
    public function getUcp(): UcpResponseCheckoutInterface
    {
        return $this->getDataInstance(self::KEY_UCP, UcpResponseCheckoutInterface::class, $this->ucpFactory->create(...));
    }

    /**
     * @inheritDoc
     */
    public function setUcp(UcpResponseCheckoutInterface $ucp): CheckoutResponseInterface
    {
        return $this->setData(self::KEY_UCP, $ucp);
    }

    /**
     * @inheritDoc
     */
    public function getOrder(): ?OrderConfirmationInterface
    {
        return $this->getDataInstance(self::KEY_ORDER, OrderConfirmationInterface::class, $this->orderFactory->create(...));
    }

    /**
     * @inheritDoc
     */
    public function setOrder(?OrderConfirmationInterface $order): CheckoutResponseInterface
    {
        return $this->setData(self::KEY_ORDER, $order);
    }

    /**
     * Get order ID (custom field, not in UCP spec)
     *
     * @return string|null
     */
    public function getOrderId(): ?string
    {
        return $this->getDataStringOrNull(self::KEY_ORDER_ID);
    }

    /**
     * Set order ID (custom field, not in UCP spec)
     *
     * @param string|null $orderId
     * @return self
     */
    public function setOrderId(?string $orderId): self
    {
        return $this->setData(self::KEY_ORDER_ID, $orderId);
    }

    /**
     * Get order permalink URL (custom field, not in UCP spec)
     *
     * @return string|null
     */
    public function getOrderPermalinkUrl(): ?string
    {
        return $this->getDataStringOrNull(self::KEY_ORDER_PERMALINK_URL);
    }

    /**
     * Set order permalink URL (custom field, not in UCP spec)
     *
     * @param string|null $url
     * @return self
     */
    public function setOrderPermalinkUrl(?string $url): self
    {
        return $this->setData(self::KEY_ORDER_PERMALINK_URL, $url);
    }

    /**
     * Get discounts (discount capability extension)
     *
     * @return DiscountDiscountsObjectInterface|null
     */
    public function getDiscounts(): ?DiscountDiscountsObjectInterface
    {
        return $this->getDataInstance(
            self::KEY_DISCOUNTS,
            DiscountDiscountsObjectInterface::class,
            $this->discountsFactory->create(...)
        );
    }

    /**
     * Set discounts (discount capability extension)
     *
     * @param DiscountDiscountsObjectInterface|null $discounts
     * @return self
     */
    public function setDiscounts(?DiscountDiscountsObjectInterface $discounts): self
    {
        return $this->setData(self::KEY_DISCOUNTS, $discounts);
    }
}
