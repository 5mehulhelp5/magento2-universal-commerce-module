<?php

/**
 * @author Magebit <info@magebit.com>
 * @copyright Copyright (c) Magebit, Ltd. (https://magebit.com)
 * @license https://magebit.com/code-license
 */

declare(strict_types=1);

namespace Magebit\UniversalCommerce\Model\Service\Shopping;

use Magebit\UcpSpec\MutableApi\Schemas\Shopping\Types\BuyerInterface;
use Magebit\UniversalCommerce\Api\Service\Shopping\CheckoutCreateRequestInterface;
use Magento\Quote\Api\Data\CartInterface;
use Magento\Quote\Model\Quote;
use Magento\Catalog\Api\ProductRepositoryInterface;
use Magebit\UcpSpec\MutableApi\Schemas\Shopping\Types\LineItemCreateRequestInterface;
use Magebit\UcpSpec\MutableApi\Schemas\Shopping\Types\LineItemUpdateRequestInterface;
use Magento\Catalog\Model\Product;
use Magebit\UcpSpec\MutableApi\Schemas\Shopping\Types\FulfillmentRequestInterface;
use Magebit\UcpSpec\MutableApi\Schemas\Shopping\Types\FulfillmentMethodCreateRequestInterface;
use Magebit\UcpSpec\MutableApi\Schemas\Shopping\Types\FulfillmentDestinationRequestInterface;
use Magebit\UcpSpec\MutableApi\Schemas\Shopping\DiscountDiscountsObjectInterface;
use Magebit\UcpSpec\MutableApi\Schemas\Shopping\Types\PostalAddressInterface;
use Magebit\UniversalCommerce\Api\Service\Shopping\CheckoutUpdateRequestInterface;
use Magento\Quote\Api\GuestCouponManagementInterface;

use Magento\Framework\App\Request\Http;
use Magento\Framework\App\RequestInterface;
use Magebit\UniversalCommerce\Model\Service\Shopping\AgentProfileParser;

class CheckoutDataProcessor
{
    /**
     * @param ProductRepositoryInterface $productRepository
     * @param GuestCouponManagementInterface $guestCouponManagement
     * @param AgentProfileParser $agentProfileParser
     * @param Http $httpRequest
     */
    public function __construct(
        protected readonly ProductRepositoryInterface $productRepository,
        protected readonly GuestCouponManagementInterface $guestCouponManagement,
        protected readonly AgentProfileParser $agentProfileParser,
        protected readonly Http $httpRequest,
    ) {
    }

    /**
     * Process create checkout request
     *
     * @param CartInterface $cart
     * @param CheckoutCreateRequestInterface $request
     * @param string $maskedCartId
     * @return void
     */
    public function processCreateCheckoutRequest(CartInterface $cart, CheckoutCreateRequestInterface $request, string $maskedCartId): void
    {
        /** @var Quote $cart */
        $this->processLineItems($cart, $request->getLineItems());

        if ($request->getBuyer()) {
            $this->processBuyerInformation($cart, $request->getBuyer());
        }

        $this->copyPersonalInformationFromBillingToShipping($cart);

        if ($request->getFulfillment()) {
            $this->processFulfillmentInformation($cart, $request->getFulfillment());
        }

        if ($request->getDiscounts()) {
            $this->processDiscountInformation($maskedCartId, $cart, $request->getDiscounts());
        }
    }

    /**
     * Process agent profile
     *
     * @param CartInterface $cart
     * @return void
     */
    public function processAgentProfile(): void
    {
        $ucpAgentHeader = $this->httpRequest->getHeader('UCP-Agent');

        if (!is_string($ucpAgentHeader)) {
            return;
        }

        $agentProfile = $this->agentProfileParser->parse($ucpAgentHeader);

        if (!$agentProfile) {
            return;
        }
    }

    /**
     * Process buyer information
     *
     * @param CartInterface $cart
     * @param BuyerInterface $buyer
     * @return void
     */
    public function processBuyerInformation(CartInterface $cart, BuyerInterface $buyer): void
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

        if ($buyer->getPhoneNumber()) {
            $billingAddress->setTelephone($buyer->getPhoneNumber());
        }
    }

    /**
     * Process update checkout request
     *
     * @param CartInterface $cart
     * @param CheckoutUpdateRequestInterface $request
     * @param string $maskedCartId
     * @return void
     */
    public function processUpdateCheckoutRequest(CartInterface $cart, CheckoutUpdateRequestInterface $request, string $maskedCartId): void
    {
        /** @var Quote $cart */
        $this->processLineItems($cart, $request->getLineItems());

        if ($request->getBuyer()) {
            $this->processBuyerInformation($cart, $request->getBuyer());
        }

        $this->copyPersonalInformationFromBillingToShipping($cart);

        if ($request->getFulfillment()) {
            $this->processFulfillmentInformation($cart, $request->getFulfillment());
        }

        if ($request->getDiscounts()) {
            $this->processDiscountInformation($maskedCartId, $cart, $request->getDiscounts());
        }
    }

    /**
     * Process line items
     *
     * @param CartInterface $cart
     * @param array<LineItemCreateRequestInterface|LineItemUpdateRequestInterface> $lineItems
     * @return void
     */
    public function processLineItems(CartInterface $cart, array $lineItems): void
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
     * Process fulfillment information
     *
     * @param CartInterface $cart
     * @param FulfillmentRequestInterface $fulfillment
     * @return void
     */
    public function processFulfillmentInformation(CartInterface $cart, FulfillmentRequestInterface $fulfillment): void
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

        if ($destination->getPhoneNumber()) {
            $shippingAddress->setTelephone($destination->getPhoneNumber());
        }
    }

    /**
     * Process discount information
     *
     * @param string $maskedCartId
     * @param CartInterface $cart
     * @param DiscountDiscountsObjectInterface $discounts
     * @return void
     */
    public function processDiscountInformation(string $maskedCartId, CartInterface $cart, DiscountDiscountsObjectInterface $discounts): void
    {
        /** @var Quote $cart */
        $codes = $discounts->getCodes();

        // If empty array, clear coupon code
        if ($codes === null || empty($codes)) {
            try {
                $this->guestCouponManagement->remove($maskedCartId);
            } catch (\Exception $e) {
                // Ignore if no coupon to remove
            }
            return;
        }

        $couponCode = trim($codes[0]);
        if (empty($couponCode)) {
            return;
        }

        try {
            $this->guestCouponManagement->set($maskedCartId, $couponCode);
            $cart->collectTotals();
        } catch (\Exception $e) {
            // Coupon validation errors will be handled by quote validator
            // and returned via messages array
        }
    }

    /**
     * Process billing address
     *
     * @param CartInterface $cart
     * @param PostalAddressInterface $address
     * @return void
     */
    public function processBillingAddress(CartInterface $cart, PostalAddressInterface $address): void
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

        if ($address->getPhoneNumber()) {
            $billingAddress->setTelephone($address->getPhoneNumber());
        }
    }
}
