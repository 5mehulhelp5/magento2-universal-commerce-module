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

use Magebit\UniversalCommerce\Api\Data\Spec\Response\PaymentResponseInterface;
use Magebit\UniversalCommerce\Api\Data\Spec\Response\PaymentHandlerResponseInterface;
use Magebit\UniversalCommerce\Api\Data\Spec\Response\PaymentHandlerResponseInterfaceFactory;
use Magebit\UniversalCommerce\Api\Data\Spec\PaymentInstrumentInterface;
use Magebit\UniversalCommerce\Api\Data\Spec\PaymentInstrumentInterfaceFactory;
use Magebit\UniversalCommerce\Model\Data\DataTransferObject;

/**
 * Payment Response Model
 */
class PaymentResponse extends DataTransferObject implements PaymentResponseInterface
{
    /**
     * @param PaymentHandlerResponseInterfaceFactory $handlerFactory
     * @param PaymentInstrumentInterfaceFactory $instrumentFactory
     * @param array<mixed> $data
     */
    public function __construct(
        private readonly PaymentHandlerResponseInterfaceFactory $handlerFactory,
        private readonly PaymentInstrumentInterfaceFactory $instrumentFactory,
        array $data = []
    ) {
        parent::__construct($data);
    }

    /**
     * @inheritDoc
     */
    public function getHandlers(): array
    {
        return $this->getDataInstanceArray(
            self::HANDLERS,
            PaymentHandlerResponseInterface::class,
            $this->handlerFactory->create(...)
        );
    }

    /**
     * @inheritDoc
     */
    public function setHandlers(array $handlers): PaymentResponseInterface
    {
        return $this->setData(self::HANDLERS, $handlers);
    }

    /**
     * @inheritDoc
     */
    public function getInstruments(): ?array
    {
        $instruments = $this->getData(self::INSTRUMENTS);
        if ($instruments === null) {
            return null;
        }

        return $this->getDataInstanceArray(
            self::INSTRUMENTS,
            PaymentInstrumentInterface::class,
            $this->instrumentFactory->create(...)
        );
    }

    /**
     * @inheritDoc
     */
    public function setInstruments(?array $instruments): PaymentResponseInterface
    {
        return $this->setData(self::INSTRUMENTS, $instruments);
    }

    /**
     * @inheritDoc
     */
    public function getSelectedInstrumentId(): ?string
    {
        return $this->getDataStringOrNull(self::SELECTED_INSTRUMENT_ID);
    }

    /**
     * @inheritDoc
     */
    public function setSelectedInstrumentId(?string $selectedInstrumentId): PaymentResponseInterface
    {
        return $this->setData(self::SELECTED_INSTRUMENT_ID, $selectedInstrumentId);
    }
}
