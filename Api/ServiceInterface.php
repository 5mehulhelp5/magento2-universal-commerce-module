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

use Magebit\UcpSpec\Api\ServiceBusinessSchemaInterface;
use Magebit\UcpSpec\Api\CapabilityBusinessSchemaInterface;

interface ServiceInterface
{
    /**
     * @return ServiceBusinessSchemaInterface
     */
    public function getService(): ServiceBusinessSchemaInterface;

    /**
     * @return array<string, array<CapabilityBusinessSchemaInterface>>
     */
    public function getCapabilities(): array;
}
