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
use Magebit\UcpSpec\Api\Schemas\Shopping\Types\PaymentInstrumentInterface;
use Magebit\UcpSpec\Api\Schemas\Shopping\Types\PostalAddressInterface;
use Magebit\UcpSpec\Api\Schemas\Shopping\Types\PaymentCredentialInterface;

class PaymentInstrument extends DataTransferObject implements PaymentInstrumentInterface
{
    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->getDataString(PaymentInstrumentInterface::KEY_ID);
    }

    /**
     * @return string
     */
    public function getHandlerId(): string
    {
        return $this->getDataString(PaymentInstrumentInterface::KEY_HANDLER_ID);
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->getDataString(PaymentInstrumentInterface::KEY_TYPE);
    }

    /**
     * @return PostalAddressInterface|null
     */
    public function getBillingAddress(): PostalAddressInterface|null
    {
        return $this->getDataOfTypeOrNull(
            PaymentInstrumentInterface::KEY_BILLING_ADDRESS,
            PostalAddressInterface::class
        );
    }

    /**
     * @return PaymentCredentialInterface|null
     */
    public function getCredential(): PaymentCredentialInterface|null
    {
        return $this->getDataOfTypeOrNull(
            PaymentInstrumentInterface::KEY_CREDENTIAL,
            PaymentCredentialInterface::class
        );
    }

    /**
     * @return string
     */
    public function getBrand(): string
    {
        return $this->getDataString(PaymentInstrumentInterface::KEY_BRAND);
    }

    /**
     * @return string
     */
    public function getLastDigits(): string
    {
        return $this->getDataString(PaymentInstrumentInterface::KEY_LAST_DIGITS);
    }

    /**
     * @return int|null
     */
    public function getExpiryMonth(): int|null
    {
        $value = $this->getData(PaymentInstrumentInterface::KEY_EXPIRY_MONTH);
        if ($value === null) {
            return null;
        }
        if (!is_int($value)) {
            throw new \InvalidArgumentException(
                sprintf('Data for key %s is not an int', PaymentInstrumentInterface::KEY_EXPIRY_MONTH)
            );
        }
        return $value;
    }

    /**
     * @return int|null
     */
    public function getExpiryYear(): int|null
    {
        $value = $this->getData(PaymentInstrumentInterface::KEY_EXPIRY_YEAR);
        if ($value === null) {
            return null;
        }
        if (!is_int($value)) {
            throw new \InvalidArgumentException(
                sprintf('Data for key %s is not an int', PaymentInstrumentInterface::KEY_EXPIRY_YEAR)
            );
        }
        return $value;
    }

    /**
     * @return string|null
     */
    public function getRichTextDescription(): string|null
    {
        return $this->getDataStringOrNull(PaymentInstrumentInterface::KEY_RICH_TEXT_DESCRIPTION);
    }

    /**
     * @return string|null
     */
    public function getRichCardArt(): string|null
    {
        return $this->getDataStringOrNull(PaymentInstrumentInterface::KEY_RICH_CARD_ART);
    }
}
