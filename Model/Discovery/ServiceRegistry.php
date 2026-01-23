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

use Magebit\UniversalCommerce\Api\ServiceInterface;

class ServiceRegistry
{
    /**
     * @param array<string, ServiceInterface> $services
     */
    public function __construct(
        private readonly array $services = [],
    ) {
    }

    /**
     * @return array<string, ServiceInterface>
     */
    public function getServices(): array
    {
        return $this->services;
    }

    /**
     * @param string $name
     * @return ServiceInterface
     */
    public function getService(string $name): ServiceInterface|null
    {
        return $this->services[$name] ?? null;
    }
}
