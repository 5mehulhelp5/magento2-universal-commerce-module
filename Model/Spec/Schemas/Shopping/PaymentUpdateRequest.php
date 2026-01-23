<?php

/**
 * @author Magebit <info@magebit.com>
 * @copyright Copyright (c) Magebit, Ltd. (https://magebit.com)
 * @license https://magebit.com/code-license
 */

declare(strict_types=1);

namespace Magebit\UniversalCommerce\Model\Spec\Schemas\Shopping;

use Magebit\UniversalCommerce\Model\DataTransferObject;
use Magebit\UcpSpec\MutableApi\Schemas\Shopping\PaymentUpdateRequestInterface;
use Magebit\UcpSpec\MutableApi\Schemas\Shopping\Types\PaymentInstrumentInterface;

class PaymentUpdateRequest extends DataTransferObject implements PaymentUpdateRequestInterface
{
    /**
     * @return string|null
     */
    public function getSelectedInstrumentId(): string|null
    {
        return $this->getDataStringOrNull(PaymentUpdateRequestInterface::KEY_SELECTED_INSTRUMENT_ID);
    }

    /**
     * @param string|null $selectedInstrumentId
     * @return self
     */
    public function setSelectedInstrumentId(?string $selectedInstrumentId): self
    {
        $this->setData(PaymentUpdateRequestInterface::KEY_SELECTED_INSTRUMENT_ID, $selectedInstrumentId);
        return $this;
    }

    /**
     * @return PaymentInstrumentInterface[]|null
     */
    public function getInstruments(): array|null
    {
        return $this->getDataArrayOfTypeOrNull(
            PaymentUpdateRequestInterface::KEY_INSTRUMENTS,
            PaymentInstrumentInterface::class
        );
    }

    /**
     * @param PaymentInstrumentInterface[]|null $instruments
     * @return self
     */
    public function setInstruments(?array $instruments): self
    {
        $this->setData(PaymentUpdateRequestInterface::KEY_INSTRUMENTS, $instruments);
        return $this;
    }
}
