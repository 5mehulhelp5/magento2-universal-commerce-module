<?php

/**
 * This file is part of the Magebit_UniversalCommerce package.
 *
 * @copyright Copyright (c) 2026 Magebit, Ltd. (https://magebit.com/)
 * @author    Magebit <info@magebit.com>
 * @license   MIT
 */

declare(strict_types=1);

namespace Magebit\UniversalCommerce\Model\Data\Spec\Schemas;

use Magebit\UcpSpec\MutableApi\Schemas\UcpResponseCheckoutInterface;
use Magebit\UcpSpec\MutableApi\Schemas\CapabilityResponseInterface;
use Magebit\UcpSpec\MutableApi\Schemas\CapabilityResponseInterfaceFactory;
use Magebit\UniversalCommerce\Model\Data\DataTransferObject;

/**
 * UCP Checkout Response Model
 */
class UcpCheckoutResponse extends DataTransferObject implements UcpResponseCheckoutInterface
{
    /**
     * @param CapabilityResponseInterfaceFactory $capabilityFactory
     * @param array<mixed> $data
     */
    public function __construct(
        private readonly CapabilityResponseInterfaceFactory $capabilityFactory,
        array $data = []
    ) {
        parent::__construct($data);
    }

    /**
     * @inheritDoc
     */
    public function getCapabilities(): array
    {
        return $this->getDataInstanceArray(
            self::KEY_CAPABILITIES,
            CapabilityResponseInterface::class,
            $this->capabilityFactory->create(...)
        );
    }

    /**
     * @inheritDoc
     */
    public function setCapabilities(array $capabilities): UcpResponseCheckoutInterface
    {
        return $this->setData(self::KEY_CAPABILITIES, $capabilities);
    }

    /**
     * @inheritDoc
     */
    public function getVersion(): string
    {
        return $this->getDataString(self::KEY_VERSION);
    }

    /**
     * @inheritDoc
     */
    public function setVersion(string $version): UcpResponseCheckoutInterface
    {
        return $this->setData(self::KEY_VERSION, $version);
    }
}
