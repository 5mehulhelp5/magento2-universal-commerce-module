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
use Magebit\UcpSpec\Api\ServiceBusinessSchemaInterface;
use Magebit\UcpSpec\Api\ServiceBusinessSchemaInterfaceFactory;
use Magebit\UcpSpec\Api\CapabilityBusinessSchemaInterface;
use Magebit\UcpSpec\Api\CapabilityBusinessSchemaInterfaceFactory;
use Magebit\UniversalCommerce\Api\UniversalCommerceProtocolInterface;
use Magebit\UniversalCommerce\Model\Config;

class ShoppingService implements ServiceInterface
{
    public const SPEC_URL = 'https://ucp.dev/specs/shopping';

    /**
     * @param ServiceBusinessSchemaInterfaceFactory $serviceFactory
     * @param CapabilityBusinessSchemaInterfaceFactory $capabilityFactory
     * @param Config $config
     * @param array<string, CapabilityBusinessSchemaInterface> $capabilities
     */
    public function __construct(
        private readonly ServiceBusinessSchemaInterfaceFactory $serviceFactory,
        private readonly CapabilityBusinessSchemaInterfaceFactory $capabilityFactory,
        private readonly Config $config,
        private readonly array $capabilities = [],
    ) {
    }

    /**
     * @return ServiceBusinessSchemaInterface
     */
    public function getService(): ServiceBusinessSchemaInterface
    {
        $baseUrl = $this->config->getApiBaseUrl();

        return $this->serviceFactory->create([
            'data' => [
                ServiceBusinessSchemaInterface::KEY_VERSION => UniversalCommerceProtocolInterface::SPEC_VERSION,
                ServiceBusinessSchemaInterface::KEY_SPEC => self::SPEC_URL,
                ServiceBusinessSchemaInterface::KEY_SCHEMA => 'https://ucp.dev/services/shopping/openapi.json',
                ServiceBusinessSchemaInterface::KEY_TRANSPORT => ServiceBusinessSchemaInterface::TRANSPORT_REST,
                ServiceBusinessSchemaInterface::KEY_ENDPOINT => $baseUrl . '/ucp/shopping',
            ]
        ]);
    }

    /**
     * @return array<string, array<CapabilityBusinessSchemaInterface>>
     */
    public function getCapabilities(): array
    {
        $result = [];

        foreach ($this->capabilities as $name => $capability) {
            $capabilitySchema = $this->capabilityFactory->create([
                'data' => array_filter([
                    CapabilityBusinessSchemaInterface::KEY_VERSION => $capability->getVersion(),
                    CapabilityBusinessSchemaInterface::KEY_SPEC => $capability->getSpec(),
                    CapabilityBusinessSchemaInterface::KEY_SCHEMA => $capability->getSchema(),
                    CapabilityBusinessSchemaInterface::KEY_EXTENDS => $capability->getExtends(),
                    CapabilityBusinessSchemaInterface::KEY_CONFIG => $capability->getConfig(),
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
