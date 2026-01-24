<?php

/**
 * This file is part of the Magebit_UniversalCommerce package.
 *
 * @copyright Copyright (c) 2026 Magebit, Ltd. (https://magebit.com/)
 * @author    Magebit <info@magebit.com>
 * @license   MIT
 */
declare(strict_types=1);

namespace Magebit\UniversalCommerce\Model\Service\Shopping;

use Magebit\UniversalCommerce\Api\Service\Shopping\RestHandlerInterface;
use Magebit\UniversalCommerce\Api\Service\Shopping\CheckoutUpdateRequestInterface;
use Magebit\UniversalCommerce\Api\Service\Shopping\CheckoutCreateRequestInterface;
use Magebit\UcpSpec\MutableApi\Schemas\Shopping\FulfillmentCheckoutInterface;
use Magebit\UcpSpec\MutableApi\Schemas\Shopping\PaymentDataInterface;
use Magebit\UniversalCommerce\Model\Service\Shopping\Converter\QuoteToCheckoutResponse;
use Magebit\UniversalCommerce\Model\Service\Shopping\CheckoutDataProcessor;
use Magento\Quote\Api\GuestCartManagementInterface;
use Magento\Quote\Api\GuestCartRepositoryInterface;
use Magento\Quote\Api\Data\CartInterface;
use Magebit\UniversalCommerce\Exception\UcpException;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Quote\Api\CartRepositoryInterface;

class RestHandler implements RestHandlerInterface
{
    /**
     * @param CheckoutDataProcessor $checkoutDataProcessor
     * @param GuestCartManagementInterface $guestCartManagement
     * @param GuestCartRepositoryInterface $guestCartRepository
     * @param QuoteToCheckoutResponse $quoteToCheckoutResponse
     * @param CartRepositoryInterface $cartRepository
     */
    public function __construct(
        protected readonly CheckoutDataProcessor $checkoutDataProcessor,
        protected readonly GuestCartManagementInterface $guestCartManagement,
        protected readonly GuestCartRepositoryInterface $guestCartRepository,
        protected readonly QuoteToCheckoutResponse $quoteToCheckoutResponse,
        protected readonly CartRepositoryInterface $cartRepository
    ) {
    }

    /**
     * @param CheckoutCreateRequestInterface $request
     * @return FulfillmentCheckoutInterface
     */
    public function createCheckout(CheckoutCreateRequestInterface $request): FulfillmentCheckoutInterface
    {
        $maskedCartId = $this->guestCartManagement->createEmptyCart();
        $cart = $this->guestCartRepository->get($maskedCartId);

        $this->checkoutDataProcessor->processCreateCheckoutRequest($cart, $request, $maskedCartId);
        $this->cartRepository->save($cart);

        return $this->quoteToCheckoutResponse->convert($cart, $maskedCartId);
    }

    /**
     * @param string $checkoutId
     * @return FulfillmentCheckoutInterface
     * @throws LocalizedException
     */
    public function getCheckout(string $checkoutId): FulfillmentCheckoutInterface
    {
        $cart = $this->getCartByMaskedId($checkoutId);
        return $this->quoteToCheckoutResponse->convert($cart, $checkoutId);
    }

    /**
     * @param string $checkoutId
     * @return FulfillmentCheckoutInterface
     * @throws LocalizedException
     */
    public function cancelCheckout(string $checkoutId): FulfillmentCheckoutInterface
    {
        $cart = $this->getCartByMaskedId($checkoutId);

        if (!$cart->getIsActive()) {
            throw new UcpException(
                __('Checkout session is already canceled: %1.', $checkoutId),
                'error',
                'checkout_already_canceled',
                400
            );
        }

        $cart->setIsActive(false);
        $this->cartRepository->save($cart);
        return $this->quoteToCheckoutResponse->convert($cart, $checkoutId);
    }

    /**
     * @param string $checkoutId
     * @param CheckoutUpdateRequestInterface $request
     * @return FulfillmentCheckoutInterface
     * @throws LocalizedException
     */
    public function updateCheckout(string $checkoutId, CheckoutUpdateRequestInterface $request): FulfillmentCheckoutInterface
    {
        $cart = $this->getCartByMaskedId($checkoutId);
        $this->checkoutDataProcessor->processUpdateCheckoutRequest($cart, $request, $checkoutId);
        $this->cartRepository->save($cart);

        return $this->quoteToCheckoutResponse->convert($cart, $checkoutId);
    }

    /**
     * @param string $checkoutId
     * @param PaymentDataInterface $paymentData
     * @return FulfillmentCheckoutInterface
     * @throws LocalizedException
     */
    public function completeCheckout(string $checkoutId, PaymentDataInterface $paymentData): FulfillmentCheckoutInterface
    {
        $cart = $this->getCartByMaskedId($checkoutId);
        $payment = $paymentData->getPaymentData();
        $billingAddress = $payment->getBillingAddress();

        if ($billingAddress) {
            $this->checkoutDataProcessor->processBillingAddress($cart, $billingAddress);
        }

        $this->cartRepository->save($cart);

        try {
            $orderId = $this->guestCartManagement->placeOrder($checkoutId);
        } catch (LocalizedException $e) {
            throw new LocalizedException(__('Failed to place order: %1', $e->getMessage()));
        }

        return $this->quoteToCheckoutResponse->convert($cart, $checkoutId);
    }

    /**
     * Get cart by masked ID
     *
     * @param string $maskedCartId
     * @return CartInterface
     * @throws UcpException
     */
    public function getCartByMaskedId(string $maskedCartId): CartInterface
    {
        try {
            $cart = $this->guestCartRepository->get($maskedCartId);
        } catch (NoSuchEntityException $e) {
            throw new UcpException(
                __('Checkout session not found: %1. Please create a new checkout session.', $maskedCartId),
                'not_found',
                'session_not_found',
                404
            );
        }

        return $cart;
    }
}
