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

use Magebit\UniversalCommerce\Api\Data\Spec\Response\FulfillmentResponseInterface;
use Magebit\UniversalCommerce\Api\Data\Spec\Response\FulfillmentAvailableMethodResponseInterface;
use Magebit\UniversalCommerce\Api\Data\Spec\Response\FulfillmentAvailableMethodResponseInterfaceFactory;
use Magebit\UniversalCommerce\Api\Data\Spec\Response\FulfillmentMethodResponseInterface;
use Magebit\UniversalCommerce\Api\Data\Spec\Response\FulfillmentMethodResponseInterfaceFactory;
use Magebit\UniversalCommerce\Model\Data\DataTransferObject;

/**
 * Fulfillment Response Model
 */
class FulfillmentResponse extends DataTransferObject implements FulfillmentResponseInterface
{
    /**
     * @param FulfillmentAvailableMethodResponseInterfaceFactory $availableMethodFactory
     * @param FulfillmentMethodResponseInterfaceFactory $methodFactory
     * @param array<mixed> $data
     */
    public function __construct(
        private readonly FulfillmentAvailableMethodResponseInterfaceFactory $availableMethodFactory,
        private readonly FulfillmentMethodResponseInterfaceFactory $methodFactory,
        array $data = []
    ) {
        parent::__construct($data);
    }

    /**
     * @inheritDoc
     */
    public function getAvailableMethods(): ?array
    {
        $methods = $this->getData(self::AVAILABLE_METHODS);
        if ($methods === null) {
            return null;
        }

        return $this->getDataInstanceArray(
            self::AVAILABLE_METHODS,
            FulfillmentAvailableMethodResponseInterface::class,
            $this->availableMethodFactory->create(...)
        );
    }

    /**
     * @inheritDoc
     */
    public function setAvailableMethods(?array $availableMethods): FulfillmentResponseInterface
    {
        return $this->setData(self::AVAILABLE_METHODS, $availableMethods);
    }

    /**
     * @inheritDoc
     */
    public function getMethods(): ?array
    {
        $methods = $this->getData(self::METHODS);
        if ($methods === null) {
            return null;
        }

        return $this->getDataInstanceArray(
            self::METHODS,
            FulfillmentMethodResponseInterface::class,
            $this->methodFactory->create(...)
        );
    }

    /**
     * @inheritDoc
     */
    public function setMethods(?array $methods): FulfillmentResponseInterface
    {
        return $this->setData(self::METHODS, $methods);
    }
}
