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

use Magebit\UcpSpec\MutableApi\Schemas\Shopping\Types\CardCredentialInterface;
use Magebit\UniversalCommerce\Model\Data\DataTransferObject;

/**
 * Payment Credential Model
 */
class PaymentCredential extends DataTransferObject implements CardCredentialInterface
{
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
    public function setType($type): CardCredentialInterface
    {
        return $this->setData(self::KEY_TYPE, $type);
    }

    /**
     * @inheritDoc
     */
    public function getCardNumberType(): string
    {
        return $this->getDataString(self::KEY_CARD_NUMBER_TYPE);
    }

    /**
     * @inheritDoc
     */
    public function setCardNumberType(string $cardNumberType): CardCredentialInterface
    {
        return $this->setData(self::KEY_CARD_NUMBER_TYPE, $cardNumberType);
    }

    /**
     * @inheritDoc
     */
    public function getCryptogram(): ?string
    {
        return $this->getDataStringOrNull(self::KEY_CRYPTOGRAM);
    }

    /**
     * @inheritDoc
     */
    public function setCryptogram(?string $cryptogram): CardCredentialInterface
    {
        return $this->setData(self::KEY_CRYPTOGRAM, $cryptogram);
    }

    /**
     * @inheritDoc
     */
    public function getCvc(): ?string
    {
        return $this->getDataStringOrNull(self::KEY_CVC);
    }

    /**
     * @inheritDoc
     */
    public function setCvc(?string $cvc): CardCredentialInterface
    {
        return $this->setData(self::KEY_CVC, $cvc);
    }

    /**
     * @inheritDoc
     */
    public function getEciValue(): ?string
    {
        return $this->getDataStringOrNull(self::KEY_ECI_VALUE);
    }

    /**
     * @inheritDoc
     */
    public function setEciValue(?string $eciValue): CardCredentialInterface
    {
        return $this->setData(self::KEY_ECI_VALUE, $eciValue);
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
    public function setExpiryMonth(?int $expiryMonth): CardCredentialInterface
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
    public function setExpiryYear(?int $expiryYear): CardCredentialInterface
    {
        return $this->setData(self::KEY_EXPIRY_YEAR, $expiryYear);
    }

    /**
     * @inheritDoc
     */
    public function getName(): ?string
    {
        return $this->getDataStringOrNull(self::KEY_NAME);
    }

    /**
     * @inheritDoc
     */
    public function setName(?string $name): CardCredentialInterface
    {
        return $this->setData(self::KEY_NAME, $name);
    }

    /**
     * @inheritDoc
     */
    public function getNumber(): ?string
    {
        return $this->getDataStringOrNull(self::KEY_NUMBER);
    }

    /**
     * @inheritDoc
     */
    public function setNumber(?string $number): CardCredentialInterface
    {
        return $this->setData(self::KEY_NUMBER, $number);
    }
}
