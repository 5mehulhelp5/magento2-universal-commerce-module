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

class CheckoutCapability implements CapabilityInterface
{
    public const NAME = 'dev.ucp.shopping.checkout';
    public const SPEC = 'https://ucp.dev/specs/checkout';
    public const SCHEMA = 'https://ucp.dev/schemas/shopping/checkout.json';

    /**
     * Get name
     *
     * @return string
     */
    public function getName(): string
    {
        return self::NAME;
    }

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
     * Get schema
     *
     * @return string
     */
    public function getSchema(): string
    {
        return self::SCHEMA;
    }
}
