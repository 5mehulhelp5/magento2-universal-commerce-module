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

use Magebit\UcpSpec\MutableApi\Schemas\UcpDiscoveryProfileInterface;
use Magebit\UniversalCommerce\Api\Payment\PaymentHandlerInterface;
use Magebit\UniversalCommerce\Model\Payment\PaymentHandlerPool;
use Magento\Quote\Api\Data\CartInterface;
use Magebit\UcpSpec\MutableApi\Services\UCPServiceInterface;
use Magebit\UcpSpec\MutableApi\Schemas\CapabilityDiscoveryInterface;
use JsonSerializable;

class UcpDiscoveryProfile implements UcpDiscoveryProfileInterface, JsonSerializable
{
    public const UCP_VERSION = '2026-01-11';

    /**
     * @param PaymentHandlerPool $paymentHandlerPool
     * @param array<string, CapabilityDiscoveryInterface> $capabilities
     * @param array<string, UCPServiceInterface> $services
     */
    public function __construct(
        private readonly PaymentHandlerPool $paymentHandlerPool,
        private readonly array $capabilities = [],
        private readonly array $services = []
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
     * Set version
     *
     * @param string $version
     * @return self
     */
    public function setVersion(string $version): self
    {
        return $this;
    }

    /**
     * Set services
     *
     * @param array<string, UCPServiceInterface> $services
     * @return self
     */
    public function setServices(array $services): self
    {
        return $this;
    }

    /**
     * Get services
     *
     * @return array<string, UCPServiceInterface>
     */
    public function getServices(): array
    {
        return $this->services;
    }

    /**
     * Set capabilities
     *
     * @param array<CapabilityDiscoveryInterface> $capabilities
     * @return self
     */
    public function setCapabilities(array $capabilities): self
    {
        return $this;
    }

    /**
     * Get capabilities
     *
     * @return array<CapabilityDiscoveryInterface>
     */
    public function getCapabilities(): array
    {
        return array_values($this->capabilities);
    }

    /**
     * Get payment handlers
     *
     * @param CartInterface|null $cart Optional quote for quote-specific filtering
     * @return array<PaymentHandlerInterface>
     */
    public function getPaymentHandlers(?CartInterface $cart = null): array
    {
        if ($cart !== null) {
            // Quote-specific filtering - check availability for this specific quote
            $handlers = $this->paymentHandlerPool->getAvailableForQuote($cart);
        } else {
            // Discovery endpoint - only return enabled methods (no quote context)
            $handlers = $this->paymentHandlerPool->getEnabledHandlers();
        }

        return array_values($handlers);
    }

    /**
     * Set payment handlers
     *
     * @param array<PaymentHandlerInterface> $handlers
     * @return self
     */
    public function setPaymentHandlers(array $handlers): self
    {
        return $this;
    }

    /**
     * Serialize to JSON
     *
     * @return array<mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'ucp' => [
                self::KEY_VERSION => $this->getVersion(),
                self::KEY_CAPABILITIES => array_map(function (CapabilityDiscoveryInterface $capability) {
                    return [
                        'name' => $capability->getName(),
                        'version' => $capability->getVersion(),
                        'spec' => $capability->getSpec(),
                        'schema' => $capability->getSchema(),
                        'extends' => $capability->getExtends(),
                        'config' => $capability->getConfig(),
                    ];
                }, $this->getCapabilities()),
                self::KEY_SERVICES => array_map(function (UCPServiceInterface $service) {
                    return [
                        'version' => $service->getVersion(),
                        'spec' => $service->getSpec(),
                        'rest' => $service->getRest()?->toArray() ?? [],
                    ];
                }, $this->getServices()),
            ],
            'payment' => [
                'handlers' => array_map(function (PaymentHandlerInterface $handler) {
                    return [
                        'id' => $handler->getId(),
                        'name' => $handler->getName(),
                        'version' => $handler->getVersion(),
                        'spec' => $handler->getSpec(),
                        'config_schema' => $handler->getConfigSchema(),
                        'instrument_schemas' => $handler->getInstrumentSchemas(),
                        'config' => $handler->getConfig(),
                    ];
                }, $this->getPaymentHandlers()),
            ]
        ];
    }
}
