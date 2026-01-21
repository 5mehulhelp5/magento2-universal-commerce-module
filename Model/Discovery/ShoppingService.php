<?php

/**
 * This file is part of the Magebit_UniversalCommerce package.
 *
 * @copyright Copyright (c) 2026 Magebit, Ltd. (https://magebit.com/)
 * @author    Magebit <info@magebit.com>
 * @license   MIT
 */

declare(strict_types=1);

namespace Magebit\UniversalCommerce\Model\Discovery;

use Magebit\UcpSpec\MutableApi\Services\UCPServiceInterface;
use Magebit\UcpSpec\MutableApi\Services\UCPServiceRestInterface;
use Magebit\UcpSpec\MutableApi\Services\UCPServiceMcpInterface;
use Magebit\UcpSpec\MutableApi\Services\UCPServiceA2aInterface;
use Magebit\UcpSpec\MutableApi\Services\UCPServiceEmbeddedInterface;
use Magebit\UcpSpec\MutableApi\Services\UCPServiceRestInterfaceFactory;

class ShoppingService implements UCPServiceInterface
{
    public const SPEC = 'https://ucp.dev/specs/shopping';
    public const SCHEMA = 'https://ucp.dev/services/shopping/openapi.json';

    /**
     * @param UCPServiceRestInterfaceFactory $restFactory
     */
    public function __construct(
        private readonly UCPServiceRestInterfaceFactory $restFactory,
    ) {
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
     * Get rest
     *
     * @return UCPServiceRestInterface|null
     */
    public function getRest(): UCPServiceRestInterface|null
    {
        return $this->restFactory->create()
            ->setSchema(self::SCHEMA)
            ->setEndpoint('/rest/V1/shopping');
    }

    /**
     * Set rest
     *
     * @param UCPServiceRestInterface|null $rest
     * @return self
     */
    public function setRest(?UCPServiceRestInterface $rest): self
    {
        return $this;
    }

    /**
     * Set mcp
     *
     * @param UCPServiceMcpInterface|null $mcp
     * @return self
     */
    public function setMcp(?UCPServiceMcpInterface $mcp): self
    {
        return $this;
    }

    /**
     * Get mcp
     *
     * @return UCPServiceMcpInterface|null
     */
    public function getMcp(): UCPServiceMcpInterface|null
    {
        return null;
    }

    /**
     * Set a2a
     *
     * @param UCPServiceA2aInterface|null $a2a
     * @return self
     */
    public function setA2a(?UCPServiceA2aInterface $a2a): self
    {
        return $this;
    }

    /**
     * Get a2a
     *
     * @return UCPServiceA2aInterface|null
     */
    public function getA2a(): UCPServiceA2aInterface|null
    {
        return null;
    }

    /**
     * Set embedded
     *
     * @param UCPServiceEmbeddedInterface|null $embedded
     * @return self
     */
    public function setEmbedded(?UCPServiceEmbeddedInterface $embedded): self
    {
        return $this;
    }

    /**
     * Get embedded
     *
     * @return UCPServiceEmbeddedInterface|null
     */
    public function getEmbedded(): UCPServiceEmbeddedInterface|null
    {
        return null;
    }
}
