<?php

/**
 * This file is part of the Magebit_UniversalCommerce package.
 *
 * @copyright Copyright (c) 2026 Magebit, Ltd. (https://magebit.com/)
 * @author    Magebit <info@magebit.com>
 * @license   MIT
 */

declare(strict_types=1);

namespace Magebit\UniversalCommerce\Model\Spec\Schemas;

use Magebit\UniversalCommerce\Model\DataTransferObject;
use Magebit\UcpSpec\MutableApi\Schemas\UcpResponseCheckoutInterface;
use Magebit\UcpSpec\MutableApi\Schemas\CapabilityResponseInterface;

class UcpResponseCheckout extends DataTransferObject implements UcpResponseCheckoutInterface
{
    /**
     * @return string
     */
    public function getVersion(): string
    {
        return $this->getDataString(UcpResponseCheckoutInterface::KEY_VERSION);
    }

    /**
     * @return CapabilityResponseInterface[]
     */
    public function getCapabilities(): array
    {
        return $this->getDataArrayOfType(
            UcpResponseCheckoutInterface::KEY_CAPABILITIES,
            CapabilityResponseInterface::class
        );
    }

    /**
     * @param string $version
     * @return self
     */
    public function setVersion(string $version): self
    {
        $this->setData(UcpResponseCheckoutInterface::KEY_VERSION, $version);
        return $this;
    }

    /**
     * @param CapabilityResponseInterface[] $capabilities
     * @return self
     */
    public function setCapabilities(array $capabilities): self
    {
        $this->setData(UcpResponseCheckoutInterface::KEY_CAPABILITIES, $capabilities);
        return $this;
    }
}
