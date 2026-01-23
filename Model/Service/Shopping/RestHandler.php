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
use Magento\Catalog\Api\ProductRepositoryInterface;
use Magebit\UcpSpec\MutableApi\Schemas\Shopping\Types\LineItemCreateRequestInterface;
use Magebit\UcpSpec\MutableApi\Schemas\Shopping\Types\LineItemUpdateRequestInterface;
use Magebit\UniversalCommerce\Exception\UcpException;
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
        protected readonly CartRepositoryInterface $cartRepository,
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

        $this->copyPersonalInformationFromBillingToShipping($cart);

        if ($request->getFulfillment()) {
            $this->addFulfillmentInformationToCart($cart, $request->getFulfillment());
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
        $this->addItemsToCart($cart, $request->getLineItems());

        if ($request->getBuyer()) {
            $this->addBuyerInformationToCart($cart, $request->getBuyer());
        }

        $this->copyPersonalInformationFromBillingToShipping($cart);

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
        $cart = $this->getCartByMaskedId($checkoutId);
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

        $destinations = $shippingMethod->getDestinations() ?? [];

        foreach ($destinations as $destination) {
            $this->addDestinationToCart($cart, $destination);
            break;
        }

        // Set shipping method from selected option
        $groups = $shippingMethod->getGroups();

        if (!$groups) {
            return;
        }

        foreach ($groups as $group) {
            $selectedOptionId = $group->getSelectedOptionId();

            if (!$selectedOptionId) {
                continue;
            }

            $this->setShippingMethodToCart($cart, $selectedOptionId);
            break;
        }
    }

    /**
     * Set shipping method to cart
     *
     * @param CartInterface $cart
     * @param string $shippingMethod
     * @return void
     */
    public function setShippingMethodToCart(CartInterface $cart, string $shippingMethod): void
    {
        /** @var Quote $cart */
        $shippingAddress = $cart->getShippingAddress();
        $shippingAddress->setShippingMethod($shippingMethod);

        $cartExtension = $cart->getExtensionAttributes();
        if ($cartExtension && $cartExtension->getShippingAssignments()) {
            $cartExtension->getShippingAssignments()[0]
                ->getShipping()
                ->setMethod($shippingMethod);
        }

        $shippingAddress->setCollectShippingRates(true);
    }

    /**
     * Copy personal information from billing to shipping address
     *
     * @param CartInterface $cart
     * @return void
     */
    public function copyPersonalInformationFromBillingToShipping(CartInterface $cart): void
    {
        /** @var Quote $cart */
        $billingAddress = $cart->getBillingAddress();
        $shippingAddress = $cart->getShippingAddress();

        if ($billingAddress->getFirstName()) {
            $shippingAddress->setFirstname($billingAddress->getFirstName());
        }

        if ($billingAddress->getLastName()) {
            $shippingAddress->setLastname($billingAddress->getLastName());
        }

        if ($billingAddress->getEmail()) {
            $shippingAddress->setEmail($billingAddress->getEmail());
        }

        if ($billingAddress->getPhoneNumber()) {
            $shippingAddress->setTelephone($billingAddress->getPhoneNumber());
        }
    }

    /**
     * Add destination to cart
     *
     * @param CartInterface $cart
     * @param FulfillmentDestinationRequestInterface $destination
     * @return void
     */
    public function addDestinationToCart(CartInterface $cart, FulfillmentDestinationRequestInterface $destination): void
    {
        /** @var Quote $cart */
        $shippingAddress = $cart->getShippingAddress();

        if ($destination->getStreetAddress()) {
            $shippingAddress->setStreet($destination->getStreetAddress());
        }
        if ($destination->getAddressLocality()) {
            $shippingAddress->setCity($destination->getAddressLocality());
        }

        if ($destination->getAddressRegion()) {
            $shippingAddress->setRegion($destination->getAddressRegion());
        }

        if ($destination->getAddressCountry()) {
            $shippingAddress->setCountryId($destination->getAddressCountry());
        }

        if ($destination->getPostalCode()) {
            $shippingAddress->setPostcode($destination->getPostalCode());
        }

        if ($destination->getFirstName()) {
            $shippingAddress->setFirstname($destination->getFirstName());
        }

        if ($destination->getLastName()) {
            $shippingAddress->setLastname($destination->getLastName());
        }

        if ($destination->getFullName() && !$destination->getFirstName() && !$destination->getLastName()) {
            $nameParts = explode(' ', $destination->getFullName(), 2);
            $shippingAddress->setFirstname($nameParts[0] ?? '');
            $shippingAddress->setLastname($nameParts[1] ?? '');
        }

        if ($destination->getPhoneNumber()) {
            $shippingAddress->setTelephone($destination->getPhoneNumber());
        }
    }

    /**
     * Add billing address to cart
     *
     * @param CartInterface $cart
     * @param PostalAddressInterface $address
     * @return void
     */
    public function addBillingAddressToCart(CartInterface $cart, PostalAddressInterface $address): void
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
    }
}
