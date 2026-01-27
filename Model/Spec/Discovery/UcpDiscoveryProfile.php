<?php

/**
 * This file is part of the Magebit_UniversalCommerce package.
 *
 * @copyright Copyright (c) 2026 Magebit, Ltd. (https://magebit.com/)
 * @author    Magebit <info@magebit.com>
 * @license   MIT
 */

declare(strict_types=1);

namespace Magebit\UniversalCommerce\Model\Spec\Discovery;

use Magebit\UniversalCommerce\Model\DataTransferObject;
use Magebit\UcpSpec\MutableApi\Discovery\UCPDiscoveryProfileInterface;
use Magebit\UcpSpec\MutableApi\Schemas\UcpPlatformSchemaInterface;
use Magebit\UcpSpec\MutableApi\Discovery\SigningKeyInterface;

class UcpDiscoveryProfile extends DataTransferObject implements UCPDiscoveryProfileInterface
{
    /**
     * @return UcpPlatformSchemaInterface
     */
    public function getUcp(): UcpPlatformSchemaInterface
    {
        return $this->getDataOfType(UCPDiscoveryProfileInterface::KEY_UCP, UcpPlatformSchemaInterface::class);
    }

    /**
     * @return array<SigningKeyInterface>|null
     */
    public function getSigningKeys(): array|null
    {
        return $this->getDataArrayOfTypeOrNull(UCPDiscoveryProfileInterface::KEY_SIGNING_KEYS, SigningKeyInterface::class);
    }

    /**
     * @param UcpPlatformSchemaInterface $ucp
     * @return self
     */
    public function setUcp(UcpPlatformSchemaInterface $ucp): self
    {
        $this->setData(UCPDiscoveryProfileInterface::KEY_UCP, $ucp);
        return $this;
    }

    /**
     * @param array<SigningKeyInterface>|null $signingKeys
     * @return self
     */
    public function setSigningKeys(?array $signingKeys): self
    {
        $this->setData(UCPDiscoveryProfileInterface::KEY_SIGNING_KEYS, $signingKeys);
        return $this;
    }
}
