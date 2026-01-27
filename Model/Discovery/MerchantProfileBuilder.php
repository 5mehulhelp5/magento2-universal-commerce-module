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

use Magebit\UcpSpec\MutableApi\Discovery\UCPDiscoveryProfileInterface as DiscoveryProfileInterface;
use Magebit\UcpSpec\MutableApi\Discovery\UCPDiscoveryProfileInterfaceFactory as DiscoveryProfileInterfaceFactory;

use Magebit\UcpSpec\MutableApi\Schemas\UcpPlatformSchemaInterface as UcpProfileInterface;
use Magebit\UcpSpec\MutableApi\Schemas\UcpPlatformSchemaInterfaceFactory as UcpProfileInterfaceFactory;
use Magebit\UcpSpec\MutableApi\Schemas\ServicePlatformSchemaInterface;
use Magebit\UcpSpec\MutableApi\Schemas\CapabilityPlatformSchemaInterface;
use Magebit\UniversalCommerce\Api\ServiceInterface;
use Magebit\UniversalCommerce\Api\UniversalCommerceProtocolInterface;

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
            $serviceObj = $service->getService();

            if (!isset($services[$name])) {
                $services[$name] = [];
            }

            $services[$name][] = $serviceObj;

            $serviceCapabilities = $service->getCapabilities();

            foreach ($serviceCapabilities as $capName => $capArray) {
                if (!isset($capabilities[$capName])) {
                    $capabilities[$capName] = [];
                }

                $capabilities[$capName] = array_merge($capabilities[$capName], $capArray);
            }
        }

        return $this->ucpProfileFactory->create([
            'data' => [
                UcpProfileInterface::KEY_VERSION => UniversalCommerceProtocolInterface::SPEC_VERSION,
                UcpProfileInterface::KEY_SERVICES => $services,
                UcpProfileInterface::KEY_CAPABILITIES => $capabilities,
                UcpProfileInterface::KEY_PAYMENT_HANDLERS => [],
            ]
        ]);
    }
}
