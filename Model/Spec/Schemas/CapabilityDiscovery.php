<?php

/**
 * This file is part of the Magebit_UniversalCommerce package.
 *
 * @copyright Copyright (c) 2026 Magebit, Ltd. (https://magebit.com/)
 * @author    Magebit <info@magebit.com>
 * @license   MIT
 */

declare(strict_types=1);

namespace Magebit\UniversalCommerce\Model\Spec\Schemas;

use Magebit\UniversalCommerce\Model\DataTransferObject;
use Magebit\UcpSpec\Api\Schemas\CapabilityDiscoveryInterface;

class CapabilityDiscovery extends DataTransferObject implements CapabilityDiscoveryInterface
{
    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->getDataString(CapabilityDiscoveryInterface::KEY_NAME);
    }

    /**
     * @return string
     */
    public function getVersion(): string
    {
        return $this->getDataString(CapabilityDiscoveryInterface::KEY_VERSION);
    }

    /**
     * @return string
     */
    public function getSpec(): string
    {
        return $this->getDataString(CapabilityDiscoveryInterface::KEY_SPEC);
    }

    /**
     * @return string
     */
    public function getSchema(): string
    {
        return $this->getDataString(CapabilityDiscoveryInterface::KEY_SCHEMA);
    }

    /**
     * @return string|null
     */
    public function getExtends(): string|null
    {
        return $this->getDataStringOrNull(CapabilityDiscoveryInterface::KEY_EXTENDS);
    }

    /**
     * @return array<mixed>|null
     */
    public function getConfig(): array|null
    {
        return $this->getDataArray(CapabilityDiscoveryInterface::KEY_CONFIG);
    }

    /**
     * @return array<mixed>
     */
    public function jsonSerialize(): array
    {
        return $this->toArray();
    }
}
