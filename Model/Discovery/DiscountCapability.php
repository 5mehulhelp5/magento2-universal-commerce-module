<?php

/**
 * @author Magebit <info@magebit.com>
 * @copyright Copyright (c) Magebit, Ltd. (https://magebit.com)
 * @license https://magebit.com/code-license
 */

declare(strict_types=1);

namespace Magebit\UniversalCommerce\Model\Discovery;

use Magebit\UcpSpec\MutableApi\Schemas\CapabilityDiscoveryInterface;

class DiscountCapability implements CapabilityDiscoveryInterface
{
    public const NAME = 'dev.ucp.shopping.discount';
    public const SPEC = 'https://ucp.dev/specs/discount';
    public const SCHEMA = 'https://ucp.dev/schemas/shopping/discount.create_req.json';

    /**
     * Get name
     *
     * @return string
     */
    public function getName(): string
    {
        return self::NAME;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return self
     */
    public function setName(string $name): self
    {
        return $this;
    }

    /**
     * Get version
     *
     * @return string
     */
    public function getVersion(): string
    {
        return UcpDiscoveryProfile::UCP_VERSION;
    }

    /**
     * Set version
     *
     * @param string $version
     * @return self
     */
    public function setVersion(string $version): self
    {
        return $this;
    }

    /**
     * Get spec
     *
     * @return string
     */
    public function getSpec(): string
    {
        return self::SPEC;
    }

    /**
     * Set spec
     *
     * @param string $spec
     * @return self
     */
    public function setSpec(string $spec): self
    {
        return $this;
    }

    /**
     * Get schema
     *
     * @return string
     */
    public function getSchema(): string
    {
        return self::SCHEMA;
    }

    /**
     * Set schema
     *
     * @param string $schema
     * @return self
     */
    public function setSchema(string $schema): self
    {
        return $this;
    }

    /**
     * Get extends
     *
     * @return string|null
     */
    public function getExtends(): string|null
    {
        return null;
    }

    /**
     * Set extends
     *
     * @param string|null $extends
     * @return self
     */
    public function setExtends(string|null $extends): self
    {
        return $this;
    }

    /**
     * Get config
     *
     * @return array<mixed>|null
     */
    public function getConfig(): array|null
    {
        return null;
    }

    /**
     * Set config
     *
     * @param array<mixed>|null $config
     * @return self
     */
    public function setConfig(array|null $config): self
    {
        return $this;
    }
}
