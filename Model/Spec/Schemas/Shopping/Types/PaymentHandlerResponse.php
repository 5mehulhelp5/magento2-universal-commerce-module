<?php

/**
 * This file is part of the Magebit_UniversalCommerce package.
 *
 * @copyright Copyright (c) 2026 Magebit, Ltd. (https://magebit.com/)
 * @author    Magebit <info@magebit.com>
 * @license   MIT
 */

declare(strict_types=1);

namespace Magebit\UniversalCommerce\Model\Spec\Schemas\Shopping\Types;

use Magebit\UniversalCommerce\Model\DataTransferObject;
use Magebit\UcpSpec\MutableApi\Schemas\PaymentHandlerResponseSchemaInterface;

class PaymentHandlerResponse extends DataTransferObject implements PaymentHandlerResponseSchemaInterface
{
    /**
     * @return string
     */
    public function getVersion(): string
    {
        return $this->getDataString(PaymentHandlerResponseSchemaInterface::KEY_VERSION);
    }

    /**
     * @return string|null
     */
    public function getSpec(): string|null
    {
        return $this->getDataStringOrNull(PaymentHandlerResponseSchemaInterface::KEY_SPEC);
    }

    /**
     * @return string|null
     */
    public function getSchema(): string|null
    {
        return $this->getDataStringOrNull(PaymentHandlerResponseSchemaInterface::KEY_SCHEMA);
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->getDataString(PaymentHandlerResponseSchemaInterface::KEY_ID);
    }

    /**
     * @return array<mixed>|null
     */
    public function getConfig(): array|null
    {
        $value = $this->getData(PaymentHandlerResponseSchemaInterface::KEY_CONFIG);
        if ($value === null || $value === false) {
            return null;
        }
        return is_array($value) ? $value : null;
    }

    /**
     * @param string $version
     * @return self
     */
    public function setVersion(string $version): self
    {
        $this->setData(PaymentHandlerResponseSchemaInterface::KEY_VERSION, $version);
        return $this;
    }

    /**
     * @param string|null $spec
     * @return self
     */
    public function setSpec(?string $spec): self
    {
        $this->setData(PaymentHandlerResponseSchemaInterface::KEY_SPEC, $spec);
        return $this;
    }

    /**
     * @param string|null $schema
     * @return self
     */
    public function setSchema(?string $schema): self
    {
        $this->setData(PaymentHandlerResponseSchemaInterface::KEY_SCHEMA, $schema);
        return $this;
    }

    /**
     * @param string $id
     * @return self
     */
    public function setId(string $id): self
    {
        $this->setData(PaymentHandlerResponseSchemaInterface::KEY_ID, $id);
        return $this;
    }

    /**
     * @param array<mixed>|null $config
     * @return self
     */
    public function setConfig(?array $config): self
    {
        $this->setData(PaymentHandlerResponseSchemaInterface::KEY_CONFIG, $config);
        return $this;
    }
}
