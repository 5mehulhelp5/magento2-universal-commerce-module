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
use Magebit\UcpSpec\Api\Services\UCPServiceInterface;
use Magebit\UcpSpec\Api\Services\UCPServiceRestInterface;
use Magebit\UcpSpec\Api\Services\UCPServiceMcpInterface;
use Magebit\UcpSpec\Api\Services\UCPServiceA2aInterface;
use Magebit\UcpSpec\Api\Services\UCPServiceEmbeddedInterface;
use JsonSerializable;

class UcpService extends DataTransferObject implements UCPServiceInterface, JsonSerializable
{
    /**
     * @return string
     */
    public function getVersion(): string
    {
        return $this->getDataString(UCPServiceInterface::KEY_VERSION);
    }

    /**
     * @return string
     */
    public function getSpec(): string
    {
        return $this->getDataString(UCPServiceInterface::KEY_SPEC);
    }

    /**
     * @return UCPServiceRestInterface|null
     */
    public function getRest(): UCPServiceRestInterface|null
    {
        return $this->getDataOfTypeOrNull(UCPServiceInterface::KEY_REST, UCPServiceRestInterface::class);
    }

    /**
     * @return UCPServiceMcpInterface|null
     */
    public function getMcp(): UCPServiceMcpInterface|null
    {
        return null;
    }

    /**
     * @return UCPServiceA2aInterface|null
     */
    public function getA2a(): UCPServiceA2aInterface|null
    {
        return null;
    }

    /**
     * @return UCPServiceEmbeddedInterface|null
     */
    public function getEmbedded(): UCPServiceEmbeddedInterface|null
    {
        return null;
    }

    /**
     * @return array<mixed>
     */
    public function jsonSerialize(): array
    {
        return $this->toArray();
    }
}
