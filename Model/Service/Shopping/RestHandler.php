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
use Magebit\UcpSpec\MutableApi\Schemas\Shopping\CheckoutCreateRequestInterface;
use Magebit\UcpSpec\MutableApi\Schemas\Shopping\FulfillmentCheckoutInterface;
use Magebit\UcpSpec\MutableApi\Schemas\Shopping\PaymentDataInterface;
use Magebit\UcpSpec\MutableApi\Schemas\Shopping\Types\FulfillmentRequestInterface;
use Magebit\UcpSpec\MutableApi\Schemas\Shopping\Types\BuyerInterface;
use Magebit\UcpSpec\MutableApi\Schemas\Shopping\Types\FulfillmentMethodCreateRequestInterface;
use Magebit\UcpSpec\MutableApi\Schemas\Shopping\Types\FulfillmentDestinationRequestInterface;
use Magebit\UcpSpec\MutableApi\Schemas\Shopping\Types\PostalAddressInterface;
use Magebit\UniversalCommerce\Model\Service\Shopping\Converter\QuoteToCheckoutResponse;
use Magento\Quote\Api\GuestCartManagementInterface;
use Magento\Quote\Api\GuestCartRepositoryInterface;
use Magento\Quote\Api\Data\CartInterface;
use Magento\Quote\Model\Quote;
use Magento\Quote\Model\Quote\Address;
use Magento\Catalog\Api\ProductRepositoryInterface;
use Magebit\UcpSpec\MutableApi\Schemas\Shopping\Types\LineItemCreateRequestInterface;
use Magebit\UcpSpec\MutableApi\Schemas\Shopping\Types\LineItemUpdateRequestInterface;
use Magento\Catalog\Model\Product;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Quote\Api\CartRepositoryInterface;

class RestHandler implements RestHandlerInterface
{
    public function __construct(
        protected readonly GuestCartManagementInterface $guestCartManagement,
        protected readonly GuestCartRepositoryInterface $guestCartRepository,
        protected readonly QuoteToCheckoutResponse $quoteToCheckoutResponse,
        protected readonly ProductRepositoryInterface $productRepository,
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

        $this->addItemsToCart($cart, $request->getLineItems());

        if ($request->getBuyer()) {
            $this->addBuyerInformationToCart($cart, $request->getBuyer());
        }

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
        try {
            $cart = $this->guestCartRepository->get($checkoutId);
        } catch (NoSuchEntityException $e) {
            throw new LocalizedException(__('Checkout session not found: %1. Please create a new checkout session.', $checkoutId));
        }

        return $this->quoteToCheckoutResponse->convert($cart, $checkoutId);
    }

    /**
     * @param string $checkoutId
     * @return FulfillmentCheckoutInterface
     * @throws LocalizedException
     */
    public function cancelCheckout(string $checkoutId): FulfillmentCheckoutInterface
    {
        try {
            $cart = $this->guestCartRepository->get($checkoutId);
        } catch (NoSuchEntityException $e) {
            throw new LocalizedException(__('Checkout session not found: %1. Please create a new checkout session.', $checkoutId));
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
        try {
            $cart = $this->guestCartRepository->get($checkoutId);
        } catch (NoSuchEntityException $e) {
            throw new LocalizedException(__('Checkout session not found: %1. Please create a new checkout session.', $checkoutId));
        }

        $this->addItemsToCart($cart, $request->getLineItems());

        if ($request->getBuyer()) {
            $this->addBuyerInformationToCart($cart, $request->getBuyer());
        }

        if ($request->getFulfillment()) {
            $this->addFulfillmentInformationToCart($cart, $request->getFulfillment());
        }

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
        try {
            $cart = $this->guestCartRepository->get($checkoutId);
        } catch (NoSuchEntityException $e) {
            throw new LocalizedException(__('Checkout session not found: %1. Please create a new checkout session.', $checkoutId));
        }

        $payment = $paymentData->getPaymentData();
        $billingAddress = $payment->getBillingAddress();

        if ($billingAddress) {
            $this->addBillingAddressToCart($cart, $billingAddress);
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
     * Add items to cart
     *
     * @param CartInterface $cart
     * @param array<LineItemCreateRequestInterface|LineItemUpdateRequestInterface> $lineItems
     * @return void
     */
    public function addItemsToCart(CartInterface $cart, array $lineItems): void
    {
        /** @var Quote $cart */
        $cart->removeAllItems();

        foreach ($lineItems as $lineItem) {
            $itemId = $lineItem->getItem()->getId();
            $quantity = $lineItem->getQuantity();

            /** @var Product $product */
            $product = $this->productRepository->get($itemId);

            /** @var Quote $cart */
            $cart->addProduct($product, $quantity);
        }
    }

    /**
     * Add buyer information to cart
     *
     * @param CartInterface $cart
     * @param BuyerInterface $buyer
     * @return void
     */
    public function addBuyerInformationToCart(CartInterface $cart, BuyerInterface $buyer): void
    {
        /** @var Quote $cart */
        if ($buyer->getEmail()) {
            $cart->setCustomerEmail($buyer->getEmail());
        }

        if ($buyer->getFirstName()) {
            $cart->setCustomerFirstname($buyer->getFirstName());
        }

        if ($buyer->getLastName()) {
            $cart->setCustomerLastname($buyer->getLastName());
        }

        $billingAddress = $cart->getBillingAddress();
        $billingAddress->setCountryId('US');

        if ($buyer->getEmail()) {
            $billingAddress->setEmail($buyer->getEmail());
        }

        if ($buyer->getFirstName()) {
            $billingAddress->setFirstname($buyer->getFirstName());
        }

        if ($buyer->getLastName()) {
            $billingAddress->setLastname($buyer->getLastName());
        }

        if ($buyer->getFullName()) {
            [$firstName, $lastName] = explode(' ', $buyer->getFullName(), 2);
            $billingAddress->setFirstname($firstName);
            $billingAddress->setLastname($lastName);
        }

        if ($buyer->getPhoneNumber()) {
            $billingAddress->setTelephone($buyer->getPhoneNumber());
        }

        $this->copyBillingAddressToShippingAddress($cart);
    }

    /**
     * Add fulfillment information to cart
     *
     * @param CartInterface $cart
     * @param FulfillmentRequestInterface $fulfillment
     * @return void
     */
    public function addFulfillmentInformationToCart(CartInterface $cart, FulfillmentRequestInterface $fulfillment): void
    {
        /** @var Quote $cart */
        $methods = $fulfillment->getMethods();
        if (!$methods) {
            return;
        }

        // Find shipping method
        $shippingMethod = null;
        foreach ($methods as $method) {
            if ($method->getType() === FulfillmentMethodCreateRequestInterface::TYPE_SHIPPING) {
                $shippingMethod = $method;
                break;
            }
        }

        if (!$shippingMethod) {
            return;
        }

        $shippingAddress = $cart->getShippingAddress();

        // Set shipping method from selected option
        $groups = $shippingMethod->getGroups();
        if ($groups) {
            foreach ($groups as $group) {
                $selectedOptionId = $group->getSelectedOptionId();
                if ($selectedOptionId) {
                    // Parse carrier_method from option ID (format: "carrier_method")
                    $parts = explode('_', $selectedOptionId, 2);
                    if (count($parts) === 2) {
                        [$carrier, $method] = $parts;
                        $shippingAddress->setShippingMethod($carrier . '_' . $method);
                        break;
                    }
                }
            }
        }

        $shippingAddress->collectShippingRates();
    }

    /**
     * Copy billing address to shipping address
     *
     * @param CartInterface $cart
     * @return void
     */
    public function copyBillingAddressToShippingAddress(CartInterface $cart): void
    {
        /** @var Quote $cart */
        $billingAddress = $cart->getBillingAddress();
        $shippingAddress = $cart->getShippingAddress();
        $shippingAddress->setSameAsBilling(1);
        $shippingAddress->setCountryId($billingAddress->getCountryId());
        $shippingAddress->setCity($billingAddress->getCity());
        $shippingAddress->setRegion($billingAddress->getRegion());
        $shippingAddress->setPostcode($billingAddress->getPostcode());
        $shippingAddress->setFirstname($billingAddress->getFirstname());
        $shippingAddress->setLastname($billingAddress->getLastname());
        $shippingAddress->setTelephone($billingAddress->getTelephone());
        $shippingAddress->setStreet($billingAddress->getStreet());
        $shippingAddress->collectShippingRates();
    }

    /**
     * Add billing address to cart
     *
     * @param CartInterface $cart
     * @param PostalAddressInterface $address
     * @return void
     */
    private function addBillingAddressToCart(CartInterface $cart, PostalAddressInterface $address): void
    {
        /** @var Quote $cart */
        $billingAddress = $cart->getBillingAddress();

        if ($address->getStreetAddress()) {
            $billingAddress->setStreet($address->getStreetAddress());
        }

        if ($address->getAddressLocality()) {
            $billingAddress->setCity($address->getAddressLocality());
        }

        if ($address->getAddressRegion()) {
            $billingAddress->setRegion($address->getAddressRegion());
        }

        if ($address->getAddressCountry()) {
            $billingAddress->setCountryId($address->getAddressCountry());
        }

        if ($address->getPostalCode()) {
            $billingAddress->setPostcode($address->getPostalCode());
        }

        if ($address->getFirstName()) {
            $billingAddress->setFirstname($address->getFirstName());
        }

        if ($address->getLastName()) {
            $billingAddress->setLastname($address->getLastName());
        }

        if ($address->getFullName() && !$address->getFirstName() && !$address->getLastName()) {
            $nameParts = explode(' ', $address->getFullName(), 2);
            $billingAddress->setFirstname($nameParts[0] ?? '');
            $billingAddress->setLastname($nameParts[1] ?? '');
        }

        if ($address->getPhoneNumber()) {
            $billingAddress->setTelephone($address->getPhoneNumber());
        }

        $this->copyBillingAddressToShippingAddress($cart);
    }
}
