<?php

/**
 * This file is part of the Magebit_UniversalCommerce package.
 *
 * @copyright Copyright (c) 2026 Magebit, Ltd. (https://magebit.com/)
 * @author    Magebit <info@magebit.com>
 * @license   MIT
 */

declare(strict_types=1);

namespace Magebit\UniversalCommerce\Model\Data\Spec\Response;

use Magebit\UniversalCommerce\Api\Data\Spec\PostalAddressInterface;
use Magebit\UniversalCommerce\Api\Data\Spec\PostalAddressInterfaceFactory;
use Magebit\UniversalCommerce\Api\Data\Spec\Response\FulfillmentDestinationResponseInterface;
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
        return $this->getDataStringOrNull(self::ADDRESS_COUNTRY);
    }

    /**
     * @inheritDoc
     */
    public function setAddressCountry(?string $addressCountry): FulfillmentDestinationResponseInterface
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
    public function setAddressLocality(?string $addressLocality): FulfillmentDestinationResponseInterface
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
    public function setAddressRegion(?string $addressRegion): FulfillmentDestinationResponseInterface
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
    public function setExtendedAddress(?string $extendedAddress): FulfillmentDestinationResponseInterface
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
    public function setFirstName(?string $firstName): FulfillmentDestinationResponseInterface
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
    public function setFullName(?string $fullName): FulfillmentDestinationResponseInterface
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
    public function setLastName(?string $lastName): FulfillmentDestinationResponseInterface
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
    public function setPhoneNumber(?string $phoneNumber): FulfillmentDestinationResponseInterface
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
    public function setPostalCode(?string $postalCode): FulfillmentDestinationResponseInterface
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
    public function setStreetAddress(?string $streetAddress): FulfillmentDestinationResponseInterface
    {
        return $this->setData(self::STREET_ADDRESS, $streetAddress);
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
    public function setId(string $id): FulfillmentDestinationResponseInterface
    {
        return $this->setData(self::ID, $id);
    }

    /**
     * @inheritDoc
     */
    public function getAddress(): ?PostalAddressInterface
    {
        return $this->getDataInstance(self::ADDRESS, PostalAddressInterface::class, $this->addressFactory->create(...));
    }

    /**
     * @inheritDoc
     */
    public function setAddress(?PostalAddressInterface $address): FulfillmentDestinationResponseInterface
    {
        return $this->setData(self::ADDRESS, $address);
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
    public function setName(?string $name): FulfillmentDestinationResponseInterface
    {
        return $this->setData(self::NAME, $name);
    }
}
