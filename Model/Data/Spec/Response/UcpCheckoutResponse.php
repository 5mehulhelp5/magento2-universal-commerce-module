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

use Magebit\UniversalCommerce\Api\Data\Spec\Response\UcpCheckoutResponseInterface;
use Magebit\UniversalCommerce\Api\Data\Spec\Response\CapabilityResponseInterface;
use Magebit\UniversalCommerce\Api\Data\Spec\Response\CapabilityResponseInterfaceFactory;
use Magebit\UniversalCommerce\Model\Data\DataTransferObject;

/**
 * UCP Checkout Response Model
 */
class UcpCheckoutResponse extends DataTransferObject implements UcpCheckoutResponseInterface
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
            self::CAPABILITIES,
            CapabilityResponseInterface::class,
            $this->capabilityFactory->create(...)
        );
    }

    /**
     * @inheritDoc
     */
    public function setCapabilities(array $capabilities): UcpCheckoutResponseInterface
    {
        return $this->setData(self::CAPABILITIES, $capabilities);
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
    public function setVersion(string $version): UcpCheckoutResponseInterface
    {
        return $this->setData(self::VERSION, $version);
    }
}
