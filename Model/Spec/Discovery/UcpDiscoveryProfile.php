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
use Magebit\UcpSpec\Api\Discovery\UCPDiscoveryProfileInterface;
use Magebit\UcpSpec\Api\Schemas\UcpDiscoveryProfileInterface as UcpDiscoveryProfileInterface1;
use Magebit\UcpSpec\Api\Discovery\UCPDiscoveryProfilePaymentInterface;
use Magebit\UcpSpec\Api\Discovery\UCPDiscoveryProfileSigningKeysItemInterface;

class UcpDiscoveryProfile extends DataTransferObject implements UCPDiscoveryProfileInterface
{
    /**
     * @return UcpDiscoveryProfileInterface1
     */
    public function getUcp(): UcpDiscoveryProfileInterface1
    {
        return $this->getDataOfType(UCPDiscoveryProfileInterface::KEY_UCP, UcpDiscoveryProfileInterface1::class);
    }

    /**
     * @return UCPDiscoveryProfilePaymentInterface|null
     */
    public function getPayment(): UCPDiscoveryProfilePaymentInterface|null
    {
        return $this->getDataOfTypeOrNull(
            UCPDiscoveryProfileInterface::KEY_PAYMENT,
            UCPDiscoveryProfilePaymentInterface::class
        );
    }

    /**
     * @return array<UCPDiscoveryProfileSigningKeysItemInterface>|null
     */
    public function getSigningKeys(): array|null
    {
        return $this->getDataArrayOfTypeOrNull(UCPDiscoveryProfileInterface::KEY_SIGNING_KEYS, UCPDiscoveryProfileSigningKeysItemInterface::class);
    }
}
