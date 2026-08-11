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
use Magebit\UcpSpec\Api\ServicePlatformSchemaInterface;
use Magebit\UcpSpec\Api\ServicePlatformSchemaInterfaceFactory;
use Magebit\UcpSpec\Api\CapabilityPlatformSchemaInterface;
use Magebit\UcpSpec\Api\CapabilityPlatformSchemaInterfaceFactory;
use Magebit\UniversalCommerce\Api\UniversalCommerceProtocolInterface;
use Magebit\UniversalCommerce\Model\Config;

class ShoppingService implements ServiceInterface
{
    public const SPEC_URL = 'https://ucp.dev/specs/shopping';

    /**
     * @param ServicePlatformSchemaInterfaceFactory $serviceFactory
     * @param CapabilityPlatformSchemaInterfaceFactory $capabilityFactory
     * @param Config $config
     * @param array<string, CapabilityPlatformSchemaInterface> $capabilities
     */
    public function __construct(
        private readonly ServicePlatformSchemaInterfaceFactory $serviceFactory,
        private readonly CapabilityPlatformSchemaInterfaceFactory $capabilityFactory,
        private readonly Config $config,
        private readonly array $capabilities = [],
    ) {
    }

    /**
     * @return ServicePlatformSchemaInterface
     */
    public function getService(): ServicePlatformSchemaInterface
    {
        $baseUrl = $this->config->getApiBaseUrl();

        return $this->serviceFactory->create([
            'data' => [
                ServicePlatformSchemaInterface::KEY_VERSION => UniversalCommerceProtocolInterface::SPEC_VERSION,
                ServicePlatformSchemaInterface::KEY_SPEC => self::SPEC_URL,
                ServicePlatformSchemaInterface::KEY_SCHEMA => 'https://ucp.dev/services/shopping/openapi.json',
                ServicePlatformSchemaInterface::KEY_TRANSPORT => ServicePlatformSchemaInterface::TRANSPORT_REST,
                ServicePlatformSchemaInterface::KEY_ENDPOINT => $baseUrl . '/ucp/shopping',
            ]
        ]);
    }

    /**
     * @return array<string, array<CapabilityPlatformSchemaInterface>>
     */
    public function getCapabilities(): array
    {
        $result = [];

        foreach ($this->capabilities as $name => $capability) {
            $capabilitySchema = $this->capabilityFactory->create([
                'data' => array_filter([
                    CapabilityPlatformSchemaInterface::KEY_VERSION => $capability->getVersion(),
                    CapabilityPlatformSchemaInterface::KEY_SPEC => $capability->getSpec(),
                    CapabilityPlatformSchemaInterface::KEY_SCHEMA => $capability->getSchema(),
                    CapabilityPlatformSchemaInterface::KEY_EXTENDS => $capability->getExtends(),
                    CapabilityPlatformSchemaInterface::KEY_CONFIG => $capability->getConfig(),
                ])
            ]);

            if (!isset($result[$name])) {
                $result[$name] = [];
            }

            $result[$name][] = $capabilitySchema;
        }

        return $result;
    }
}
