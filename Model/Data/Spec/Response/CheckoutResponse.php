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

use Magebit\UniversalCommerce\Api\Data\Spec\Response\CheckoutResponseInterface;
use Magebit\UniversalCommerce\Api\Data\Spec\BuyerInterface;
use Magebit\UniversalCommerce\Api\Data\Spec\BuyerInterfaceFactory;
use Magebit\UniversalCommerce\Api\Data\Spec\Response\LineItemResponseInterface;
use Magebit\UniversalCommerce\Api\Data\Spec\Response\LineItemResponseInterfaceFactory;
use Magebit\UniversalCommerce\Api\Data\Spec\Response\LinkInterface;
use Magebit\UniversalCommerce\Api\Data\Spec\Response\LinkInterfaceFactory;
use Magebit\UniversalCommerce\Api\Data\Response\MessageInterface;
use Magebit\UniversalCommerce\Api\Data\Response\MessageInterfaceFactory;
use Magebit\UniversalCommerce\Api\Data\Spec\Response\PaymentResponseInterface;
use Magebit\UniversalCommerce\Api\Data\Spec\Response\PaymentResponseInterfaceFactory;
use Magebit\UniversalCommerce\Api\Data\Spec\Response\PlatformConfigInterface;
use Magebit\UniversalCommerce\Api\Data\Spec\Response\PlatformConfigInterfaceFactory;
use Magebit\UniversalCommerce\Api\Data\Spec\Response\TotalResponseInterface;
use Magebit\UniversalCommerce\Api\Data\Spec\Response\TotalResponseInterfaceFactory;
use Magebit\UniversalCommerce\Api\Data\Spec\Response\UcpCheckoutResponseInterface;
use Magebit\UniversalCommerce\Api\Data\Spec\Response\UcpCheckoutResponseInterfaceFactory;
use Magebit\UniversalCommerce\Api\Data\Spec\Response\FulfillmentResponseInterface;
use Magebit\UniversalCommerce\Api\Data\Spec\Response\FulfillmentResponseInterfaceFactory;
use Magebit\UniversalCommerce\Model\Data\DataTransferObject;

/**
 * Checkout Response Model
 */
class CheckoutResponse extends DataTransferObject implements CheckoutResponseInterface
{
    /**
     * @param BuyerInterfaceFactory $buyerFactory
     * @param LineItemResponseInterfaceFactory $lineItemFactory
     * @param LinkInterfaceFactory $linkFactory
     * @param MessageInterfaceFactory $messageFactory
     * @param PaymentResponseInterfaceFactory $paymentFactory
     * @param PlatformConfigInterfaceFactory $platformFactory
     * @param TotalResponseInterfaceFactory $totalFactory
     * @param UcpCheckoutResponseInterfaceFactory $ucpFactory
     * @param FulfillmentResponseInterfaceFactory $fulfillmentFactory
     * @param array<mixed> $data
     */
    public function __construct(
        private readonly BuyerInterfaceFactory $buyerFactory,
        private readonly LineItemResponseInterfaceFactory $lineItemFactory,
        private readonly LinkInterfaceFactory $linkFactory,
        private readonly MessageInterfaceFactory $messageFactory,
        private readonly PaymentResponseInterfaceFactory $paymentFactory,
        private readonly PlatformConfigInterfaceFactory $platformFactory,
        private readonly TotalResponseInterfaceFactory $totalFactory,
        private readonly UcpCheckoutResponseInterfaceFactory $ucpFactory,
        private readonly FulfillmentResponseInterfaceFactory $fulfillmentFactory,
        array $data = []
    ) {
        parent::__construct($data);
    }

    /**
     * @inheritDoc
     */
    public function getBuyer(): ?BuyerInterface
    {
        return $this->getDataInstance(self::BUYER, BuyerInterface::class, $this->buyerFactory->create(...));
    }

    /**
     * @inheritDoc
     */
    public function setBuyer(?BuyerInterface $buyer): CheckoutResponseInterface
    {
        return $this->setData(self::BUYER, $buyer);
    }

    /**
     * @inheritDoc
     */
    public function getContinueUrl(): ?string
    {
        return $this->getDataStringOrNull(self::CONTINUE_URL);
    }

    /**
     * @inheritDoc
     */
    public function setContinueUrl(?string $continueUrl): CheckoutResponseInterface
    {
        return $this->setData(self::CONTINUE_URL, $continueUrl);
    }

    /**
     * @inheritDoc
     */
    public function getCurrency(): string
    {
        return $this->getDataString(self::CURRENCY);
    }

    /**
     * @inheritDoc
     */
    public function setCurrency(string $currency): CheckoutResponseInterface
    {
        return $this->setData(self::CURRENCY, $currency);
    }

    /**
     * @inheritDoc
     */
    public function getExpiresAt(): ?string
    {
        return $this->getDataStringOrNull(self::EXPIRES_AT);
    }

    /**
     * @inheritDoc
     */
    public function setExpiresAt(?string $expiresAt): CheckoutResponseInterface
    {
        return $this->setData(self::EXPIRES_AT, $expiresAt);
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
    public function setId(string $id): CheckoutResponseInterface
    {
        return $this->setData(self::ID, $id);
    }

    /**
     * @inheritDoc
     */
    public function getLineItems(): array
    {
        return $this->getDataInstanceArray(
            self::LINE_ITEMS,
            LineItemResponseInterface::class,
            $this->lineItemFactory->create(...)
        );
    }

    /**
     * @inheritDoc
     */
    public function setLineItems(array $lineItems): CheckoutResponseInterface
    {
        return $this->setData(self::LINE_ITEMS, $lineItems);
    }

    /**
     * @inheritDoc
     */
    public function getLinks(): array
    {
        return $this->getDataInstanceArray(
            self::LINKS,
            LinkInterface::class,
            $this->linkFactory->create(...)
        );
    }

    /**
     * @inheritDoc
     */
    public function setLinks(array $links): CheckoutResponseInterface
    {
        return $this->setData(self::LINKS, $links);
    }

    /**
     * @inheritDoc
     */
    public function getMessages(): ?array
    {
        $messages = $this->getData(self::MESSAGES);
        if ($messages === null) {
            return null;
        }

        return $this->getDataInstanceArray(
            self::MESSAGES,
            MessageInterface::class,
            $this->messageFactory->create(...)
        );
    }

    /**
     * @inheritDoc
     */
    public function setMessages(?array $messages): CheckoutResponseInterface
    {
        return $this->setData(self::MESSAGES, $messages);
    }

    /**
     * @inheritDoc
     */
    public function getOrderId(): ?string
    {
        return $this->getDataStringOrNull(self::ORDER_ID);
    }

    /**
     * @inheritDoc
     */
    public function setOrderId(?string $orderId): CheckoutResponseInterface
    {
        return $this->setData(self::ORDER_ID, $orderId);
    }

    /**
     * @inheritDoc
     */
    public function getOrderPermalinkUrl(): ?string
    {
        return $this->getDataStringOrNull(self::ORDER_PERMALINK_URL);
    }

    /**
     * @inheritDoc
     */
    public function setOrderPermalinkUrl(?string $orderPermalinkUrl): CheckoutResponseInterface
    {
        return $this->setData(self::ORDER_PERMALINK_URL, $orderPermalinkUrl);
    }

    /**
     * @inheritDoc
     */
    public function getPayment(): PaymentResponseInterface
    {
        return $this->getDataInstance(self::PAYMENT, PaymentResponseInterface::class, $this->paymentFactory->create(...));
    }

    /**
     * @inheritDoc
     */
    public function setPayment(PaymentResponseInterface $payment): CheckoutResponseInterface
    {
        return $this->setData(self::PAYMENT, $payment);
    }

    /**
     * @inheritDoc
     */
    public function getPlatform(): ?PlatformConfigInterface
    {
        return $this->getDataInstance(self::PLATFORM, PlatformConfigInterface::class, $this->platformFactory->create(...));
    }

    /**
     * @inheritDoc
     */
    public function setPlatform(?PlatformConfigInterface $platform): CheckoutResponseInterface
    {
        return $this->setData(self::PLATFORM, $platform);
    }

    /**
     * @inheritDoc
     */
    public function getStatus(): string
    {
        return $this->getDataString(self::STATUS);
    }

    /**
     * @inheritDoc
     */
    public function setStatus(string $status): CheckoutResponseInterface
    {
        return $this->setData(self::STATUS, $status);
    }

    /**
     * @inheritDoc
     */
    public function getTotals(): array
    {
        return $this->getDataInstanceArray(
            self::TOTALS,
            TotalResponseInterface::class,
            $this->totalFactory->create(...)
        );
    }

    /**
     * @inheritDoc
     */
    public function setTotals(array $totals): CheckoutResponseInterface
    {
        return $this->setData(self::TOTALS, $totals);
    }

    /**
     * @inheritDoc
     */
    public function getUcp(): UcpCheckoutResponseInterface
    {
        return $this->getDataInstance(self::UCP, UcpCheckoutResponseInterface::class, $this->ucpFactory->create(...));
    }

    /**
     * @inheritDoc
     */
    public function setUcp(UcpCheckoutResponseInterface $ucp): CheckoutResponseInterface
    {
        return $this->setData(self::UCP, $ucp);
    }

    /**
     * @inheritDoc
     */
    public function getFulfillment(): ?FulfillmentResponseInterface
    {
        return $this->getDataInstance(self::FULFILLMENT, FulfillmentResponseInterface::class, $this->fulfillmentFactory->create(...));
    }

    /**
     * @inheritDoc
     */
    public function setFulfillment(?FulfillmentResponseInterface $fulfillment): CheckoutResponseInterface
    {
        return $this->setData(self::FULFILLMENT, $fulfillment);
    }
}
