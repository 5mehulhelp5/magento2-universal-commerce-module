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
 * Payment Credential Interface
 * Represents payment credential information
 */
interface PaymentCredentialInterface
{
    public const TYPE = 'type';
    public const CARD_NUMBER_TYPE = 'card_number_type';
    public const CRYPTOGRAM = 'cryptogram';
    public const CVC = 'cvc';
    public const ECI_VALUE = 'eci_value';
    public const EXPIRY_MONTH = 'expiry_month';
    public const EXPIRY_YEAR = 'expiry_year';
    public const NAME = 'name';
    public const NUMBER = 'number';

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
     * Get card number type
     *
     * @return string|null
     */
    public function getCardNumberType(): ?string;

    /**
     * Set card number type
     *
     * @param string|null $cardNumberType
     * @return $this
     */
    public function setCardNumberType(?string $cardNumberType): self;

    /**
     * Get cryptogram
     *
     * @return string|null
     */
    public function getCryptogram(): ?string;

    /**
     * Set cryptogram
     *
     * @param string|null $cryptogram
     * @return $this
     */
    public function setCryptogram(?string $cryptogram): self;

    /**
     * Get CVC
     *
     * @return string|null
     */
    public function getCvc(): ?string;

    /**
     * Set CVC
     *
     * @param string|null $cvc
     * @return $this
     */
    public function setCvc(?string $cvc): self;

    /**
     * Get ECI value
     *
     * @return string|null
     */
    public function getEciValue(): ?string;

    /**
     * Set ECI value
     *
     * @param string|null $eciValue
     * @return $this
     */
    public function setEciValue(?string $eciValue): self;

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
     * Get name
     *
     * @return string|null
     */
    public function getName(): ?string;

    /**
     * Set name
     *
     * @param string|null $name
     * @return $this
     */
    public function setName(?string $name): self;

    /**
     * Get number
     *
     * @return string|null
     */
    public function getNumber(): ?string;

    /**
     * Set number
     *
     * @param string|null $number
     * @return $this
     */
    public function setNumber(?string $number): self;
}
