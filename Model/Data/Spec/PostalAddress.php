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

use Magebit\UniversalCommerce\Api\Data\Spec\PostalAddressInterface;
use Magebit\UniversalCommerce\Model\Data\DataTransferObject;

/**
 * Postal Address Model
 */
class PostalAddress extends DataTransferObject implements PostalAddressInterface
{
    /**
     * @inheritDoc
     */
    public function getAddressCountry(): ?string
    {
        return $this->getDataStringOrNull(self::ADDRESS_COUNTRY);
    }

    /**
     * @inheritDoc
     */
    public function setAddressCountry(?string $addressCountry): PostalAddressInterface
    {
        return $this->setData(self::ADDRESS_COUNTRY, $addressCountry);
    }

    /**
     * @inheritDoc
     */
    public function getAddressLocality(): ?string
    {
        return $this->getDataStringOrNull(self::ADDRESS_LOCALITY);
    }

    /**
     * @inheritDoc
     */
    public function setAddressLocality(?string $addressLocality): PostalAddressInterface
    {
        return $this->setData(self::ADDRESS_LOCALITY, $addressLocality);
    }

    /**
     * @inheritDoc
     */
    public function getAddressRegion(): ?string
    {
        return $this->getDataStringOrNull(self::ADDRESS_REGION);
    }

    /**
     * @inheritDoc
     */
    public function setAddressRegion(?string $addressRegion): PostalAddressInterface
    {
        return $this->setData(self::ADDRESS_REGION, $addressRegion);
    }

    /**
     * @inheritDoc
     */
    public function getExtendedAddress(): ?string
    {
        return $this->getDataStringOrNull(self::EXTENDED_ADDRESS);
    }

    /**
     * @inheritDoc
     */
    public function setExtendedAddress(?string $extendedAddress): PostalAddressInterface
    {
        return $this->setData(self::EXTENDED_ADDRESS, $extendedAddress);
    }

    /**
     * @inheritDoc
     */
    public function getFirstName(): ?string
    {
        return $this->getDataStringOrNull(self::FIRST_NAME);
    }

    /**
     * @inheritDoc
     */
    public function setFirstName(?string $firstName): PostalAddressInterface
    {
        return $this->setData(self::FIRST_NAME, $firstName);
    }

    /**
     * @inheritDoc
     */
    public function getFullName(): ?string
    {
        return $this->getDataStringOrNull(self::FULL_NAME);
    }

    /**
     * @inheritDoc
     */
    public function setFullName(?string $fullName): PostalAddressInterface
    {
        return $this->setData(self::FULL_NAME, $fullName);
    }

    /**
     * @inheritDoc
     */
    public function getLastName(): ?string
    {
        return $this->getDataStringOrNull(self::LAST_NAME);
    }

    /**
     * @inheritDoc
     */
    public function setLastName(?string $lastName): PostalAddressInterface
    {
        return $this->setData(self::LAST_NAME, $lastName);
    }

    /**
     * @inheritDoc
     */
    public function getPhoneNumber(): ?string
    {
        return $this->getDataStringOrNull(self::PHONE_NUMBER);
    }

    /**
     * @inheritDoc
     */
    public function setPhoneNumber(?string $phoneNumber): PostalAddressInterface
    {
        return $this->setData(self::PHONE_NUMBER, $phoneNumber);
    }

    /**
     * @inheritDoc
     */
    public function getPostalCode(): ?string
    {
        return $this->getDataStringOrNull(self::POSTAL_CODE);
    }

    /**
     * @inheritDoc
     */
    public function setPostalCode(?string $postalCode): PostalAddressInterface
    {
        return $this->setData(self::POSTAL_CODE, $postalCode);
    }

    /**
     * @inheritDoc
     */
    public function getStreetAddress(): ?string
    {
        return $this->getDataStringOrNull(self::STREET_ADDRESS);
    }

    /**
     * @inheritDoc
     */
    public function setStreetAddress(?string $streetAddress): PostalAddressInterface
    {
        return $this->setData(self::STREET_ADDRESS, $streetAddress);
    }
}
