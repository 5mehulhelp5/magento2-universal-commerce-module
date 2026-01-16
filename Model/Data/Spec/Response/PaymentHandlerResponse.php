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

use Magebit\UniversalCommerce\Api\Data\Spec\Response\PaymentHandlerResponseInterface;
use Magebit\UniversalCommerce\Model\Data\DataTransferObject;

/**
 * Payment Handler Response Model
 */
class PaymentHandlerResponse extends DataTransferObject implements PaymentHandlerResponseInterface
{
    /**
     * @inheritDoc
     */
    public function getConfig(): array
    {
        return $this->getData(self::CONFIG) ?? [];
    }

    /**
     * @inheritDoc
     */
    public function setConfig(array $config): PaymentHandlerResponseInterface
    {
        return $this->setData(self::CONFIG, $config);
    }

    /**
     * @inheritDoc
     */
    public function getConfigSchema(): string
    {
        return $this->getDataString(self::CONFIG_SCHEMA);
    }

    /**
     * @inheritDoc
     */
    public function setConfigSchema(string $configSchema): PaymentHandlerResponseInterface
    {
        return $this->setData(self::CONFIG_SCHEMA, $configSchema);
    }

    /**
     * @inheritDoc
     */
    public function getId(): string
    {
        return $this->getDataString(self::ID);
    }

    /**
     * @inheritDoc
     */
    public function setId(string $id): PaymentHandlerResponseInterface
    {
        return $this->setData(self::ID, $id);
    }

    /**
     * @inheritDoc
     */
    public function getInstrumentSchemas(): array
    {
        return $this->getData(self::INSTRUMENT_SCHEMAS) ?? [];
    }

    /**
     * @inheritDoc
     */
    public function setInstrumentSchemas(array $instrumentSchemas): PaymentHandlerResponseInterface
    {
        return $this->setData(self::INSTRUMENT_SCHEMAS, $instrumentSchemas);
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
    public function setName(string $name): PaymentHandlerResponseInterface
    {
        return $this->setData(self::NAME, $name);
    }

    /**
     * @inheritDoc
     */
    public function getSpec(): string
    {
        return $this->getDataString(self::SPEC);
    }

    /**
     * @inheritDoc
     */
    public function setSpec(string $spec): PaymentHandlerResponseInterface
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
    public function setVersion(string $version): PaymentHandlerResponseInterface
    {
        return $this->setData(self::VERSION, $version);
    }
}
