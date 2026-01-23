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
use Magebit\UcpSpec\Api\Schemas\Shopping\PaymentCreateRequestInterface;
use Magebit\UcpSpec\Api\Schemas\Shopping\Types\PaymentInstrumentInterface;

class PaymentCreateRequest extends DataTransferObject implements PaymentCreateRequestInterface
{
    /**
     * @return string|null
     */
    public function getSelectedInstrumentId(): string|null
    {
        return $this->getDataStringOrNull(PaymentCreateRequestInterface::KEY_SELECTED_INSTRUMENT_ID);
    }

    /**
     * @return array<PaymentInstrumentInterface>|null
     */
    public function getInstruments(): array|null
    {
        return $this->getDataArrayOfTypeOrNull(
            PaymentCreateRequestInterface::KEY_INSTRUMENTS,
            PaymentInstrumentInterface::class
        );
    }
}
