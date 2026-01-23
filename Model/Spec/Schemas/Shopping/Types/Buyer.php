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
use Magebit\UcpSpec\Api\Schemas\Shopping\Types\BuyerInterface;

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
}
