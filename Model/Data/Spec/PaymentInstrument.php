<?php

/**
 * This file is part of the Magebit_UniversalCommerce package.
 *
 * @copyright Copyright (c) 2026 Magebit, Ltd. (https://magebit.com/)
 * @author    Magebit <info@magebit.com>
 * @license   MIT
 */

declare(strict_types=1);

namespace Magebit\UniversalCommerce\Model\Data\Spec;

use Magebit\UniversalCommerce\Api\Data\Spec\PaymentInstrumentInterface;
use Magebit\UniversalCommerce\Api\Data\Spec\PostalAddressInterface;
use Magebit\UniversalCommerce\Api\Data\Spec\PostalAddressInterfaceFactory;
use Magebit\UniversalCommerce\Api\Data\Spec\PaymentCredentialInterface;
use Magebit\UniversalCommerce\Api\Data\Spec\PaymentCredentialInterfaceFactory;
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
        return $this->getDataInstance(self::BILLING_ADDRESS, PostalAddressInterface::class, $this->addressFactory->create(...));
    }

    /**
     * @inheritDoc
     */
    public function setBillingAddress(?PostalAddressInterface $billingAddress): PaymentInstrumentInterface
    {
        return $this->setData(self::BILLING_ADDRESS, $billingAddress);
    }

    /**
     * @inheritDoc
     */
    public function getCredential(): ?PaymentCredentialInterface
    {
        return $this->getDataInstance(self::CREDENTIAL, PaymentCredentialInterface::class, $this->credentialFactory->create(...));
    }

    /**
     * @inheritDoc
     */
    public function setCredential(?PaymentCredentialInterface $credential): PaymentInstrumentInterface
    {
        return $this->setData(self::CREDENTIAL, $credential);
    }

    /**
     * @inheritDoc
     */
    public function getHandlerId(): string
    {
        return $this->getDataString(self::HANDLER_ID);
    }

    /**
     * @inheritDoc
     */
    public function setHandlerId(string $handlerId): PaymentInstrumentInterface
    {
        return $this->setData(self::HANDLER_ID, $handlerId);
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
    public function setId(string $id): PaymentInstrumentInterface
    {
        return $this->setData(self::ID, $id);
    }

    /**
     * @inheritDoc
     */
    public function getType(): string
    {
        return $this->getDataString(self::TYPE);
    }

    /**
     * @inheritDoc
     */
    public function setType(string $type): PaymentInstrumentInterface
    {
        return $this->setData(self::TYPE, $type);
    }

    /**
     * @inheritDoc
     */
    public function getBrand(): string
    {
        return $this->getDataString(self::BRAND);
    }

    /**
     * @inheritDoc
     */
    public function setBrand(string $brand): PaymentInstrumentInterface
    {
        return $this->setData(self::BRAND, $brand);
    }

    /**
     * @inheritDoc
     */
    public function getExpiryMonth(): ?int
    {
        return $this->getDataIntOrNull(self::EXPIRY_MONTH);
    }

    /**
     * @inheritDoc
     */
    public function setExpiryMonth(?int $expiryMonth): PaymentInstrumentInterface
    {
        return $this->setData(self::EXPIRY_MONTH, $expiryMonth);
    }

    /**
     * @inheritDoc
     */
    public function getExpiryYear(): ?int
    {
        return $this->getDataIntOrNull(self::EXPIRY_YEAR);
    }

    /**
     * @inheritDoc
     */
    public function setExpiryYear(?int $expiryYear): PaymentInstrumentInterface
    {
        return $this->setData(self::EXPIRY_YEAR, $expiryYear);
    }

    /**
     * @inheritDoc
     */
    public function getLastDigits(): string
    {
        return $this->getDataString(self::LAST_DIGITS);
    }

    /**
     * @inheritDoc
     */
    public function setLastDigits(string $lastDigits): PaymentInstrumentInterface
    {
        return $this->setData(self::LAST_DIGITS, $lastDigits);
    }

    /**
     * @inheritDoc
     */
    public function getRichCardArt(): ?string
    {
        return $this->getDataStringOrNull(self::RICH_CARD_ART);
    }

    /**
     * @inheritDoc
     */
    public function setRichCardArt(?string $richCardArt): PaymentInstrumentInterface
    {
        return $this->setData(self::RICH_CARD_ART, $richCardArt);
    }

    /**
     * @inheritDoc
     */
    public function getRichTextDescription(): ?string
    {
        return $this->getDataStringOrNull(self::RICH_TEXT_DESCRIPTION);
    }

    /**
     * @inheritDoc
     */
    public function setRichTextDescription(?string $richTextDescription): PaymentInstrumentInterface
    {
        return $this->setData(self::RICH_TEXT_DESCRIPTION, $richTextDescription);
    }
}
