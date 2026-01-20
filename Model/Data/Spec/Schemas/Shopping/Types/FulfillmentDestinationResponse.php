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

use Magebit\UcpSpec\Api\Schemas\Shopping\Types\PostalAddressInterface;
use Magebit\UcpSpec\Api\Schemas\Shopping\Types\PostalAddressInterfaceFactory;
use Magebit\UcpSpec\Api\Schemas\Shopping\Types\FulfillmentDestinationResponseInterface;
use Magebit\UniversalCommerce\Model\Data\DataTransferObject;

/**
 * Fulfillment Destination Response Model
 */
class FulfillmentDestinationResponse extends DataTransferObject implements FulfillmentDestinationResponseInterface
{
    /**
     * @param PostalAddressInterfaceFactory $addressFactory
     * @param array<mixed> $data
     */
    public function __construct(
        private readonly PostalAddressInterfaceFactory $addressFactory,
        array $data = []
    ) {
        parent::__construct($data);
    }

    /**
     * @inheritDoc
     */
    public function getAddressCountry(): ?string
    {
        return $this->getDataStringOrNull(self::KEY_ADDRESS_COUNTRY);
    }

    /**
     * @inheritDoc
     */
    public function setAddressCountry(?string $addressCountry): FulfillmentDestinationResponseInterface
    {
        return $this->setData(self::KEY_ADDRESS_COUNTRY, $addressCountry);
    }

    /**
     * @inheritDoc
     */
    public function getAddressLocality(): ?string
    {
        return $this->getDataStringOrNull(self::KEY_ADDRESS_LOCALITY);
    }

    /**
     * @inheritDoc
     */
    public function setAddressLocality(?string $addressLocality): FulfillmentDestinationResponseInterface
    {
        return $this->setData(self::KEY_ADDRESS_LOCALITY, $addressLocality);
    }

    /**
     * @inheritDoc
     */
    public function getAddressRegion(): ?string
    {
        return $this->getDataStringOrNull(self::KEY_ADDRESS_REGION);
    }

    /**
     * @inheritDoc
     */
    public function setAddressRegion(?string $addressRegion): FulfillmentDestinationResponseInterface
    {
        return $this->setData(self::KEY_ADDRESS_REGION, $addressRegion);
    }

    /**
     * @inheritDoc
     */
    public function getExtendedAddress(): ?string
    {
        return $this->getDataStringOrNull(self::KEY_EXTENDED_ADDRESS);
    }

    /**
     * @inheritDoc
     */
    public function setExtendedAddress(?string $extendedAddress): FulfillmentDestinationResponseInterface
    {
        return $this->setData(self::KEY_EXTENDED_ADDRESS, $extendedAddress);
    }

    /**
     * @inheritDoc
     */
    public function getFirstName(): ?string
    {
        return $this->getDataStringOrNull(self::KEY_FIRST_NAME);
    }

    /**
     * @inheritDoc
     */
    public function setFirstName(?string $firstName): FulfillmentDestinationResponseInterface
    {
        return $this->setData(self::KEY_FIRST_NAME, $firstName);
    }

    /**
     * @inheritDoc
     */
    public function getFullName(): ?string
    {
        return $this->getDataStringOrNull(self::KEY_FULL_NAME);
    }

    /**
     * @inheritDoc
     */
    public function setFullName(?string $fullName): FulfillmentDestinationResponseInterface
    {
        return $this->setData(self::KEY_FULL_NAME, $fullName);
    }

    /**
     * @inheritDoc
     */
    public function getLastName(): ?string
    {
        return $this->getDataStringOrNull(self::KEY_LAST_NAME);
    }

    /**
     * @inheritDoc
     */
    public function setLastName(?string $lastName): FulfillmentDestinationResponseInterface
    {
        return $this->setData(self::KEY_LAST_NAME, $lastName);
    }

    /**
     * @inheritDoc
     */
    public function getPhoneNumber(): ?string
    {
        return $this->getDataStringOrNull(self::KEY_PHONE_NUMBER);
    }

    /**
     * @inheritDoc
     */
    public function setPhoneNumber(?string $phoneNumber): FulfillmentDestinationResponseInterface
    {
        return $this->setData(self::KEY_PHONE_NUMBER, $phoneNumber);
    }

    /**
     * @inheritDoc
     */
    public function getPostalCode(): ?string
    {
        return $this->getDataStringOrNull(self::KEY_POSTAL_CODE);
    }

    /**
     * @inheritDoc
     */
    public function setPostalCode(?string $postalCode): FulfillmentDestinationResponseInterface
    {
        return $this->setData(self::KEY_POSTAL_CODE, $postalCode);
    }

    /**
     * @inheritDoc
     */
    public function getStreetAddress(): ?string
    {
        return $this->getDataStringOrNull(self::KEY_STREET_ADDRESS);
    }

    /**
     * @inheritDoc
     */
    public function setStreetAddress(?string $streetAddress): FulfillmentDestinationResponseInterface
    {
        return $this->setData(self::KEY_STREET_ADDRESS, $streetAddress);
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
    public function setId(string $id): FulfillmentDestinationResponseInterface
    {
        return $this->setData(self::KEY_ID, $id);
    }

    /**
     * @inheritDoc
     */
    public function getAddress(): ?PostalAddressInterface
    {
        return $this->getDataInstance(self::KEY_ADDRESS, PostalAddressInterface::class, $this->addressFactory->create(...));
    }

    /**
     * @inheritDoc
     */
    public function setAddress(?PostalAddressInterface $address): FulfillmentDestinationResponseInterface
    {
        return $this->setData(self::KEY_ADDRESS, $address);
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
    public function setName(?string $name): FulfillmentDestinationResponseInterface
    {
        return $this->setData(self::KEY_NAME, $name);
    }
}
