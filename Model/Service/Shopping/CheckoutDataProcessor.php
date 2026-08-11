<?php

/**
 * @author Magebit <info@magebit.com>
 * @copyright Copyright (c) Magebit, Ltd. (https://magebit.com)
 * @license https://magebit.com/code-license
 */

declare(strict_types=1);

namespace Magebit\UniversalCommerce\Model\Service\Shopping;

use Magebit\UcpSpec\MutableApi\Schemas\Shopping\DiscountDiscountsObjectInterface;
use Magebit\UcpSpec\MutableApi\Schemas\Shopping\Types\BuyerInterface;
use Magebit\UcpSpec\MutableApi\Schemas\Shopping\Types\FulfillmentDestinationRequestInterface;
use Magebit\UcpSpec\MutableApi\Schemas\Shopping\Types\FulfillmentMethodCreateRequestInterface;
use Magebit\UcpSpec\MutableApi\Schemas\Shopping\Types\FulfillmentRequestInterface;
use Magebit\UcpSpec\MutableApi\Schemas\Shopping\Types\LineItemCreateRequestInterface;
use Magebit\UcpSpec\MutableApi\Schemas\Shopping\Types\LineItemUpdateRequestInterface;
use Magebit\UcpSpec\MutableApi\Schemas\Shopping\Types\MessageInterface;
use Magebit\UcpSpec\MutableApi\Schemas\Shopping\Types\MessageInterfaceFactory;
use Magebit\UcpSpec\MutableApi\Schemas\Shopping\Types\PostalAddressInterface;
use Magebit\UniversalCommerce\Api\Service\Shopping\CheckoutCreateRequestInterface;
use Magebit\UniversalCommerce\Api\Service\Shopping\CheckoutUpdateRequestInterface;
use Magebit\UniversalCommerce\Api\Service\Shopping\QuoteValidatorInterface;
use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Catalog\Model\Product;
use Magento\Framework\App\Request\Http;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Quote\Api\Data\CartInterface;
use Magento\Quote\Api\GuestCouponManagementInterface;
use Magento\Quote\Model\Quote;
use Magento\Quote\Model\Quote\Address;

class CheckoutDataProcessor implements QuoteValidatorInterface
{
    /**
     * Quote data key holding the messages raised while processing the request; read back through validate().
     */
    public const QUOTE_MESSAGES_KEY = 'ucp_messages';

    public const MESSAGE_TYPE_ERROR = 'error';

    public const CODE_INVALID = 'invalid';

    public const CODE_OUT_OF_STOCK = 'out_of_stock';

    /**
     * @param ProductRepositoryInterface $productRepository
     * @param GuestCouponManagementInterface $guestCouponManagement
     * @param AgentProfileParser $agentProfileParser
     * @param Http $httpRequest
     * @param MessageInterfaceFactory $messageFactory
     */
    public function __construct(
        protected readonly ProductRepositoryInterface $productRepository,
        protected readonly GuestCouponManagementInterface $guestCouponManagement,
        protected readonly AgentProfileParser $agentProfileParser,
        protected readonly Http $httpRequest,
        protected readonly MessageInterfaceFactory $messageFactory
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
    public function processCreateCheckoutRequest(
        CartInterface $cart,
        CheckoutCreateRequestInterface $request,
        string $maskedCartId
    ): void {
        /** @var Quote $cart */
        $this->processLineItems($cart, $request->getLineItems());

        if ($request->getBuyer()) {
            $this->processBuyerInformation($cart, $request->getBuyer());
        }

        $this->copyPersonalInformationFromBillingToShipping($cart);

        if ($request->getFulfillment()) {
            $this->processFulfillmentInformation($cart, $request->getFulfillment());
        }

        $this->resolveBillingCountry($cart);

        if ($request->getDiscounts()) {
            $this->processDiscountInformation($maskedCartId, $cart, $request->getDiscounts());
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
    public function processUpdateCheckoutRequest(
        CartInterface $cart,
        CheckoutUpdateRequestInterface $request,
        string $maskedCartId
    ): void {
        /** @var Quote $cart */
        $this->processLineItems($cart, $request->getLineItems());

        if ($request->getBuyer()) {
            $this->processBuyerInformation($cart, $request->getBuyer());
        }

        $this->copyPersonalInformationFromBillingToShipping($cart);

        if ($request->getFulfillment()) {
            $this->processFulfillmentInformation($cart, $request->getFulfillment());
        }

        $this->resolveBillingCountry($cart);

        if ($request->getDiscounts()) {
            $this->processDiscountInformation($maskedCartId, $cart, $request->getDiscounts());
        }
    }

    /**
     * Expose the messages collected while processing the request to the checkout response builder
     *
     * @param CartInterface $quote
     * @return MessageInterface[]|null
     */
    public function validate(CartInterface $quote): array|null
    {
        /** @var Quote $quote */
        $messages = $quote->getData(self::QUOTE_MESSAGES_KEY);

        if (!is_array($messages)) {
            return null;
        }

        /** @var MessageInterface[] $messages */
        return $messages;
    }

    /**
     * Process agent profile
     *
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
     * Process line items, reporting SKUs that cannot be added instead of failing the whole request
     *
     * @param CartInterface $cart
     * @param array<LineItemCreateRequestInterface|LineItemUpdateRequestInterface> $lineItems
     * @return void
     */
    public function processLineItems(CartInterface $cart, array $lineItems): void
    {
        /** @var Quote $cart */
        $cart->removeAllItems();

        foreach (array_values($lineItems) as $index => $lineItem) {
            $sku = $lineItem->getItem()->getId();
            $path = sprintf('$.line_items[%d].item.id', $index);
            $product = $this->loadProduct($cart, $sku);

            if (!$product) {
                $this->addMessage($cart, self::CODE_INVALID, $path, sprintf('Product "%s" does not exist.', $sku));
                continue;
            }

            if (!$product->isSalable()) {
                $this->addMessage(
                    $cart,
                    self::CODE_OUT_OF_STOCK,
                    $path,
                    sprintf('Product "%s" is not available for purchase.', $sku)
                );
                continue;
            }

            $this->addProductToCart($cart, $product, $lineItem->getQuantity(), $path);
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

        if ($billingAddress->getFirstname()) {
            $shippingAddress->setFirstname($billingAddress->getFirstname());
        }

        if ($billingAddress->getLastname()) {
            $shippingAddress->setLastname($billingAddress->getLastname());
        }

        if ($billingAddress->getEmail()) {
            $shippingAddress->setEmail($billingAddress->getEmail());
        }

        // Quote addresses store the phone under `telephone`; getPhoneNumber() resolved to an unset data key.
        if ($billingAddress->getTelephone()) {
            $shippingAddress->setTelephone($billingAddress->getTelephone());
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
        $shippingMethod = $this->findShippingMethod($fulfillment->getMethods() ?? []);

        if (!$shippingMethod) {
            return;
        }

        if ($destination = $this->selectDestination($shippingMethod)) {
            $this->addDestinationToCart($cart, $destination);
        }

        foreach ($shippingMethod->getGroups() ?? [] as $group) {
            if ($selectedOptionId = $group->getSelectedOptionId()) {
                $this->setShippingMethodToCart($cart, $selectedOptionId);
                break;
            }
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
        $this->applyAddressFields($shippingAddress, $destination);

        // Rates cached against the previous destination are stale once the address moves.
        $shippingAddress->setCollectShippingRates(true);
    }

    /**
     * Process discount information
     *
     * @param string $maskedCartId
     * @param CartInterface $cart
     * @param DiscountDiscountsObjectInterface $discounts
     * @return void
     */
    public function processDiscountInformation(
        string $maskedCartId,
        CartInterface $cart,
        DiscountDiscountsObjectInterface $discounts
    ): void {
        /** @var Quote $cart */
        $codes = $discounts->getCodes();

        // If empty array, clear coupon code
        if ($codes === null || empty($codes)) {
            try {
                $this->guestCouponManagement->remove($maskedCartId);
            } catch (\Exception $e) {
                unset($e);
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
            // Coupon validation errors are reported by the quote validator instead.
            unset($e);
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
        $this->applyAddressFields($cart->getBillingAddress(), $address);
    }

    /**
     * Give billing the country submitted for fulfillment, the only address a checkout request carries
     *
     * @param CartInterface $cart
     * @return void
     */
    public function resolveBillingCountry(CartInterface $cart): void
    {
        /** @var Quote $cart */
        $billingAddress = $cart->getBillingAddress();

        if ($billingAddress->getCountryId()) {
            return;
        }

        // Deliberately left unset when nothing was submitted, so the address validator reports the
        // missing country rather than the quote quietly pricing itself against an invented one.
        if ($shippingCountry = $cart->getShippingAddress()->getCountryId()) {
            $billingAddress->setCountryId($shippingCountry);
        }
    }

    /**
     * Copy the UCP postal fields onto a quote address
     *
     * @param Address $address
     * @param FulfillmentDestinationRequestInterface|PostalAddressInterface $source
     * @return void
     */
    private function applyAddressFields(
        Address $address,
        FulfillmentDestinationRequestInterface|PostalAddressInterface $source
    ): void {
        $street = array_values(array_filter([$source->getStreetAddress(), $source->getExtendedAddress()]));

        if ($street) {
            $address->setStreet($street);
        }

        if ($source->getAddressLocality()) {
            $address->setCity($source->getAddressLocality());
        }

        if ($source->getAddressRegion()) {
            $address->setRegion($source->getAddressRegion());
        }

        if ($source->getAddressCountry()) {
            $address->setCountryId($source->getAddressCountry());
        }

        if ($source->getPostalCode()) {
            $address->setPostcode($source->getPostalCode());
        }

        if ($source->getFirstName()) {
            $address->setFirstname($source->getFirstName());
        }

        if ($source->getLastName()) {
            $address->setLastname($source->getLastName());
        }

        if ($source->getPhoneNumber()) {
            $address->setTelephone($source->getPhoneNumber());
        }
    }

    /**
     * @param array<FulfillmentMethodCreateRequestInterface> $methods
     * @return FulfillmentMethodCreateRequestInterface|null
     */
    private function findShippingMethod(array $methods): ?FulfillmentMethodCreateRequestInterface
    {
        foreach ($methods as $method) {
            try {
                $type = $method->getType();
            } catch (\InvalidArgumentException $e) {
                // Update payloads may omit `type`; such a method cannot be routed to shipping.
                unset($e);
                continue;
            }

            if ($type === FulfillmentMethodCreateRequestInterface::TYPE_SHIPPING) {
                return $method;
            }
        }

        return null;
    }

    /**
     * Resolve the destination the agent selected, falling back to the first one offered
     *
     * @param FulfillmentMethodCreateRequestInterface $method
     * @return FulfillmentDestinationRequestInterface|null
     */
    private function selectDestination(
        FulfillmentMethodCreateRequestInterface $method
    ): ?FulfillmentDestinationRequestInterface {
        $destinations = array_values($method->getDestinations() ?? []);

        if (!$destinations) {
            return null;
        }

        $selectedId = $method->getSelectedDestinationId();

        foreach ($destinations as $destination) {
            if ($selectedId !== null && $destination->getId() === $selectedId) {
                return $destination;
            }
        }

        return $destinations[0];
    }

    /**
     * @param Quote $cart
     * @param string $sku
     * @return Product|null
     */
    private function loadProduct(Quote $cart, string $sku): ?Product
    {
        try {
            /** @var Product $product */
            $product = $this->productRepository->get($sku, false, (int) $cart->getStoreId());
        } catch (NoSuchEntityException $e) {
            unset($e);
            return null;
        }

        return $product;
    }

    /**
     * @param Quote $cart
     * @param Product $product
     * @param int $quantity
     * @param string $path
     * @return void
     */
    private function addProductToCart(Quote $cart, Product $product, int $quantity, string $path): void
    {
        try {
            $result = $cart->addProduct($product, $quantity);
        } catch (LocalizedException $e) {
            $this->addMessage($cart, self::CODE_INVALID, $path, $e->getMessage());
            return;
        }

        // Quote::addProduct hands back a string instead of an item when the product cannot be configured.
        if (is_string($result)) {
            $this->addMessage($cart, self::CODE_INVALID, $path, $result);
        }
    }

    /**
     * @param Quote $cart
     * @param string $code
     * @param string $path
     * @param string $content
     * @return void
     */
    private function addMessage(Quote $cart, string $code, string $path, string $content): void
    {
        $messages = $cart->getData(self::QUOTE_MESSAGES_KEY);
        $messages = is_array($messages) ? $messages : [];

        $messages[] = $this->messageFactory->create(['data' => [
            MessageInterface::KEY_TYPE => self::MESSAGE_TYPE_ERROR,
            MessageInterface::KEY_CODE => $code,
            MessageInterface::KEY_PATH => $path,
            MessageInterface::KEY_CONTENT => $content,
            MessageInterface::KEY_SEVERITY => MessageInterface::SEVERITY_RECOVERABLE,
        ]]);

        $cart->setData(self::QUOTE_MESSAGES_KEY, $messages);
    }
}
