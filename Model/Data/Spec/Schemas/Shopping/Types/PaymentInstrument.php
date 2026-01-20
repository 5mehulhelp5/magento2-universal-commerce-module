<?php

/**
 * This file is part of the Magebit_UniversalCommerce package.
 *
 * @copyright Copyright (c) 2026 Magebit, Ltd. (https://magebit.com/)
 * @author    Magebit <info@magebit.com>
 * @license   MIT
 */

declare(strict_types=1);

namespace Magebit\UniversalCommerce\Model\Data\Spec\Schemas\Shopping\Types;

use Magebit\UcpSpec\MutableApi\Schemas\Shopping\Types\PaymentInstrumentInterface;
use Magebit\UcpSpec\MutableApi\Schemas\Shopping\Types\PostalAddressInterface;
use Magebit\UcpSpec\MutableApi\Schemas\Shopping\Types\PostalAddressInterfaceFactory;
use Magebit\UcpSpec\MutableApi\Schemas\Shopping\Types\PaymentCredentialInterface;
use Magebit\UcpSpec\MutableApi\Schemas\Shopping\Types\PaymentCredentialInterfaceFactory;
use Magebit\UniversalCommerce\Model\Data\DataTransferObject;

/**
 * Payment Instrument Model
 */
class PaymentInstrument extends DataTransferObject implements PaymentInstrumentInterface
{
    /**
     * @param PostalAddressInterfaceFactory $addressFactory
     * @param PaymentCredentialInterfaceFactory $credentialFactory
     * @param array<mixed> $data
     */
    public function __construct(
        private readonly PostalAddressInterfaceFactory $addressFactory,
        private readonly PaymentCredentialInterfaceFactory $credentialFactory,
        array $data = []
    ) {
        parent::__construct($data);
    }

    /**
     * @inheritDoc
     */
    public function getBillingAddress(): ?PostalAddressInterface
    {
        return $this->getDataInstance(self::KEY_BILLING_ADDRESS, PostalAddressInterface::class, $this->addressFactory->create(...));
    }

    /**
     * @inheritDoc
     */
    public function setBillingAddress(?PostalAddressInterface $billingAddress): PaymentInstrumentInterface
    {
        return $this->setData(self::KEY_BILLING_ADDRESS, $billingAddress);
    }

    /**
     * @inheritDoc
     */
    public function getCredential(): ?PaymentCredentialInterface
    {
        return $this->getDataInstance(self::KEY_CREDENTIAL, PaymentCredentialInterface::class, $this->credentialFactory->create(...));
    }

    /**
     * @inheritDoc
     */
    public function setCredential(?PaymentCredentialInterface $credential): PaymentInstrumentInterface
    {
        return $this->setData(self::KEY_CREDENTIAL, $credential);
    }

    /**
     * @inheritDoc
     */
    public function getHandlerId(): string
    {
        return $this->getDataString(self::KEY_HANDLER_ID);
    }

    /**
     * @inheritDoc
     */
    public function setHandlerId(string $handlerId): PaymentInstrumentInterface
    {
        return $this->setData(self::KEY_HANDLER_ID, $handlerId);
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
    public function setId(string $id): PaymentInstrumentInterface
    {
        return $this->setData(self::KEY_ID, $id);
    }

    /**
     * @inheritDoc
     */
    public function getType(): string
    {
        return $this->getDataString(self::KEY_TYPE);
    }

    /**
     * @inheritDoc
     */
    public function setType(string $type): PaymentInstrumentInterface
    {
        return $this->setData(self::KEY_TYPE, $type);
    }

    /**
     * @inheritDoc
     */
    public function getBrand(): string
    {
        return $this->getDataString(self::KEY_BRAND);
    }

    /**
     * @inheritDoc
     */
    public function setBrand(string $brand): self
    {
        return $this->setData(self::KEY_BRAND, $brand);
    }

    /**
     * @inheritDoc
     */
    public function getExpiryMonth(): ?int
    {
        return $this->getDataIntOrNull(self::KEY_EXPIRY_MONTH);
    }

    /**
     * @inheritDoc
     */
    public function setExpiryMonth(?int $expiryMonth): self
    {
        return $this->setData(self::KEY_EXPIRY_MONTH, $expiryMonth);
    }

    /**
     * @inheritDoc
     */
    public function getExpiryYear(): ?int
    {
        return $this->getDataIntOrNull(self::KEY_EXPIRY_YEAR);
    }

    /**
     * @inheritDoc
     */
    public function setExpiryYear(?int $expiryYear): self
    {
        return $this->setData(self::KEY_EXPIRY_YEAR, $expiryYear);
    }

    /**
     * @inheritDoc
     */
    public function getLastDigits(): string
    {
        return $this->getDataString(self::KEY_LAST_DIGITS);
    }

    /**
     * @inheritDoc
     */
    public function setLastDigits(string $lastDigits): self
    {
        return $this->setData(self::KEY_LAST_DIGITS, $lastDigits);
    }

    /**
     * @inheritDoc
     */
    public function getRichCardArt(): ?string
    {
        return $this->getDataStringOrNull(self::KEY_RICH_CARD_ART);
    }

    /**
     * @inheritDoc
     */
    public function setRichCardArt(?string $richCardArt): self
    {
        return $this->setData(self::KEY_RICH_CARD_ART, $richCardArt);
    }

    /**
     * @inheritDoc
     */
    public function getRichTextDescription(): ?string
    {
        return $this->getDataStringOrNull(self::KEY_RICH_TEXT_DESCRIPTION);
    }

    /**
     * @inheritDoc
     */
    public function setRichTextDescription(?string $richTextDescription): self
    {
        return $this->setData(self::KEY_RICH_TEXT_DESCRIPTION, $richTextDescription);
    }
}
