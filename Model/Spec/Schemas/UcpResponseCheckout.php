<?php

/**
 * This file is part of the Magebit_UniversalCommerce package.
 *
 * @copyright Copyright (c) 2026 Magebit, Ltd. (https://magebit.com/)
 * @author    Magebit <info@magebit.com>
 * @license   MIT
 */

declare(strict_types=1);

namespace Magebit\UniversalCommerce\Model\Spec\Schemas;

use Magebit\UniversalCommerce\Model\DataTransferObject;
use Magebit\UcpSpec\MutableApi\Schemas\UcpResponseCheckoutSchemaInterface;
use Magebit\UcpSpec\MutableApi\Schemas\CapabilityResponseSchemaInterface;
use Magebit\UcpSpec\MutableApi\Schemas\ServiceResponseSchemaInterface;
use Magebit\UcpSpec\MutableApi\Schemas\PaymentHandlerResponseSchemaInterface;

class UcpResponseCheckout extends DataTransferObject implements UcpResponseCheckoutSchemaInterface
{
    /**
     * @return string
     */
    public function getVersion(): string
    {
        return $this->getDataString(UcpResponseCheckoutSchemaInterface::KEY_VERSION);
    }

    /**
     * @return array<string, array<ServiceResponseSchemaInterface>>|null
     */
    public function getServices(): array|null
    {
        return $this->getDataArrayOfTypeOrNull(
            UcpResponseCheckoutSchemaInterface::KEY_SERVICES,
            ServiceResponseSchemaInterface::class
        );
    }

    /**
     * @return array<string, array<CapabilityResponseSchemaInterface>>|null
     */
    public function getCapabilities(): array|null
    {
        return $this->getDataArrayOfTypeOrNull(
            UcpResponseCheckoutSchemaInterface::KEY_CAPABILITIES,
            CapabilityResponseSchemaInterface::class
        );
    }

    /**
     * @return array<string, array<PaymentHandlerResponseSchemaInterface>>
     */
    public function getPaymentHandlers(): array
    {
        return $this->getDataArrayOfType(
            UcpResponseCheckoutSchemaInterface::KEY_PAYMENT_HANDLERS,
            PaymentHandlerResponseSchemaInterface::class
        );
    }

    /**
     * @param string $version
     * @return self
     */
    public function setVersion(string $version): self
    {
        $this->setData(UcpResponseCheckoutSchemaInterface::KEY_VERSION, $version);
        return $this;
    }

    /**
     * @param array<string, array<ServiceResponseSchemaInterface>>|null $services
     * @return self
     */
    public function setServices(?array $services): self
    {
        $this->setData(UcpResponseCheckoutSchemaInterface::KEY_SERVICES, $services);
        return $this;
    }

    /**
     * @param array<string, array<CapabilityResponseSchemaInterface>>|null $capabilities
     * @return self
     */
    public function setCapabilities(?array $capabilities): self
    {
        $this->setData(UcpResponseCheckoutSchemaInterface::KEY_CAPABILITIES, $capabilities);
        return $this;
    }

    /**
     * @param array<string, array<PaymentHandlerResponseSchemaInterface>> $paymentHandlers
     * @return self
     */
    public function setPaymentHandlers(array $paymentHandlers): self
    {
        $this->setData(UcpResponseCheckoutSchemaInterface::KEY_PAYMENT_HANDLERS, $paymentHandlers);
        return $this;
    }
}
