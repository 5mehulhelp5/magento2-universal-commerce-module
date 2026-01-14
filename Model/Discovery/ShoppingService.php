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

use Magebit\UniversalCommerce\Api\Discovery\ServiceInterface;

class ShoppingService implements ServiceInterface
{
    public const SPEC = 'https://ucp.dev/specs/shopping';
    public const SCHEMA = 'https://ucp.dev/services/shopping/openapi.json';

    /**
     * Get version
     *
     * @return string
     */
    public function getVersion(): string
    {
        return UcpDiscoveryProfile::UCP_VERSION;
    }

    /**
     * Get spec
     *
     * @return string
     */
    public function getSpec(): string
    {
        return self::SPEC;
    }

    /**
     * Get rest schema
     *
     * @return string
     */
    public function getRestSchema(): string
    {
        return self::SCHEMA;
    }

    /**
     * Get rest endpoint
     *
     * @return string
     */
    public function getRestEndpoint(): string
    {
        // TODO: Update
        return '/rest/V1/shopping';
    }
}
