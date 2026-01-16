<?php

/**
 * This file is part of the Magebit_UniversalCommerce package.
 *
 * @copyright Copyright (c) 2026 Magebit, Ltd. (https://magebit.com/)
 * @author    Magebit <info@magebit.com>
 * @license   MIT
 */

declare(strict_types=1);

namespace Magebit\UniversalCommerce\Model\Data\Spec\Response;

use Magebit\UniversalCommerce\Api\Data\Spec\Response\CapabilityResponseInterface;
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
        $config = $this->getData(self::CONFIG);
        return is_array($config) ? $config : null;
    }

    /**
     * @inheritDoc
     */
    public function setConfig(?array $config): CapabilityResponseInterface
    {
        return $this->setData(self::CONFIG, $config);
    }

    /**
     * @inheritDoc
     */
    public function getExtends(): ?string
    {
        return $this->getDataStringOrNull(self::EXTENDS);
    }

    /**
     * @inheritDoc
     */
    public function setExtends(?string $extends): CapabilityResponseInterface
    {
        return $this->setData(self::EXTENDS, $extends);
    }

    /**
     * @inheritDoc
     */
    public function getName(): string
    {
        return $this->getDataString(self::NAME);
    }

    /**
     * @inheritDoc
     */
    public function setName(string $name): CapabilityResponseInterface
    {
        return $this->setData(self::NAME, $name);
    }

    /**
     * @inheritDoc
     */
    public function getSchema(): ?string
    {
        return $this->getDataStringOrNull(self::SCHEMA);
    }

    /**
     * @inheritDoc
     */
    public function setSchema(?string $schema): CapabilityResponseInterface
    {
        return $this->setData(self::SCHEMA, $schema);
    }

    /**
     * @inheritDoc
     */
    public function getSpec(): ?string
    {
        return $this->getDataStringOrNull(self::SPEC);
    }

    /**
     * @inheritDoc
     */
    public function setSpec(?string $spec): CapabilityResponseInterface
    {
        return $this->setData(self::SPEC, $spec);
    }

    /**
     * @inheritDoc
     */
    public function getVersion(): string
    {
        return $this->getDataString(self::VERSION);
    }

    /**
     * @inheritDoc
     */
    public function setVersion(string $version): CapabilityResponseInterface
    {
        return $this->setData(self::VERSION, $version);
    }
}
