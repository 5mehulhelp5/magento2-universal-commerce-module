<?php

/**
 * This file is part of the Magebit_UniversalCommerce package.
 *
 * @copyright Copyright (c) 2026 Magebit, Ltd. (https://magebit.com/)
 * @author    Magebit <info@magebit.com>
 * @license   MIT
 */
declare(strict_types=1);

namespace Magebit\UniversalCommerce\Model\Service\Shopping;

use Magebit\UniversalCommerce\Api\ServiceInterface;
use Magebit\UcpSpec\Api\Services\UCPServiceInterface;
use Magebit\UcpSpec\Api\Services\UCPServiceInterfaceFactory;
use Magebit\UcpSpec\Api\Services\UCPServiceRestInterface;
use Magebit\UcpSpec\Api\Services\UCPServiceRestInterfaceFactory;
use Magebit\UcpSpec\Api\Schemas\CapabilityDiscoveryInterface;
use Magebit\UcpSpec\Api\Schemas\CapabilityDiscoveryInterfaceFactory;
use Magebit\UniversalCommerce\Api\UniversalCommerceProtocolInterface;
use Magebit\UniversalCommerce\Model\Config;

class ShoppingService implements ServiceInterface
{
    public const SPEC_URL = 'https://ucp.dev/specs/shopping';

    /**
     * @param UCPServiceInterfaceFactory $ucpServiceFactory
     * @param UCPServiceRestInterfaceFactory $ucpServiceRestFactory
     * @param CapabilityDiscoveryInterfaceFactory $capabilityDiscoveryFactory
     * @param Config $config
     * @param array<CapabilityDiscoveryInterface> $capabilities
     */
    public function __construct(
        private readonly UCPServiceInterfaceFactory $ucpServiceFactory,
        private readonly UCPServiceRestInterfaceFactory $ucpServiceRestFactory,
        private readonly CapabilityDiscoveryInterfaceFactory $capabilityDiscoveryFactory,
        private readonly Config $config,
        private readonly array $capabilities = [],
    ) {
    }

    /**
     * @return UCPServiceInterface
     */
    public function getService(): UCPServiceInterface
    {
        return $this->ucpServiceFactory->create([
            'data' => [
                UCPServiceInterface::KEY_VERSION => UniversalCommerceProtocolInterface::SPEC_VERSION,
                UCPServiceInterface::KEY_SPEC => self::SPEC_URL,
                UCPServiceInterface::KEY_REST => $this->getRest(),
            ]
        ]);
    }

    /**
     * @return array<CapabilityDiscoveryInterface>
     */
    public function getCapabilities(): array
    {
        return array_map(function (CapabilityDiscoveryInterface $capability) {
            return $this->capabilityDiscoveryFactory->create([
                'data' => array_filter([
                    CapabilityDiscoveryInterface::KEY_NAME => $capability->getName(),
                    CapabilityDiscoveryInterface::KEY_VERSION => $capability->getVersion(),
                    CapabilityDiscoveryInterface::KEY_SPEC => $capability->getSpec(),
                    CapabilityDiscoveryInterface::KEY_SCHEMA => $capability->getSchema(),
                    CapabilityDiscoveryInterface::KEY_EXTENDS => $capability->getExtends(),
                    CapabilityDiscoveryInterface::KEY_CONFIG => $capability->getConfig(),
                ])
            ]);
        }, array_values($this->capabilities));
    }

    /**
     * @return UCPServiceRestInterface
     */
    public function getRest(): UCPServiceRestInterface
    {
        $baseUrl = $this->config->getApiBaseUrl();

        return $this->ucpServiceRestFactory->create([
            'data' => [
                UCPServiceRestInterface::KEY_SCHEMA => 'https://ucp.dev/services/shopping/openapi.json',
                UCPServiceRestInterface::KEY_ENDPOINT => $baseUrl . '/ucp/shopping',
            ]
        ]);
    }
}
