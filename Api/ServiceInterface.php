<?php

/**
 * This file is part of the Magebit_UniversalCommerce package.
 *
 * @copyright Copyright (c) 2026 Magebit, Ltd. (https://magebit.com/)
 * @author    Magebit <info@magebit.com>
 * @license   MIT
 */
declare(strict_types=1);

namespace Magebit\UniversalCommerce\Api;

use Magebit\UcpSpec\Api\Services\UCPServiceInterface;
use Magebit\UcpSpec\Api\Schemas\CapabilityDiscoveryInterface;

interface ServiceInterface
{
    /**
     * @return UCPServiceInterface
     */
    public function getService(): UCPServiceInterface;

    /**
     * @return array<CapabilityDiscoveryInterface>
     */
    public function getCapabilities(): array;
}
