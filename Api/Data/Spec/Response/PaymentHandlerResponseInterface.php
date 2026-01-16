<?php

/**
 * This file is part of the Magebit_UniversalCommerce package.
 *
 * @copyright Copyright (c) 2026 Magebit, Ltd. (https://magebit.com/)
 * @author    Magebit <info@magebit.com>
 * @license   MIT
 */

declare(strict_types=1);

namespace Magebit\UniversalCommerce\Api\Data\Spec\Response;

/**
 * Payment Handler Response Interface
 * Represents a payment handler in the checkout response
 */
interface PaymentHandlerResponseInterface
{
    public const CONFIG = 'config';
    public const CONFIG_SCHEMA = 'config_schema';
    public const ID = 'id';
    public const INSTRUMENT_SCHEMAS = 'instrument_schemas';
    public const NAME = 'name';
    public const SPEC = 'spec';
    public const VERSION = 'version';

    /**
     * Get config
     *
     * @return array<string, mixed>
     */
    public function getConfig(): array;

    /**
     * Set config
     *
     * @param array<string, mixed> $config
     * @return $this
     */
    public function setConfig(array $config): self;

    /**
     * Get config schema
     *
     * @return string
     */
    public function getConfigSchema(): string;

    /**
     * Set config schema
     *
     * @param string $configSchema
     * @return $this
     */
    public function setConfigSchema(string $configSchema): self;

    /**
     * Get ID
     *
     * @return string
     */
    public function getId(): string;

    /**
     * Set ID
     *
     * @param string $id
     * @return $this
     */
    public function setId(string $id): self;

    /**
     * Get instrument schemas
     *
     * @return string[]
     */
    public function getInstrumentSchemas(): array;

    /**
     * Set instrument schemas
     *
     * @param string[] $instrumentSchemas
     * @return $this
     */
    public function setInstrumentSchemas(array $instrumentSchemas): self;

    /**
     * Get name
     *
     * @return string
     */
    public function getName(): string;

    /**
     * Set name
     *
     * @param string $name
     * @return $this
     */
    public function setName(string $name): self;

    /**
     * Get spec
     *
     * @return string
     */
    public function getSpec(): string;

    /**
     * Set spec
     *
     * @param string $spec
     * @return $this
     */
    public function setSpec(string $spec): self;

    /**
     * Get version
     *
     * @return string
     */
    public function getVersion(): string;

    /**
     * Set version
     *
     * @param string $version
     * @return $this
     */
    public function setVersion(string $version): self;
}
