<?php

/**
 * This file is part of the Magebit_UniversalCommerce package.
 *
 * @copyright Copyright (c) 2026 Magebit, Ltd. (https://magebit.com/)
 * @author    Magebit <info@magebit.com>
 * @license   MIT
 */

declare(strict_types=1);

namespace Magebit\UniversalCommerce\Api\Data\Spec;

/**
 * Checkout Create Request Interface
 * Represents a checkout creation request
 */
interface CheckoutCreateRequestInterface
{
    public const BUYER = 'buyer';
    public const CURRENCY = 'currency';
    public const LINE_ITEMS = 'line_items';
    public const PAYMENT = 'payment';

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
     * Get line items
     *
     * @return LineItemCreateRequestInterface[]
     */
    public function getLineItems(): array;

    /**
     * Set line items
     *
     * @param LineItemCreateRequestInterface[] $lineItems
     * @return $this
     */
    public function setLineItems(array $lineItems): self;

    /**
     * Get payment
     *
     * @return PaymentClassInterface
     */
    public function getPayment(): PaymentClassInterface;

    /**
     * Set payment
     *
     * @param PaymentClassInterface $payment
     * @return $this
     */
    public function setPayment(PaymentClassInterface $payment): self;
}
