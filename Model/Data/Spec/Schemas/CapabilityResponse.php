<?php

/**
 * This file is part of the Magebit_UniversalCommerce package.
 *
 * @copyright Copyright (c) 2026 Magebit, Ltd. (https://magebit.com/)
 * @author    Magebit <info@magebit.com>
 * @license   MIT
 */

declare(strict_types=1);

namespace Magebit\UniversalCommerce\Model\Data\Spec\Schemas;

use Magebit\UcpSpec\MutableApi\Schemas\CapabilityResponseInterface;
use Magebit\UniversalCommerce\Model\Data\DataTransferObject;

/**
 * Capability Response Model
 */
class CapabilityResponse extends DataTransferObject implements CapabilityResponseInterface
{
    /**
     * @inheritDoc
     */
    public function getConfig(): ?array
    {
        $config = $this->getData(self::KEY_CONFIG);
        return is_array($config) ? $config : null;
    }

    /**
     * @inheritDoc
     */
    public function setConfig(?array $config): CapabilityResponseInterface
    {
        return $this->setData(self::KEY_CONFIG, $config);
    }

    /**
     * @inheritDoc
     */
    public function getExtends(): ?string
    {
        return $this->getDataStringOrNull(self::KEY_EXTENDS);
    }

    /**
     * @inheritDoc
     */
    public function setExtends(?string $extends): CapabilityResponseInterface
    {
        return $this->setData(self::KEY_EXTENDS, $extends);
    }

    /**
     * @inheritDoc
     */
    public function getName(): string
    {
        return $this->getDataString(self::KEY_NAME);
    }

    /**
     * @inheritDoc
     */
    public function setName(string $name): CapabilityResponseInterface
    {
        return $this->setData(self::KEY_NAME, $name);
    }

    /**
     * @inheritDoc
     */
    public function getSchema(): ?string
    {
        return $this->getDataStringOrNull(self::KEY_SCHEMA);
    }

    /**
     * @inheritDoc
     */
    public function setSchema(?string $schema): CapabilityResponseInterface
    {
        return $this->setData(self::KEY_SCHEMA, $schema);
    }

    /**
     * @inheritDoc
     */
    public function getSpec(): ?string
    {
        return $this->getDataStringOrNull(self::KEY_SPEC);
    }

    /**
     * @inheritDoc
     */
    public function setSpec(?string $spec): CapabilityResponseInterface
    {
        return $this->setData(self::KEY_SPEC, $spec);
    }

    /**
     * @inheritDoc
     */
    public function getVersion(): string
    {
        return $this->getDataString(self::KEY_VERSION);
    }

    /**
     * @inheritDoc
     */
    public function setVersion(string $version): CapabilityResponseInterface
    {
        return $this->setData(self::KEY_VERSION, $version);
    }
}
