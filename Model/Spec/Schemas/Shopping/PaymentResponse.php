<?php

/**
 * This file is part of the Magebit_UniversalCommerce package.
 *
 * @copyright Copyright (c) 2026 Magebit, Ltd. (https://magebit.com/)
 * @author    Magebit <info@magebit.com>
 * @license   MIT
 */

declare(strict_types=1);

namespace Magebit\UniversalCommerce\Model\Spec\Schemas\Shopping;

use Magebit\UniversalCommerce\Model\DataTransferObject;
use Magebit\UcpSpec\MutableApi\Schemas\Shopping\PaymentResponseInterface;
use Magebit\UcpSpec\MutableApi\Schemas\Shopping\Types\PaymentHandlerResponseInterface;
use Magebit\UcpSpec\MutableApi\Schemas\Shopping\Types\PaymentInstrumentInterface;

class PaymentResponse extends DataTransferObject implements PaymentResponseInterface
{
    /**
     * @return PaymentHandlerResponseInterface[]
     */
    public function getHandlers(): array
    {
        return $this->getDataArrayOfType(
            PaymentResponseInterface::KEY_HANDLERS,
            PaymentHandlerResponseInterface::class
        );
    }

    /**
     * @return string|null
     */
    public function getSelectedInstrumentId(): string|null
    {
        return $this->getDataStringOrNull(PaymentResponseInterface::KEY_SELECTED_INSTRUMENT_ID);
    }

    /**
     * @return PaymentInstrumentInterface[]|null
     */
    public function getInstruments(): array|null
    {
        return $this->getDataArrayOfTypeOrNull(
            PaymentResponseInterface::KEY_INSTRUMENTS,
            PaymentInstrumentInterface::class
        );
    }

    /**
     * @param PaymentHandlerResponseInterface[] $handlers
     * @return self
     */
    public function setHandlers(array $handlers): self
    {
        $this->setData(PaymentResponseInterface::KEY_HANDLERS, $handlers);
        return $this;
    }

    /**
     * @param string|null $selectedInstrumentId
     * @return self
     */
    public function setSelectedInstrumentId(?string $selectedInstrumentId): self
    {
        $this->setData(PaymentResponseInterface::KEY_SELECTED_INSTRUMENT_ID, $selectedInstrumentId);
        return $this;
    }

    /**
     * @param PaymentInstrumentInterface[]|null $instruments
     * @return self
     */
    public function setInstruments(?array $instruments): self
    {
        $this->setData(PaymentResponseInterface::KEY_INSTRUMENTS, $instruments);
        return $this;
    }
}
