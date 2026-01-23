<?php

/**
 * This file is part of the Magebit_UniversalCommerce package.
 *
 * @copyright Copyright (c) 2026 Magebit, Ltd. (https://magebit.com/)
 * @author    Magebit <info@magebit.com>
 * @license   MIT
 */

declare(strict_types=1);

namespace Magebit\UniversalCommerce\Model\Spec\Schemas\Shopping\Types;

use Magebit\UniversalCommerce\Model\DataTransferObject;
use Magebit\UcpSpec\MutableApi\Schemas\Shopping\Types\PaymentInstrumentInterface;
use Magebit\UcpSpec\MutableApi\Schemas\Shopping\Types\PostalAddressInterface;
use Magebit\UcpSpec\MutableApi\Schemas\Shopping\Types\PaymentCredentialInterface;

class PaymentInstrument extends DataTransferObject implements PaymentInstrumentInterface
{
    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->getDataString(PaymentInstrumentInterface::KEY_ID);
    }

    /**
     * @return string
     */
    public function getHandlerId(): string
    {
        return $this->getDataString(PaymentInstrumentInterface::KEY_HANDLER_ID);
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->getDataString(PaymentInstrumentInterface::KEY_TYPE);
    }

    /**
     * @return PostalAddressInterface|null
     */
    public function getBillingAddress(): PostalAddressInterface|null
    {
        return $this->getDataOfTypeOrNull(
            PaymentInstrumentInterface::KEY_BILLING_ADDRESS,
            PostalAddressInterface::class
        );
    }

    /**
     * @return PaymentCredentialInterface|null
     */
    public function getCredential(): PaymentCredentialInterface|null
    {
        return $this->getDataOfTypeOrNull(
            PaymentInstrumentInterface::KEY_CREDENTIAL,
            PaymentCredentialInterface::class
        );
    }

    /**
     * @return string
     */
    public function getBrand(): string
    {
        return $this->getDataString(PaymentInstrumentInterface::KEY_BRAND);
    }

    /**
     * @return string
     */
    public function getLastDigits(): string
    {
        return $this->getDataString(PaymentInstrumentInterface::KEY_LAST_DIGITS);
    }

    /**
     * @return int|null
     */
    public function getExpiryMonth(): int|null
    {
        return $this->getDataIntOrNull(PaymentInstrumentInterface::KEY_EXPIRY_MONTH);
    }

    /**
     * @return int|null
     */
    public function getExpiryYear(): int|null
    {
        return $this->getDataIntOrNull(PaymentInstrumentInterface::KEY_EXPIRY_YEAR);
    }

    /**
     * @return string|null
     */
    public function getRichTextDescription(): string|null
    {
        return $this->getDataStringOrNull(PaymentInstrumentInterface::KEY_RICH_TEXT_DESCRIPTION);
    }

    /**
     * @return string|null
     */
    public function getRichCardArt(): string|null
    {
        return $this->getDataStringOrNull(PaymentInstrumentInterface::KEY_RICH_CARD_ART);
    }

    /**
     * @param string $id
     * @return self
     */
    public function setId(string $id): self
    {
        $this->setData(PaymentInstrumentInterface::KEY_ID, $id);
        return $this;
    }

    /**
     * @param string $handlerId
     * @return self
     */
    public function setHandlerId(string $handlerId): self
    {
        $this->setData(PaymentInstrumentInterface::KEY_HANDLER_ID, $handlerId);
        return $this;
    }

    /**
     * @param string $type
     * @return self
     */
    public function setType(string $type): self
    {
        $this->setData(PaymentInstrumentInterface::KEY_TYPE, $type);
        return $this;
    }

    /**
     * @param PostalAddressInterface|null $billingAddress
     * @return self
     */
    public function setBillingAddress(?PostalAddressInterface $billingAddress): self
    {
        $this->setData(PaymentInstrumentInterface::KEY_BILLING_ADDRESS, $billingAddress);
        return $this;
    }

    /**
     * @param PaymentCredentialInterface|null $credential
     * @return self
     */
    public function setCredential(?PaymentCredentialInterface $credential): self
    {
        $this->setData(PaymentInstrumentInterface::KEY_CREDENTIAL, $credential);
        return $this;
    }

    /**
     * @param string $brand
     * @return self
     */
    public function setBrand(string $brand): self
    {
        $this->setData(PaymentInstrumentInterface::KEY_BRAND, $brand);
        return $this;
    }

    /**
     * @param string $lastDigits
     * @return self
     */
    public function setLastDigits(string $lastDigits): self
    {
        $this->setData(PaymentInstrumentInterface::KEY_LAST_DIGITS, $lastDigits);
        return $this;
    }

    /**
     * @param int|null $expiryMonth
     * @return self
     */
    public function setExpiryMonth(?int $expiryMonth): self
    {
        $this->setData(PaymentInstrumentInterface::KEY_EXPIRY_MONTH, $expiryMonth);
        return $this;
    }

    /**
     * @param int|null $expiryYear
     * @return self
     */
    public function setExpiryYear(?int $expiryYear): self
    {
        $this->setData(PaymentInstrumentInterface::KEY_EXPIRY_YEAR, $expiryYear);
        return $this;
    }

    /**
     * @param string|null $richTextDescription
     * @return self
     */
    public function setRichTextDescription(?string $richTextDescription): self
    {
        $this->setData(PaymentInstrumentInterface::KEY_RICH_TEXT_DESCRIPTION, $richTextDescription);
        return $this;
    }

    /**
     * @param string|null $richCardArt
     * @return self
     */
    public function setRichCardArt(?string $richCardArt): self
    {
        $this->setData(PaymentInstrumentInterface::KEY_RICH_CARD_ART, $richCardArt);
        return $this;
    }
}
