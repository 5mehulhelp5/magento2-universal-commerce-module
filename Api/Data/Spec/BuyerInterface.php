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
 * Buyer Interface
 * Represents buyer information in the UCP specification
 */
interface BuyerInterface
{
    public const EMAIL = 'email';
    public const FIRST_NAME = 'first_name';
    public const FULL_NAME = 'full_name';
    public const LAST_NAME = 'last_name';
    public const PHONE_NUMBER = 'phone_number';

    /**
     * Get email
     *
     * @return string|null
     */
    public function getEmail(): ?string;

    /**
     * Set email
     *
     * @param string|null $email
     * @return $this
     */
    public function setEmail(?string $email): self;

    /**
     * Get first name
     *
     * @return string|null
     */
    public function getFirstName(): ?string;

    /**
     * Set first name
     *
     * @param string|null $firstName
     * @return $this
     */
    public function setFirstName(?string $firstName): self;

    /**
     * Get full name
     *
     * @return string|null
     */
    public function getFullName(): ?string;

    /**
     * Set full name
     *
     * @param string|null $fullName
     * @return $this
     */
    public function setFullName(?string $fullName): self;

    /**
     * Get last name
     *
     * @return string|null
     */
    public function getLastName(): ?string;

    /**
     * Set last name
     *
     * @param string|null $lastName
     * @return $this
     */
    public function setLastName(?string $lastName): self;

    /**
     * Get phone number
     *
     * @return string|null
     */
    public function getPhoneNumber(): ?string;

    /**
     * Set phone number
     *
     * @param string|null $phoneNumber
     * @return $this
     */
    public function setPhoneNumber(?string $phoneNumber): self;
}
