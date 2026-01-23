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
use Magebit\UcpSpec\MutableApi\Schemas\Shopping\Types\PaymentHandlerResponseInterface;

class PaymentHandlerResponse extends DataTransferObject implements PaymentHandlerResponseInterface
{
    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->getDataString(PaymentHandlerResponseInterface::KEY_ID);
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->getDataString(PaymentHandlerResponseInterface::KEY_NAME);
    }

    /**
     * @return string
     */
    public function getVersion(): string
    {
        return $this->getDataString(PaymentHandlerResponseInterface::KEY_VERSION);
    }

    /**
     * @return string
     */
    public function getSpec(): string
    {
        return $this->getDataString(PaymentHandlerResponseInterface::KEY_SPEC);
    }

    /**
     * @return string
     */
    public function getConfigSchema(): string
    {
        return $this->getDataString(PaymentHandlerResponseInterface::KEY_CONFIG_SCHEMA);
    }

    /**
     * @return string[]
     */
    public function getInstrumentSchemas(): array
    {
        $value = $this->getDataArray(PaymentHandlerResponseInterface::KEY_INSTRUMENT_SCHEMAS);
        foreach ($value as $item) {
            if (!is_string($item)) {
                throw new \InvalidArgumentException(
                    sprintf('Item in %s is not a string', PaymentHandlerResponseInterface::KEY_INSTRUMENT_SCHEMAS)
                );
            }
        }
        return $value;
    }

    /**
     * @return array<mixed>
     */
    public function getConfig(): array
    {
        return $this->getDataArray(PaymentHandlerResponseInterface::KEY_CONFIG);
    }

    /**
     * @param string $id
     * @return self
     */
    public function setId(string $id): self
    {
        $this->setData(PaymentHandlerResponseInterface::KEY_ID, $id);
        return $this;
    }

    /**
     * @param string $name
     * @return self
     */
    public function setName(string $name): self
    {
        $this->setData(PaymentHandlerResponseInterface::KEY_NAME, $name);
        return $this;
    }

    /**
     * @param string $version
     * @return self
     */
    public function setVersion(string $version): self
    {
        $this->setData(PaymentHandlerResponseInterface::KEY_VERSION, $version);
        return $this;
    }

    /**
     * @param string $spec
     * @return self
     */
    public function setSpec(string $spec): self
    {
        $this->setData(PaymentHandlerResponseInterface::KEY_SPEC, $spec);
        return $this;
    }

    /**
     * @param string $configSchema
     * @return self
     */
    public function setConfigSchema(string $configSchema): self
    {
        $this->setData(PaymentHandlerResponseInterface::KEY_CONFIG_SCHEMA, $configSchema);
        return $this;
    }

    /**
     * @param string[] $instrumentSchemas
     * @return self
     */
    public function setInstrumentSchemas(array $instrumentSchemas): self
    {
        $this->setData(PaymentHandlerResponseInterface::KEY_INSTRUMENT_SCHEMAS, $instrumentSchemas);
        return $this;
    }

    /**
     * @param array<mixed> $config
     * @return self
     */
    public function setConfig(array $config): self
    {
        $this->setData(PaymentHandlerResponseInterface::KEY_CONFIG, $config);
        return $this;
    }
}
