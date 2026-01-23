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
use Magebit\UcpSpec\Api\Schemas\Shopping\PaymentResponseInterface;
use Magebit\UcpSpec\Api\Schemas\Shopping\Types\PaymentHandlerResponseInterface;
use Magebit\UcpSpec\Api\Schemas\Shopping\Types\PaymentInstrumentInterface;

class PaymentResponse extends DataTransferObject implements PaymentResponseInterface
{
    /**
     * @return array<PaymentHandlerResponseInterface>
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
     * @return array<PaymentInstrumentInterface>|null
     */
    public function getInstruments(): array|null
    {
        return $this->getDataArrayOfTypeOrNull(
            PaymentResponseInterface::KEY_INSTRUMENTS,
            PaymentInstrumentInterface::class
        );
    }
}
