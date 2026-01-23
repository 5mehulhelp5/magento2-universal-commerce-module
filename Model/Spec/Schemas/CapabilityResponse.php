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
use Magebit\UcpSpec\Api\Schemas\CapabilityResponseInterface;

class CapabilityResponse extends DataTransferObject implements CapabilityResponseInterface
{
    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->getDataString(CapabilityResponseInterface::KEY_NAME);
    }

    /**
     * @return string
     */
    public function getVersion(): string
    {
        return $this->getDataString(CapabilityResponseInterface::KEY_VERSION);
    }

    /**
     * @return string|null
     */
    public function getSpec(): string|null
    {
        return $this->getDataStringOrNull(CapabilityResponseInterface::KEY_SPEC);
    }

    /**
     * @return string|null
     */
    public function getSchema(): string|null
    {
        return $this->getDataStringOrNull(CapabilityResponseInterface::KEY_SCHEMA);
    }

    /**
     * @return string|null
     */
    public function getExtends(): string|null
    {
        return $this->getDataStringOrNull(CapabilityResponseInterface::KEY_EXTENDS);
    }

    /**
     * @return array<mixed>|null
     */
    public function getConfig(): array|null
    {
        return $this->getDataArray(CapabilityResponseInterface::KEY_CONFIG);
    }
}
