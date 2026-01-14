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

use Magebit\UniversalCommerce\Api\Data\Spec\PaymentCredentialInterface;
use Magebit\UniversalCommerce\Model\Data\DataTransferObject;

/**
 * Payment Credential Model
 */
class PaymentCredential extends DataTransferObject implements PaymentCredentialInterface
{
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
    public function setType(string $type): PaymentCredentialInterface
    {
        return $this->setData(self::TYPE, $type);
    }

    /**
     * @inheritDoc
     */
    public function getCardNumberType(): ?string
    {
        return $this->getDataStringOrNull(self::CARD_NUMBER_TYPE);
    }

    /**
     * @inheritDoc
     */
    public function setCardNumberType(?string $cardNumberType): PaymentCredentialInterface
    {
        return $this->setData(self::CARD_NUMBER_TYPE, $cardNumberType);
    }

    /**
     * @inheritDoc
     */
    public function getCryptogram(): ?string
    {
        return $this->getDataStringOrNull(self::CRYPTOGRAM);
    }

    /**
     * @inheritDoc
     */
    public function setCryptogram(?string $cryptogram): PaymentCredentialInterface
    {
        return $this->setData(self::CRYPTOGRAM, $cryptogram);
    }

    /**
     * @inheritDoc
     */
    public function getCvc(): ?string
    {
        return $this->getDataStringOrNull(self::CVC);
    }

    /**
     * @inheritDoc
     */
    public function setCvc(?string $cvc): PaymentCredentialInterface
    {
        return $this->setData(self::CVC, $cvc);
    }

    /**
     * @inheritDoc
     */
    public function getEciValue(): ?string
    {
        return $this->getDataStringOrNull(self::ECI_VALUE);
    }

    /**
     * @inheritDoc
     */
    public function setEciValue(?string $eciValue): PaymentCredentialInterface
    {
        return $this->setData(self::ECI_VALUE, $eciValue);
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
    public function setExpiryMonth(?int $expiryMonth): PaymentCredentialInterface
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
    public function setExpiryYear(?int $expiryYear): PaymentCredentialInterface
    {
        return $this->setData(self::EXPIRY_YEAR, $expiryYear);
    }

    /**
     * @inheritDoc
     */
    public function getName(): ?string
    {
        return $this->getDataStringOrNull(self::NAME);
    }

    /**
     * @inheritDoc
     */
    public function setName(?string $name): PaymentCredentialInterface
    {
        return $this->setData(self::NAME, $name);
    }

    /**
     * @inheritDoc
     */
    public function getNumber(): ?string
    {
        return $this->getDataStringOrNull(self::NUMBER);
    }

    /**
     * @inheritDoc
     */
    public function setNumber(?string $number): PaymentCredentialInterface
    {
        return $this->setData(self::NUMBER, $number);
    }
}
