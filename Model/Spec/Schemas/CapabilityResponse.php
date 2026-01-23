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
use Magebit\UcpSpec\MutableApi\Schemas\CapabilityResponseInterface;

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
        $value = $this->getData(CapabilityResponseInterface::KEY_CONFIG);
        return is_array($value) ? $value : null;
    }

    /**
     * @param string $name
     * @return self
     */
    public function setName(string $name): self
    {
        $this->setData(CapabilityResponseInterface::KEY_NAME, $name);
        return $this;
    }

    /**
     * @param string $version
     * @return self
     */
    public function setVersion(string $version): self
    {
        $this->setData(CapabilityResponseInterface::KEY_VERSION, $version);
        return $this;
    }

    /**
     * @param string|null $spec
     * @return self
     */
    public function setSpec(?string $spec): self
    {
        $this->setData(CapabilityResponseInterface::KEY_SPEC, $spec);
        return $this;
    }

    /**
     * @param string|null $schema
     * @return self
     */
    public function setSchema(?string $schema): self
    {
        $this->setData(CapabilityResponseInterface::KEY_SCHEMA, $schema);
        return $this;
    }

    /**
     * @param string|null $extends
     * @return self
     */
    public function setExtends(?string $extends): self
    {
        $this->setData(CapabilityResponseInterface::KEY_EXTENDS, $extends);
        return $this;
    }

    /**
     * @param array<mixed>|null $config
     * @return self
     */
    public function setConfig(?array $config): self
    {
        $this->setData(CapabilityResponseInterface::KEY_CONFIG, $config);
        return $this;
    }
}
