<?php

/**
 * This file is part of the Magebit_UniversalCommerce package.
 *
 * @copyright Copyright (c) 2026 Magebit, Ltd. (https://magebit.com/)
 * @author    Magebit <info@magebit.com>
 * @license   MIT
 */
declare(strict_types=1);

namespace Magebit\UniversalCommerce\Api\Service\Shopping;

use Magebit\UniversalCommerce\Api\Service\Shopping\CheckoutCreateRequestInterface;
use Magebit\UcpSpec\MutableApi\Schemas\Shopping\FulfillmentCheckoutInterface;
use Magebit\UcpSpec\MutableApi\Schemas\Shopping\PaymentDataInterface;

interface RestHandlerInterface
{
    /**
     * @param CheckoutCreateRequestInterface $request
     * @return FulfillmentCheckoutInterface
     */
    public function createCheckout(CheckoutCreateRequestInterface $request): FulfillmentCheckoutInterface;

    /**
     * @param string $checkoutId
     * @return FulfillmentCheckoutInterface
     */
    public function getCheckout(string $checkoutId): FulfillmentCheckoutInterface;

    /**
     * @param string $checkoutId
     * @return FulfillmentCheckoutInterface
     */
    public function cancelCheckout(string $checkoutId): FulfillmentCheckoutInterface;

    /**
     * @param string $checkoutId
     * @param CheckoutUpdateRequestInterface $request
     * @return FulfillmentCheckoutInterface
     */
    public function updateCheckout(string $checkoutId, CheckoutUpdateRequestInterface $request): FulfillmentCheckoutInterface;

    /**
     * @param string $checkoutId
     * @param PaymentDataInterface $paymentData
     * @return FulfillmentCheckoutInterface
     */
    public function completeCheckout(string $checkoutId, PaymentDataInterface $paymentData): FulfillmentCheckoutInterface;
}
