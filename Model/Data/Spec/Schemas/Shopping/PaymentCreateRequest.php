<?php

/**
 * This file is part of the Magebit_UniversalCommerce package.
 *
 * @copyright Copyright (c) 2026 Magebit, Ltd. (https://magebit.com/)
 * @author    Magebit <info@magebit.com>
 * @license   MIT
 */

declare(strict_types=1);

namespace Magebit\UniversalCommerce\Model\Data\Spec\Schemas\Shopping;

use Magebit\UcpSpec\MutableApi\Schemas\Shopping\PaymentCreateRequestInterface;
use Magebit\UcpSpec\MutableApi\Schemas\Shopping\Types\PaymentInstrumentInterface;
use Magebit\UcpSpec\MutableApi\Schemas\Shopping\Types\PaymentInstrumentInterfaceFactory;
use Magebit\UniversalCommerce\Model\Data\DataTransferObject;

/**
 * Payment Class Model
 */
class PaymentClass extends DataTransferObject implements PaymentCreateRequestInterface
{
    /**
     * @param PaymentInstrumentInterfaceFactory $instrumentFactory
     * @param array<mixed> $data
     */
    public function __construct(
        private readonly PaymentInstrumentInterfaceFactory $instrumentFactory,
        array $data = []
    ) {
        parent::__construct($data);
    }

    /**
     * @inheritDoc
     */
    public function getInstruments(): ?array
    {
        $instruments = $this->getData(self::KEY_INSTRUMENTS);
        if ($instruments === null) {
            return null;
        }

        return $this->getDataInstanceArray(self::KEY_INSTRUMENTS, PaymentInstrumentInterface::class, $this->instrumentFactory->create(...));
    }

    /**
     * @inheritDoc
     */
    public function setInstruments(?array $instruments): PaymentCreateRequestInterface
    {
        return $this->setData(self::KEY_INSTRUMENTS, $instruments);
    }

    /**
     * @inheritDoc
     */
    public function getSelectedInstrumentId(): ?string
    {
        return $this->getDataStringOrNull(self::KEY_SELECTED_INSTRUMENT_ID);
    }

    /**
     * @inheritDoc
     */
    public function setSelectedInstrumentId(?string $selectedInstrumentId): PaymentCreateRequestInterface
    {
        return $this->setData(self::KEY_SELECTED_INSTRUMENT_ID, $selectedInstrumentId);
    }
}
