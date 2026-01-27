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

use Magebit\UcpSpec\MutableApi\Schemas\ServicePlatformSchemaInterface;
use Magebit\UcpSpec\MutableApi\Schemas\CapabilityPlatformSchemaInterface;

interface ServiceInterface
{
    /**
     * @return ServicePlatformSchemaInterface
     */
    public function getService(): ServicePlatformSchemaInterface;

    /**
     * @return array<string, array<CapabilityPlatformSchemaInterface>>
     */
    public function getCapabilities(): array;
}
