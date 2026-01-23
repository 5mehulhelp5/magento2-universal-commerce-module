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
use Magebit\UcpSpec\Api\Schemas\Shopping\CheckoutCreateRequestInterface;
use Magebit\UcpSpec\Api\Schemas\Shopping\Types\LineItemCreateRequestInterface;
use Magebit\UcpSpec\Api\Schemas\Shopping\Types\BuyerInterface;

class CheckoutCreateRequest extends DataTransferObject implements CheckoutCreateRequestInterface
{
    /**
     * @return array<LineItemCreateRequestInterface>
     */
    public function getLineItems(): array
    {
        return $this->getDataArrayOfType(
            CheckoutCreateRequestInterface::KEY_LINE_ITEMS,
            LineItemCreateRequestInterface::class
        );
    }

    /**
     * @return BuyerInterface|null
     */
    public function getBuyer(): BuyerInterface|null
    {
        return $this->getDataOfTypeOrNull(CheckoutCreateRequestInterface::KEY_BUYER, BuyerInterface::class);
    }

    /**
     * @return string
     */
    public function getCurrency(): string
    {
        return $this->getDataString(CheckoutCreateRequestInterface::KEY_CURRENCY);
    }

    /**
     * @return PaymentCreateRequestInterface
     */
    public function getPayment(): PaymentCreateRequestInterface
    {
        return $this->getDataOfType(CheckoutCreateRequestInterface::KEY_PAYMENT, PaymentCreateRequestInterface::class);
    }
}
