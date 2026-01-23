<?php

/**
 * @author Magebit <info@magebit.com>
 * @copyright Copyright (c) Magebit, Ltd. (https://magebit.com)
 * @license https://magebit.com/code-license
 */

declare(strict_types=1);

namespace Magebit\UniversalCommerce\Model\Spec\Schemas\Shopping;

use Magebit\UniversalCommerce\Model\DataTransferObject;
use Magebit\UcpSpec\MutableApi\Schemas\Shopping\PaymentDataInterface;
use Magebit\UcpSpec\MutableApi\Schemas\Shopping\Types\PaymentInstrumentInterface;

class PaymentData extends DataTransferObject implements PaymentDataInterface
{
    /**
     * @return PaymentInstrumentInterface
     */
    public function getPaymentData(): PaymentInstrumentInterface
    {
        return $this->getDataOfType(PaymentDataInterface::KEY_PAYMENT_DATA, PaymentInstrumentInterface::class);
    }

    /**
     * @param PaymentInstrumentInterface $paymentData
     * @return self
     */
    public function setPaymentData(PaymentInstrumentInterface $paymentData): self
    {
        $this->setData(PaymentDataInterface::KEY_PAYMENT_DATA, $paymentData);
        return $this;
    }
}
