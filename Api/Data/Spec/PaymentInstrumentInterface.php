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
 * Payment Instrument Interface
 * Represents a payment instrument
 */
interface PaymentInstrumentInterface
{
    public const BILLING_ADDRESS = 'billing_address';
    public const CREDENTIAL = 'credential';
    public const HANDLER_ID = 'handler_id';
    public const ID = 'id';
    public const TYPE = 'type';
    public const BRAND = 'brand';
    public const EXPIRY_MONTH = 'expiry_month';
    public const EXPIRY_YEAR = 'expiry_year';
    public const LAST_DIGITS = 'last_digits';
    public const RICH_CARD_ART = 'rich_card_art';
    public const RICH_TEXT_DESCRIPTION = 'rich_text_description';

    /**
     * Get billing address
     *
     * @return PostalAddressInterface|null
     */
    public function getBillingAddress(): ?PostalAddressInterface;

    /**
     * Set billing address
     *
     * @param PostalAddressInterface|null $billingAddress
     * @return $this
     */
    public function setBillingAddress(?PostalAddressInterface $billingAddress): self;

    /**
     * Get credential
     *
     * @return PaymentCredentialInterface|null
     */
    public function getCredential(): ?PaymentCredentialInterface;

    /**
     * Set credential
     *
     * @param PaymentCredentialInterface|null $credential
     * @return $this
     */
    public function setCredential(?PaymentCredentialInterface $credential): self;

    /**
     * Get handler ID
     *
     * @return string
     */
    public function getHandlerId(): string;

    /**
     * Set handler ID
     *
     * @param string $handlerId
     * @return $this
     */
    public function setHandlerId(string $handlerId): self;

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
     * Get type
     *
     * @return string
     */
    public function getType(): string;

    /**
     * Set type
     *
     * @param string $type
     * @return $this
     */
    public function setType(string $type): self;

    /**
     * Get brand
     *
     * @return string
     */
    public function getBrand(): string;

    /**
     * Set brand
     *
     * @param string $brand
     * @return $this
     */
    public function setBrand(string $brand): self;

    /**
     * Get expiry month
     *
     * @return int|null
     */
    public function getExpiryMonth(): ?int;

    /**
     * Set expiry month
     *
     * @param int|null $expiryMonth
     * @return $this
     */
    public function setExpiryMonth(?int $expiryMonth): self;

    /**
     * Get expiry year
     *
     * @return int|null
     */
    public function getExpiryYear(): ?int;

    /**
     * Set expiry year
     *
     * @param int|null $expiryYear
     * @return $this
     */
    public function setExpiryYear(?int $expiryYear): self;

    /**
     * Get last digits
     *
     * @return string
     */
    public function getLastDigits(): string;

    /**
     * Set last digits
     *
     * @param string $lastDigits
     * @return $this
     */
    public function setLastDigits(string $lastDigits): self;

    /**
     * Get rich card art
     *
     * @return string|null
     */
    public function getRichCardArt(): ?string;

    /**
     * Set rich card art
     *
     * @param string|null $richCardArt
     * @return $this
     */
    public function setRichCardArt(?string $richCardArt): self;

    /**
     * Get rich text description
     *
     * @return string|null
     */
    public function getRichTextDescription(): ?string;

    /**
     * Set rich text description
     *
     * @param string|null $richTextDescription
     * @return $this
     */
    public function setRichTextDescription(?string $richTextDescription): self;
}
