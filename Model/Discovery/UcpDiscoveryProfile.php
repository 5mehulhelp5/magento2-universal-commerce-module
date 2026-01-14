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

use Magebit\UniversalCommerce\Api\Discovery\CapabilityInterface;
use Magebit\UniversalCommerce\Api\Discovery\UcpDiscoveryProfileInterface;
use Magebit\UniversalCommerce\Api\Discovery\ServiceInterface;
use Magebit\UniversalCommerce\Api\Discovery\PaymentHandlerInterface;

class UcpDiscoveryProfile implements UcpDiscoveryProfileInterface
{
    public const UCP_VERSION = '2026-01-11';

    /**
     * @param array<CapabilityInterface> $capabilities
     * @param array<ServiceInterface> $services
     * @param array<PaymentHandlerInterface> $paymentHandlers
     */
    public function __construct(
        private readonly array $capabilities = [],
        private readonly array $services = [],
        private readonly array $paymentHandlers = [],
    ) {
    }

    /**
     * Get version
     *
     * @return string
     */
    public function getVersion(): string
    {
        return self::UCP_VERSION;
    }

    /**
     * Get services
     *
     * @return array<string, array{version: string, spec: string, rest: array{schema: string, endpoint: string}}>
     */
    public function getServices(): array
    {
        $services = [];
        foreach ($this->services as $key => $service) {
            $services[$key] = [
                'version' => $service->getVersion(),
                'spec' => $service->getSpec(),
                'rest' => [
                    'schema' => $service->getRestSchema(),
                    'endpoint' => $service->getRestEndpoint(),
                ]
            ];
        }
        return $services;
    }

    /**
     * @return array<array{name: string, version: string, spec: string, schema: string}>
     */
    public function getCapabilities(): array
    {
        return array_map(function (CapabilityInterface $capability) {
            return [
                'name' => $capability->getName(),
                'version' => $capability->getVersion(),
                'spec' => $capability->getSpec(),
                'schema' => $capability->getSchema(),
            ];
        }, array_values($this->capabilities));
    }

    /**
     * Get payment handlers
     *
     * @return array<mixed>
     */
    public function getPaymentHandlers(): array
    {
        return array_map(function (PaymentHandlerInterface $paymentHandler) {
            return [
                'id' => $paymentHandler->getId(),
                'version' => $paymentHandler->getVersion(),
                'spec' => $paymentHandler->getSpec(),
                'config_schema' => $paymentHandler->getConfigSchema(),
                'instrument_schemas' => $paymentHandler->getInstrumentSchemas(),
                'config' => $paymentHandler->getConfig()
            ];
        }, array_values($this->paymentHandlers));
    }

    /**
     * @return array<mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'ucp' => [
                self::VERSION => $this->getVersion(),
                self::CAPABILITIES => $this->getCapabilities(),
                self::SERVICES => $this->getServices(),
            ],
            'payment' => [
                'handlers' => $this->getPaymentHandlers()
            ]
        ];
    }
}
