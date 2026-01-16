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
 * Capability Response Interface
 * Represents a capability in the UCP checkout response
 */
interface CapabilityResponseInterface
{
    public const CONFIG = 'config';
    public const EXTENDS = 'extends';
    public const NAME = 'name';
    public const SCHEMA = 'schema';
    public const SPEC = 'spec';
    public const VERSION = 'version';

    /**
     * Get config
     *
     * @return array<string, mixed>|null
     */
    public function getConfig(): ?array;

    /**
     * Set config
     *
     * @param array<string, mixed>|null $config
     * @return $this
     */
    public function setConfig(?array $config): self;

    /**
     * Get extends
     *
     * @return string|null
     */
    public function getExtends(): ?string;

    /**
     * Set extends
     *
     * @param string|null $extends
     * @return $this
     */
    public function setExtends(?string $extends): self;

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
     * Get schema
     *
     * @return string|null
     */
    public function getSchema(): ?string;

    /**
     * Set schema
     *
     * @param string|null $schema
     * @return $this
     */
    public function setSchema(?string $schema): self;

    /**
     * Get spec
     *
     * @return string|null
     */
    public function getSpec(): ?string;

    /**
     * Set spec
     *
     * @param string|null $spec
     * @return $this
     */
    public function setSpec(?string $spec): self;

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
