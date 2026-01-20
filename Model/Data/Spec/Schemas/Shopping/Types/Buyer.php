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

use Magebit\UcpSpec\MutableApi\Schemas\Shopping\Types\BuyerInterface;
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
        return $this->getDataStringOrNull(self::KEY_EMAIL);
    }

    /**
     * @inheritDoc
     */
    public function setEmail(?string $email): BuyerInterface
    {
        return $this->setData(self::KEY_EMAIL, $email);
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
    public function setFirstName(?string $firstName): self
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
    public function setFullName(?string $fullName): self
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
    public function setLastName(?string $lastName): self
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
     * Set phone number
     *
     * @param string|null $phoneNumber
     * @return $this
     */
    public function setPhoneNumber(?string $phoneNumber): BuyerInterface
    {
        return $this->setData(self::KEY_PHONE_NUMBER, $phoneNumber);
    }
}
