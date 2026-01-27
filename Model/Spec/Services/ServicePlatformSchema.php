<?php

/**
 * This file is part of the Magebit_UniversalCommerce package.
 *
 * @copyright Copyright (c) 2026 Magebit, Ltd. (https://magebit.com/)
 * @author    Magebit <info@magebit.com>
 * @license   MIT
 */

declare(strict_types=1);

namespace Magebit\UniversalCommerce\Model\Spec\Services;

use Magebit\UniversalCommerce\Model\DataTransferObject;
use Magebit\UcpSpec\MutableApi\Schemas\ServicePlatformSchemaInterface;
use JsonSerializable;

class ServicePlatformSchema extends DataTransferObject implements ServicePlatformSchemaInterface, JsonSerializable
{
    /**
     * @return string
     */
    public function getVersion(): string
    {
        return $this->getDataString(ServicePlatformSchemaInterface::KEY_VERSION);
    }

    /**
     * @return string
     */
    public function getSpec(): string
    {
        return $this->getDataString(ServicePlatformSchemaInterface::KEY_SPEC);
    }

    /**
     * @return string|null
     */
    public function getSchema(): string|null
    {
        return $this->getDataStringOrNull(ServicePlatformSchemaInterface::KEY_SCHEMA);
    }

    /**
     * @return string|null
     */
    public function getId(): string|null
    {
        return $this->getDataStringOrNull(ServicePlatformSchemaInterface::KEY_ID);
    }

    /**
     * @return array<mixed>|null
     */
    public function getConfig(): array|null
    {
        $value = $this->getData(ServicePlatformSchemaInterface::KEY_CONFIG);
        if ($value === null || $value === false) {
            return null;
        }
        return is_array($value) ? $value : null;
    }

    /**
     * @return string
     */
    public function getTransport(): string
    {
        return $this->getDataString(ServicePlatformSchemaInterface::KEY_TRANSPORT);
    }

    /**
     * @return string|null
     */
    public function getEndpoint(): string|null
    {
        return $this->getDataStringOrNull(ServicePlatformSchemaInterface::KEY_ENDPOINT);
    }

    /**
     * @param string $version
     * @return self
     */
    public function setVersion(string $version): self
    {
        $this->setData(ServicePlatformSchemaInterface::KEY_VERSION, $version);
        return $this;
    }

    /**
     * @param string $spec
     * @return self
     */
    public function setSpec(string $spec): self
    {
        $this->setData(ServicePlatformSchemaInterface::KEY_SPEC, $spec);
        return $this;
    }

    /**
     * @param string|null $schema
     * @return self
     */
    public function setSchema(?string $schema): self
    {
        $this->setData(ServicePlatformSchemaInterface::KEY_SCHEMA, $schema);
        return $this;
    }

    /**
     * @param string|null $id
     * @return self
     */
    public function setId(?string $id): self
    {
        $this->setData(ServicePlatformSchemaInterface::KEY_ID, $id);
        return $this;
    }

    /**
     * @param array<mixed>|null $config
     * @return self
     */
    public function setConfig(?array $config): self
    {
        $this->setData(ServicePlatformSchemaInterface::KEY_CONFIG, $config);
        return $this;
    }

    /**
     * @param string $transport
     * @return self
     */
    public function setTransport(string $transport): self
    {
        $this->setData(ServicePlatformSchemaInterface::KEY_TRANSPORT, $transport);
        return $this;
    }

    /**
     * @param string|null $endpoint
     * @return self
     */
    public function setEndpoint(?string $endpoint): self
    {
        $this->setData(ServicePlatformSchemaInterface::KEY_ENDPOINT, $endpoint);
        return $this;
    }

    /**
     * @return array<mixed>
     */
    public function jsonSerialize(): array
    {
        return $this->toArray();
    }
}
