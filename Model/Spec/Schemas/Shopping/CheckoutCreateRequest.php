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
use Magebit\UcpSpec\MutableApi\Schemas\Shopping\CheckoutCreateRequestInterface;
use Magebit\UcpSpec\MutableApi\Schemas\Shopping\PaymentCreateRequestInterface;
use Magebit\UcpSpec\MutableApi\Schemas\Shopping\Types\LineItemCreateRequestInterface;
use Magebit\UcpSpec\MutableApi\Schemas\Shopping\Types\BuyerInterface;

class CheckoutCreateRequest extends DataTransferObject implements CheckoutCreateRequestInterface
{
    /**
     * @return LineItemCreateRequestInterface[]
     */
    public function getLineItems(): array
    {
        return $this->getDataArrayOfType(
            CheckoutCreateRequestInterface::KEY_LINE_ITEMS,
            LineItemCreateRequestInterface::class
        );
    }

    /**
     * @param LineItemCreateRequestInterface[] $lineItems
     * @return self
     */
    public function setLineItems(array $lineItems): self
    {
        $this->setData(CheckoutCreateRequestInterface::KEY_LINE_ITEMS, $lineItems);
        return $this;
    }

    /**
     * @return BuyerInterface|null
     */
    public function getBuyer(): BuyerInterface|null
    {
        return $this->getDataOfTypeOrNull(CheckoutCreateRequestInterface::KEY_BUYER, BuyerInterface::class);
    }

    /**
     * @param BuyerInterface|null $buyer
     * @return self
     */
    public function setBuyer(?BuyerInterface $buyer): self
    {
        $this->setData(CheckoutCreateRequestInterface::KEY_BUYER, $buyer);
        return $this;
    }

    /**
     * @return string
     */
    public function getCurrency(): string
    {
        return $this->getDataString(CheckoutCreateRequestInterface::KEY_CURRENCY);
    }

    /**
     * @param string $currency
     * @return self
     */
    public function setCurrency(string $currency): self
    {
        $this->setData(CheckoutCreateRequestInterface::KEY_CURRENCY, $currency);
        return $this;
    }

    /**
     * @return PaymentCreateRequestInterface
     */
    public function getPayment(): PaymentCreateRequestInterface
    {
        return $this->getDataOfType(CheckoutCreateRequestInterface::KEY_PAYMENT, PaymentCreateRequestInterface::class);
    }

    /**
     * @param PaymentCreateRequestInterface $payment
     * @return self
     */
    public function setPayment(PaymentCreateRequestInterface $payment): self
    {
        $this->setData(CheckoutCreateRequestInterface::KEY_PAYMENT, $payment);
        return $this;
    }
}
