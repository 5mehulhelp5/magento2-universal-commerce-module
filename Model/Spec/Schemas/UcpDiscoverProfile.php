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
use Magebit\UcpSpec\MutableApi\Schemas\UcpPlatformSchemaInterface;
use Magebit\UcpSpec\MutableApi\Schemas\CapabilityPlatformSchemaInterface;
use Magebit\UcpSpec\MutableApi\Schemas\ServicePlatformSchemaInterface;

class UcpDiscoverProfile extends DataTransferObject implements UcpPlatformSchemaInterface
{
    /**
     * @return string
     */
    public function getVersion(): string
    {
        return $this->getDataString(UcpPlatformSchemaInterface::KEY_VERSION);
    }

    /**
     * @return array<string, array<ServicePlatformSchemaInterface>>
     */
    public function getServices(): array
    {
        return $this->getDataArrayOfType(UcpPlatformSchemaInterface::KEY_SERVICES, ServicePlatformSchemaInterface::class);
    }

    /**
     * @return array<string, array<CapabilityPlatformSchemaInterface>>|null
     */
    public function getCapabilities(): array|null
    {
        return $this->getDataArrayOfTypeOrNull(UcpPlatformSchemaInterface::KEY_CAPABILITIES, CapabilityPlatformSchemaInterface::class);
    }

    /**
     * @return array<string, array<\Magebit\UcpSpec\MutableApi\Schemas\PaymentHandlerPlatformSchemaInterface>>
     */
    public function getPaymentHandlers(): array
    {
        return $this->getDataArrayOfType(UcpPlatformSchemaInterface::KEY_PAYMENT_HANDLERS, \Magebit\UcpSpec\MutableApi\Schemas\PaymentHandlerPlatformSchemaInterface::class);
    }

    /**
     * @param string $version
     * @return self
     */
    public function setVersion(string $version): self
    {
        $this->setData(UcpPlatformSchemaInterface::KEY_VERSION, $version);
        return $this;
    }

    /**
     * @param array<string, array<ServicePlatformSchemaInterface>> $services
     * @return self
     */
    public function setServices(array $services): self
    {
        $this->setData(UcpPlatformSchemaInterface::KEY_SERVICES, $services);
        return $this;
    }

    /**
     * @param array<string, array<CapabilityPlatformSchemaInterface>>|null $capabilities
     * @return self
     */
    public function setCapabilities(?array $capabilities): self
    {
        $this->setData(UcpPlatformSchemaInterface::KEY_CAPABILITIES, $capabilities);
        return $this;
    }

    /**
     * @param array<string, array<\Magebit\UcpSpec\MutableApi\Schemas\PaymentHandlerPlatformSchemaInterface>> $paymentHandlers
     * @return self
     */
    public function setPaymentHandlers(array $paymentHandlers): self
    {
        $this->setData(UcpPlatformSchemaInterface::KEY_PAYMENT_HANDLERS, $paymentHandlers);
        return $this;
    }

    /**
     * @return array<mixed>
     */
    public function jsonSerialize(): array
    {
        return $this->toArray();
    }
}
