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

use Magebit\UcpSpec\MutableApi\Schemas\Shopping\CheckoutCompleteRequestInterface;
use Magebit\UcpSpec\MutableApi\Schemas\Shopping\PaymentInterface;
use Magebit\UniversalCommerce\Model\DataTransferObject;

class CheckoutCompleteRequest extends DataTransferObject implements CheckoutCompleteRequestInterface
{
    /**
     * @return PaymentInterface
     * @throws \InvalidArgumentException
     */
    public function getPayment(): PaymentInterface
    {
        return $this->getDataOfType(CheckoutCompleteRequestInterface::KEY_PAYMENT, PaymentInterface::class);
    }

    /**
     * @param PaymentInterface $payment
     * @return self
     */
    public function setPayment(PaymentInterface $payment): self
    {
        $this->setData(CheckoutCompleteRequestInterface::KEY_PAYMENT, $payment);
        return $this;
    }
}
