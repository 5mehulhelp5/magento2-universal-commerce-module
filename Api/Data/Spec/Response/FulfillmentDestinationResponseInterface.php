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

use Magebit\UniversalCommerce\Api\Data\Spec\PostalAddressInterface;

/**
 * Fulfillment Destination Response Interface
 * Represents a fulfillment destination (includes postal address fields)
 */
interface FulfillmentDestinationResponseInterface
{
    public const ADDRESS_COUNTRY = 'address_country';
    public const ADDRESS_LOCALITY = 'address_locality';
    public const ADDRESS_REGION = 'address_region';
    public const EXTENDED_ADDRESS = 'extended_address';
    public const FIRST_NAME = 'first_name';
    public const FULL_NAME = 'full_name';
    public const LAST_NAME = 'last_name';
    public const PHONE_NUMBER = 'phone_number';
    public const POSTAL_CODE = 'postal_code';
    public const STREET_ADDRESS = 'street_address';
    public const ID = 'id';
    public const ADDRESS = 'address';
    public const NAME = 'name';

    /**
     * Get address country
     *
     * @return string|null
     */
    public function getAddressCountry(): ?string;

    /**
     * Set address country
     *
     * @param string|null $addressCountry
     * @return $this
     */
    public function setAddressCountry(?string $addressCountry): self;

    /**
     * Get address locality
     *
     * @return string|null
     */
    public function getAddressLocality(): ?string;

    /**
     * Set address locality
     *
     * @param string|null $addressLocality
     * @return $this
     */
    public function setAddressLocality(?string $addressLocality): self;

    /**
     * Get address region
     *
     * @return string|null
     */
    public function getAddressRegion(): ?string;

    /**
     * Set address region
     *
     * @param string|null $addressRegion
     * @return $this
     */
    public function setAddressRegion(?string $addressRegion): self;

    /**
     * Get extended address
     *
     * @return string|null
     */
    public function getExtendedAddress(): ?string;

    /**
     * Set extended address
     *
     * @param string|null $extendedAddress
     * @return $this
     */
    public function setExtendedAddress(?string $extendedAddress): self;

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

    /**
     * Get postal code
     *
     * @return string|null
     */
    public function getPostalCode(): ?string;

    /**
     * Set postal code
     *
     * @param string|null $postalCode
     * @return $this
     */
    public function setPostalCode(?string $postalCode): self;

    /**
     * Get street address
     *
     * @return string|null
     */
    public function getStreetAddress(): ?string;

    /**
     * Set street address
     *
     * @param string|null $streetAddress
     * @return $this
     */
    public function setStreetAddress(?string $streetAddress): self;

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
     * Get address
     *
     * @return PostalAddressInterface|null
     */
    public function getAddress(): ?PostalAddressInterface;

    /**
     * Set address
     *
     * @param PostalAddressInterface|null $address
     * @return $this
     */
    public function setAddress(?PostalAddressInterface $address): self;

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
}
