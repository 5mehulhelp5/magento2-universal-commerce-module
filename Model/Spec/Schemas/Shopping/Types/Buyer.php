<?php

/**
 * This file is part of the Magebit_UniversalCommerce package.
 *
 * @copyright Copyright (c) 2026 Magebit, Ltd. (https://magebit.com/)
 * @author    Magebit <info@magebit.com>
 * @license   MIT
 */

declare(strict_types=1);

namespace Magebit\UniversalCommerce\Model\Spec\Schemas\Shopping\Types;

use Magebit\UniversalCommerce\Model\DataTransferObject;
use Magebit\UcpSpec\MutableApi\Schemas\Shopping\Types\BuyerInterface;

class Buyer extends DataTransferObject implements BuyerInterface
{
    /**
     * @return string|null
     */
    public function getFirstName(): string|null
    {
        return $this->getDataStringOrNull(BuyerInterface::KEY_FIRST_NAME);
    }

    /**
     * @return string|null
     */
    public function getLastName(): string|null
    {
        return $this->getDataStringOrNull(BuyerInterface::KEY_LAST_NAME);
    }

    /**
     * @return string|null
     */
    public function getFullName(): string|null
    {
        return $this->getDataStringOrNull(BuyerInterface::KEY_FULL_NAME);
    }

    /**
     * @return string|null
     */
    public function getEmail(): string|null
    {
        return $this->getDataStringOrNull(BuyerInterface::KEY_EMAIL);
    }

    /**
     * @return string|null
     */
    public function getPhoneNumber(): string|null
    {
        return $this->getDataStringOrNull(BuyerInterface::KEY_PHONE_NUMBER);
    }

    /**
     * @param string|null $firstName
     * @return self
     */
    public function setFirstName(?string $firstName): self
    {
        $this->setData(BuyerInterface::KEY_FIRST_NAME, $firstName);
        return $this;
    }

    /**
     * @param string|null $lastName
     * @return self
     */
    public function setLastName(?string $lastName): self
    {
        $this->setData(BuyerInterface::KEY_LAST_NAME, $lastName);
        return $this;
    }

    /**
     * @param string|null $fullName
     * @return self
     */
    public function setFullName(?string $fullName): self
    {
        $this->setData(BuyerInterface::KEY_FULL_NAME, $fullName);
        return $this;
    }

    /**
     * @param string|null $email
     * @return self
     */
    public function setEmail(?string $email): self
    {
        $this->setData(BuyerInterface::KEY_EMAIL, $email);
        return $this;
    }

    /**
     * @param string|null $phoneNumber
     * @return self
     */
    public function setPhoneNumber(?string $phoneNumber): self
    {
        $this->setData(BuyerInterface::KEY_PHONE_NUMBER, $phoneNumber);
        return $this;
    }
}
