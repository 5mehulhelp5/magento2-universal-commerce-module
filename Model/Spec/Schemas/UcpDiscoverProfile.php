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
use Magebit\UcpSpec\Api\Schemas\UcpDiscoveryProfileInterface;
use Magebit\UcpSpec\Api\Schemas\CapabilityDiscoveryInterface;
use Magebit\UcpSpec\Api\Services\UCPServiceInterface;

class UcpDiscoverProfile extends DataTransferObject implements UcpDiscoveryProfileInterface
{
    /**
     * @return string
     */
    public function getVersion(): string
    {
        return $this->getDataString(UcpDiscoveryProfileInterface::KEY_VERSION);
    }

    /**
     * @return array<string, UCPServiceInterface>
     */
    public function getServices(): array
    {
        return $this->getDataArrayOfType(UcpDiscoveryProfileInterface::KEY_SERVICES, UCPServiceInterface::class);
    }

    /**
     * @return array<CapabilityDiscoveryInterface>
     */
    public function getCapabilities(): array
    {
        return $this->getDataArrayOfType(UcpDiscoveryProfileInterface::KEY_CAPABILITIES, CapabilityDiscoveryInterface::class);
    }

    /**
     * @return array<mixed>
     */
    public function jsonSerialize(): array
    {
        return $this->toArray();
    }
}
