<?php

/**
 * This file is part of the Magebit_UniversalCommerce package.
 *
 * @copyright Copyright (c) 2026 Magebit, Ltd. (https://magebit.com/)
 * @author    Magebit <info@magebit.com>
 * @license   MIT
 */
declare(strict_types=1);

namespace Magebit\UniversalCommerce\Model\Discovery;

use Magebit\UcpSpec\Api\Discovery\UCPDiscoveryProfileInterface as DiscoveryProfileInterface;
use Magebit\UcpSpec\Api\Discovery\UCPDiscoveryProfileInterfaceFactory as DiscoveryProfileInterfaceFactory;

use Magebit\UcpSpec\Api\Schemas\UcpDiscoveryProfileInterface as UcpProfileInterface;
use Magebit\UcpSpec\Api\Schemas\UcpDiscoveryProfileInterfaceFactory as UcpProfileInterfaceFactory;
use Magebit\UniversalCommerce\Api\ServiceInterface;

class MerchantProfileBuilder
{
    /**
     * @param DiscoveryProfileInterfaceFactory $discoveryProfileFactory
     * @param UcpProfileInterfaceFactory $ucpProfileFactory
     * @param ServiceRegistry $serviceRegistry
     */
    public function __construct(
        private readonly DiscoveryProfileInterfaceFactory $discoveryProfileFactory,
        private readonly UcpProfileInterfaceFactory $ucpProfileFactory,
        private readonly ServiceRegistry $serviceRegistry,
    ) {
    }

    /**
     * @return DiscoveryProfileInterface
     */
    public function build(): DiscoveryProfileInterface
    {
        return $this->discoveryProfileFactory->create([
            'data' => [
                DiscoveryProfileInterface::KEY_UCP => $this->buildUcp(),
            ]
        ]);
    }

    /**
     * @return UcpProfileInterface
     */
    public function buildUcp(): UcpProfileInterface
    {
        $registeredServices = $this->serviceRegistry->getServices();
        $services = [];
        $capabilities = [];

        foreach ($registeredServices as $name => $service) {
            $services[$name] = $service->getService();
            $capabilities = array_merge($capabilities, $service->getCapabilities());
        }

        return $this->ucpProfileFactory->create([
            'data' => [
                UcpProfileInterface::KEY_VERSION => '2026-01-11',
                UcpProfileInterface::KEY_SERVICES => $services,
                UcpProfileInterface::KEY_CAPABILITIES => $capabilities,
            ]
        ]);
    }
}
