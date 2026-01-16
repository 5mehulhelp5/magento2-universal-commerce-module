<?php

/**
 * This file is part of the Magebit_UniversalCommerce package.
 *
 * @copyright Copyright (c) 2026 Magebit, Ltd. (https://magebit.com/)
 * @author    Magebit <info@magebit.com>
 * @license   MIT
 */

declare(strict_types=1);

namespace Magebit\UniversalCommerce\Api\Data\Spec\Response;

use Magebit\UniversalCommerce\Api\Data\Spec\BuyerInterface;
use Magebit\UniversalCommerce\Api\Data\Response\MessageInterface;

/**
 * Checkout Response Interface
 * Main interface for the checkout response
 */
interface CheckoutResponseInterface
{
    public const BUYER = 'buyer';
    public const CONTINUE_URL = 'continue_url';
    public const CURRENCY = 'currency';
    public const EXPIRES_AT = 'expires_at';
    public const ID = 'id';
    public const LINE_ITEMS = 'line_items';
    public const LINKS = 'links';
    public const MESSAGES = 'messages';
    public const ORDER_ID = 'order_id';
    public const ORDER_PERMALINK_URL = 'order_permalink_url';
    public const PAYMENT = 'payment';
    public const PLATFORM = 'platform';
    public const STATUS = 'status';
    public const TOTALS = 'totals';
    public const UCP = 'ucp';
    public const FULFILLMENT = 'fulfillment';

    /**
     * Get buyer
     *
     * @return BuyerInterface|null
     */
    public function getBuyer(): ?BuyerInterface;

    /**
     * Set buyer
     *
     * @param BuyerInterface|null $buyer
     * @return $this
     */
    public function setBuyer(?BuyerInterface $buyer): self;

    /**
     * Get continue URL
     *
     * @return string|null
     */
    public function getContinueUrl(): ?string;

    /**
     * Set continue URL
     *
     * @param string|null $continueUrl
     * @return $this
     */
    public function setContinueUrl(?string $continueUrl): self;

    /**
     * Get currency
     *
     * @return string
     */
    public function getCurrency(): string;

    /**
     * Set currency
     *
     * @param string $currency
     * @return $this
     */
    public function setCurrency(string $currency): self;

    /**
     * Get expires at
     *
     * @return string|null
     */
    public function getExpiresAt(): ?string;

    /**
     * Set expires at
     *
     * @param string|null $expiresAt
     * @return $this
     */
    public function setExpiresAt(?string $expiresAt): self;

    /**
     * Get ID
     *
     * @return string
     */
    public function getId(): string;

    /**
     * Set ID
     *
     * @param string $id
     * @return $this
     */
    public function setId(string $id): self;

    /**
     * Get line items
     *
     * @return LineItemResponseInterface[]
     */
    public function getLineItems(): array;

    /**
     * Set line items
     *
     * @param LineItemResponseInterface[] $lineItems
     * @return $this
     */
    public function setLineItems(array $lineItems): self;

    /**
     * Get links
     *
     * @return LinkInterface[]
     */
    public function getLinks(): array;

    /**
     * Set links
     *
     * @param LinkInterface[] $links
     * @return $this
     */
    public function setLinks(array $links): self;

    /**
     * Get messages
     *
     * @return MessageInterface[]|null
     */
    public function getMessages(): ?array;

    /**
     * Set messages
     *
     * @param MessageInterface[]|null $messages
     * @return $this
     */
    public function setMessages(?array $messages): self;

    /**
     * Get order ID
     *
     * @return string|null
     */
    public function getOrderId(): ?string;

    /**
     * Set order ID
     *
     * @param string|null $orderId
     * @return $this
     */
    public function setOrderId(?string $orderId): self;

    /**
     * Get order permalink URL
     *
     * @return string|null
     */
    public function getOrderPermalinkUrl(): ?string;

    /**
     * Set order permalink URL
     *
     * @param string|null $orderPermalinkUrl
     * @return $this
     */
    public function setOrderPermalinkUrl(?string $orderPermalinkUrl): self;

    /**
     * Get payment
     *
     * @return PaymentResponseInterface
     */
    public function getPayment(): PaymentResponseInterface;

    /**
     * Set payment
     *
     * @param PaymentResponseInterface $payment
     * @return $this
     */
    public function setPayment(PaymentResponseInterface $payment): self;

    /**
     * Get platform config
     *
     * @return PlatformConfigInterface|null
     */
    public function getPlatform(): ?PlatformConfigInterface;

    /**
     * Set platform config
     *
     * @param PlatformConfigInterface|null $platform
     * @return $this
     */
    public function setPlatform(?PlatformConfigInterface $platform): self;

    /**
     * Get status
     *
     * @return string
     */
    public function getStatus(): string;

    /**
     * Set status
     *
     * @param string $status
     * @return $this
     */
    public function setStatus(string $status): self;

    /**
     * Get totals
     *
     * @return TotalResponseInterface[]
     */
    public function getTotals(): array;

    /**
     * Set totals
     *
     * @param TotalResponseInterface[] $totals
     * @return $this
     */
    public function setTotals(array $totals): self;

    /**
     * Get UCP
     *
     * @return UcpCheckoutResponseInterface
     */
    public function getUcp(): UcpCheckoutResponseInterface;

    /**
     * Set UCP
     *
     * @param UcpCheckoutResponseInterface $ucp
     * @return $this
     */
    public function setUcp(UcpCheckoutResponseInterface $ucp): self;

    /**
     * Get fulfillment
     *
     * @return FulfillmentResponseInterface|null
     */
    public function getFulfillment(): ?FulfillmentResponseInterface;

    /**
     * Set fulfillment
     *
     * @param FulfillmentResponseInterface|null $fulfillment
     * @return $this
     */
    public function setFulfillment(?FulfillmentResponseInterface $fulfillment): self;
}
