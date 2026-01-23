<?php

/**
 * @author Magebit <info@magebit.com>
 * @copyright Copyright (c) Magebit, Ltd. (https://magebit.com)
 * @license https://magebit.com/code-license
 */

declare(strict_types=1);

namespace Magebit\UniversalCommerce\Model\Spec\Schemas\Shopping\Types;

use Magebit\UniversalCommerce\Model\DataTransferObject;
use Magebit\UcpSpec\MutableApi\Schemas\Shopping\Types\FulfillmentDestinationResponseInterface;

class FulfillmentDestinationResponse extends DataTransferObject implements FulfillmentDestinationResponseInterface
{
    /**
     * @return string|null
     */
    public function getExtendedAddress(): string|null
    {
        return $this->getDataStringOrNull(FulfillmentDestinationResponseInterface::KEY_EXTENDED_ADDRESS);
    }

    /**
     * @param string|null $extendedAddress
     * @return self
     */
    public function setExtendedAddress(?string $extendedAddress): self
    {
        $this->setData(FulfillmentDestinationResponseInterface::KEY_EXTENDED_ADDRESS, $extendedAddress);
        return $this;
    }

    /**
     * @return string|null
     */
    public function getStreetAddress(): string|null
    {
        return $this->getDataStringOrNull(FulfillmentDestinationResponseInterface::KEY_STREET_ADDRESS);
    }

    /**
     * @param string|null $streetAddress
     * @return self
     */
    public function setStreetAddress(?string $streetAddress): self
    {
        $this->setData(FulfillmentDestinationResponseInterface::KEY_STREET_ADDRESS, $streetAddress);
        return $this;
    }

    /**
     * @return string|null
     */
    public function getAddressLocality(): string|null
    {
        return $this->getDataStringOrNull(FulfillmentDestinationResponseInterface::KEY_ADDRESS_LOCALITY);
    }

    /**
     * @param string|null $addressLocality
     * @return self
     */
    public function setAddressLocality(?string $addressLocality): self
    {
        $this->setData(FulfillmentDestinationResponseInterface::KEY_ADDRESS_LOCALITY, $addressLocality);
        return $this;
    }

    /**
     * @return string|null
     */
    public function getAddressRegion(): string|null
    {
        return $this->getDataStringOrNull(FulfillmentDestinationResponseInterface::KEY_ADDRESS_REGION);
    }

    /**
     * @param string|null $addressRegion
     * @return self
     */
    public function setAddressRegion(?string $addressRegion): self
    {
        $this->setData(FulfillmentDestinationResponseInterface::KEY_ADDRESS_REGION, $addressRegion);
        return $this;
    }

    /**
     * @return string|null
     */
    public function getAddressCountry(): string|null
    {
        return $this->getDataStringOrNull(FulfillmentDestinationResponseInterface::KEY_ADDRESS_COUNTRY);
    }

    /**
     * @param string|null $addressCountry
     * @return self
     */
    public function setAddressCountry(?string $addressCountry): self
    {
        $this->setData(FulfillmentDestinationResponseInterface::KEY_ADDRESS_COUNTRY, $addressCountry);
        return $this;
    }

    /**
     * @return string|null
     */
    public function getPostalCode(): string|null
    {
        return $this->getDataStringOrNull(FulfillmentDestinationResponseInterface::KEY_POSTAL_CODE);
    }

    /**
     * @param string|null $postalCode
     * @return self
     */
    public function setPostalCode(?string $postalCode): self
    {
        $this->setData(FulfillmentDestinationResponseInterface::KEY_POSTAL_CODE, $postalCode);
        return $this;
    }

    /**
     * @return string|null
     */
    public function getFirstName(): string|null
    {
        return $this->getDataStringOrNull(FulfillmentDestinationResponseInterface::KEY_FIRST_NAME);
    }

    /**
     * @param string|null $firstName
     * @return self
     */
    public function setFirstName(?string $firstName): self
    {
        $this->setData(FulfillmentDestinationResponseInterface::KEY_FIRST_NAME, $firstName);
        return $this;
    }

    /**
     * @return string|null
     */
    public function getLastName(): string|null
    {
        return $this->getDataStringOrNull(FulfillmentDestinationResponseInterface::KEY_LAST_NAME);
    }

    /**
     * @param string|null $lastName
     * @return self
     */
    public function setLastName(?string $lastName): self
    {
        $this->setData(FulfillmentDestinationResponseInterface::KEY_LAST_NAME, $lastName);
        return $this;
    }

    /**
     * @return string|null
     */
    public function getFullName(): string|null
    {
        return $this->getDataStringOrNull(FulfillmentDestinationResponseInterface::KEY_FULL_NAME);
    }

    /**
     * @param string|null $fullName
     * @return self
     */
    public function setFullName(?string $fullName): self
    {
        $this->setData(FulfillmentDestinationResponseInterface::KEY_FULL_NAME, $fullName);
        return $this;
    }

    /**
     * @return string|null
     */
    public function getPhoneNumber(): string|null
    {
        return $this->getDataStringOrNull(FulfillmentDestinationResponseInterface::KEY_PHONE_NUMBER);
    }

    /**
     * @param string|null $phoneNumber
     * @return self
     */
    public function setPhoneNumber(?string $phoneNumber): self
    {
        $this->setData(FulfillmentDestinationResponseInterface::KEY_PHONE_NUMBER, $phoneNumber);
        return $this;
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->getDataString(FulfillmentDestinationResponseInterface::KEY_ID);
    }

    /**
     * @param string $id
     * @return self
     */
    public function setId(string $id): self
    {
        $this->setData(FulfillmentDestinationResponseInterface::KEY_ID, $id);
        return $this;
    }
}
