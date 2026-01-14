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

use Magebit\UniversalCommerce\Api\Data\Spec\BuyerInterface;
use Magebit\UniversalCommerce\Model\Data\DataTransferObject;

/**
 * Buyer Model
 */
class Buyer extends DataTransferObject implements BuyerInterface
{
    /**
     * @inheritDoc
     */
    public function getEmail(): ?string
    {
        return $this->getDataStringOrNull(self::EMAIL);
    }

    /**
     * @inheritDoc
     */
    public function setEmail(?string $email): BuyerInterface
    {
        return $this->setData(self::EMAIL, $email);
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
    public function setFirstName(?string $firstName): self
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
    public function setFullName(?string $fullName): self
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
    public function setLastName(?string $lastName): self
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
     * Set phone number
     *
     * @param string|null $phoneNumber
     * @return $this
     */
    public function setPhoneNumber(?string $phoneNumber): BuyerInterface
    {
        return $this->setData(self::PHONE_NUMBER, $phoneNumber);
    }
}
