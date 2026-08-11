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

use Magebit\UcpSpec\MutableApi\Schemas\Shopping\Types\PaymentCredentialInterface;
use Magebit\UcpSpec\MutableApi\Schemas\Shopping\Types\PostalAddressInterface;
use Magebit\UcpSpec\MutableApi\Schemas\Shopping\Types\SelectedPaymentInstrumentInterface;
use Magebit\UniversalCommerce\Model\DataTransferObject;

class SelectedPaymentInstrument extends DataTransferObject implements SelectedPaymentInstrumentInterface
{
    /**
     * @return string
     * @throws \InvalidArgumentException
     */
    public function getId(): string
    {
        return $this->getDataString(SelectedPaymentInstrumentInterface::KEY_ID);
    }

    /**
     * @param string $id
     * @return self
     */
    public function setId(string $id): self
    {
        $this->setData(SelectedPaymentInstrumentInterface::KEY_ID, $id);
        return $this;
    }

    /**
     * @return string
     * @throws \InvalidArgumentException
     */
    public function getHandlerId(): string
    {
        return $this->getDataString(SelectedPaymentInstrumentInterface::KEY_HANDLER_ID);
    }

    /**
     * @param string $handlerId
     * @return self
     */
    public function setHandlerId(string $handlerId): self
    {
        $this->setData(SelectedPaymentInstrumentInterface::KEY_HANDLER_ID, $handlerId);
        return $this;
    }

    /**
     * @return string
     * @throws \InvalidArgumentException
     */
    public function getType(): string
    {
        return $this->getDataString(SelectedPaymentInstrumentInterface::KEY_TYPE);
    }

    /**
     * @param string $type
     * @return self
     */
    public function setType(string $type): self
    {
        $this->setData(SelectedPaymentInstrumentInterface::KEY_TYPE, $type);
        return $this;
    }

    /**
     * @return PostalAddressInterface|null
     */
    public function getBillingAddress(): PostalAddressInterface|null
    {
        return $this->getDataOfTypeOrNull(
            SelectedPaymentInstrumentInterface::KEY_BILLING_ADDRESS,
            PostalAddressInterface::class
        );
    }

    /**
     * @param PostalAddressInterface|null $billingAddress
     * @return self
     */
    public function setBillingAddress(?PostalAddressInterface $billingAddress): self
    {
        $this->setData(SelectedPaymentInstrumentInterface::KEY_BILLING_ADDRESS, $billingAddress);
        return $this;
    }

    /**
     * @return PaymentCredentialInterface|null
     */
    public function getCredential(): PaymentCredentialInterface|null
    {
        return $this->getDataOfTypeOrNull(
            SelectedPaymentInstrumentInterface::KEY_CREDENTIAL,
            PaymentCredentialInterface::class
        );
    }

    /**
     * @param PaymentCredentialInterface|null $credential
     * @return self
     */
    public function setCredential(?PaymentCredentialInterface $credential): self
    {
        $this->setData(SelectedPaymentInstrumentInterface::KEY_CREDENTIAL, $credential);
        return $this;
    }

    /**
     * @return array<mixed>|null
     */
    public function getDisplay(): array|null
    {
        $display = $this->getData(SelectedPaymentInstrumentInterface::KEY_DISPLAY);

        return is_array($display) ? $display : null;
    }

    /**
     * @param array<mixed>|null $display
     * @return self
     */
    public function setDisplay(?array $display): self
    {
        $this->setData(SelectedPaymentInstrumentInterface::KEY_DISPLAY, $display);
        return $this;
    }

    /**
     * @return bool|null
     */
    public function getSelected(): bool|null
    {
        $selected = $this->getData(SelectedPaymentInstrumentInterface::KEY_SELECTED);

        return is_bool($selected) ? $selected : null;
    }

    /**
     * @param bool|null $selected
     * @return self
     */
    public function setSelected(?bool $selected): self
    {
        $this->setData(SelectedPaymentInstrumentInterface::KEY_SELECTED, $selected);
        return $this;
    }
}
