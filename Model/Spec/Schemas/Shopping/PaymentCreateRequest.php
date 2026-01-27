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
use Magebit\UcpSpec\MutableApi\Schemas\Shopping\PaymentInterface;
use Magebit\UcpSpec\MutableApi\Schemas\Shopping\Types\SelectedPaymentInstrumentInterface;

class PaymentCreateRequest extends DataTransferObject implements PaymentInterface
{
    /**
     * @return SelectedPaymentInstrumentInterface[]|null
     */
    public function getInstruments(): array|null
    {
        return $this->getDataArrayOfTypeOrNull(
            PaymentInterface::KEY_INSTRUMENTS,
            SelectedPaymentInstrumentInterface::class
        );
    }

    /**
     * @param SelectedPaymentInstrumentInterface[]|null $instruments
     * @return self
     */
    public function setInstruments(?array $instruments): self
    {
        $this->setData(PaymentInterface::KEY_INSTRUMENTS, $instruments);
        return $this;
    }
}
