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
use Magebit\UcpSpec\MutableApi\Schemas\Shopping\Types\PaymentInstrumentInterface;
use Magebit\UcpSpec\MutableApi\Schemas\Shopping\Types\PostalAddressInterface;
use Magebit\UcpSpec\MutableApi\Schemas\Shopping\Types\PaymentCredentialInterface;

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
     * @return array<mixed>|null
     */
    public function getDisplay(): array|null
    {
        $value = $this->getData(PaymentInstrumentInterface::KEY_DISPLAY);
        if ($value === null || $value === false) {
            return null;
        }
        return is_array($value) ? $value : null;
    }

    /**
     * @param string $id
     * @return self
     */
    public function setId(string $id): self
    {
        $this->setData(PaymentInstrumentInterface::KEY_ID, $id);
        return $this;
    }

    /**
     * @param string $handlerId
     * @return self
     */
    public function setHandlerId(string $handlerId): self
    {
        $this->setData(PaymentInstrumentInterface::KEY_HANDLER_ID, $handlerId);
        return $this;
    }

    /**
     * @param string $type
     * @return self
     */
    public function setType(string $type): self
    {
        $this->setData(PaymentInstrumentInterface::KEY_TYPE, $type);
        return $this;
    }

    /**
     * @param PostalAddressInterface|null $billingAddress
     * @return self
     */
    public function setBillingAddress(?PostalAddressInterface $billingAddress): self
    {
        $this->setData(PaymentInstrumentInterface::KEY_BILLING_ADDRESS, $billingAddress);
        return $this;
    }

    /**
     * @param PaymentCredentialInterface|null $credential
     * @return self
     */
    public function setCredential(?PaymentCredentialInterface $credential): self
    {
        $this->setData(PaymentInstrumentInterface::KEY_CREDENTIAL, $credential);
        return $this;
    }

    /**
     * @param array<mixed>|null $display
     * @return self
     */
    public function setDisplay(?array $display): self
    {
        $this->setData(PaymentInstrumentInterface::KEY_DISPLAY, $display);
        return $this;
    }
}
