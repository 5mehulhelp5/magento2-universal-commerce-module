<?php

/**
 * @author Magebit <info@magebit.com>
 * @copyright Copyright (c) Magebit, Ltd. (https://magebit.com)
 * @license https://magebit.com/code-license
 */

declare(strict_types=1);

namespace Magebit\UniversalCommerce\Service;

use Magebit\UcpSpec\MutableApi\Schemas\Shopping\CheckoutCreateRequestInterface;
use Magebit\UcpSpec\MutableApi\Schemas\Shopping\CheckoutUpdateRequestInterface;
use Magebit\UcpSpec\MutableApi\Schemas\Shopping\PaymentDataInterface;
use Magebit\UcpSpec\MutableApi\Schemas\Shopping\Types\BuyerInterface;
use Magebit\UcpSpec\MutableApi\Schemas\Shopping\Types\LineItemCreateRequestInterface;
use Magebit\UcpSpec\MutableApi\Schemas\Shopping\Types\LineItemUpdateRequestInterface;
use Magebit\UcpSpec\MutableApi\Schemas\Shopping\Types\LinkInterface;
use Magebit\UcpSpec\MutableApi\Schemas\Shopping\Types\LinkInterfaceFactory;
use Magebit\UcpSpec\MutableApi\Schemas\Shopping\CheckoutResponseInterface;
use Magebit\UcpSpec\MutableApi\Schemas\Shopping\CheckoutResponseInterfaceFactory;
use Magebit\UcpSpec\MutableApi\Schemas\CapabilityResponseInterfaceFactory;
use Magebit\UcpSpec\MutableApi\Schemas\Shopping\Types\PaymentHandlerResponseInterfaceFactory;
use Magebit\UcpSpec\MutableApi\Schemas\Shopping\PaymentResponseInterface;
use Magebit\UcpSpec\MutableApi\Schemas\Shopping\PaymentResponseInterfaceFactory;
use Magebit\UcpSpec\MutableApi\Schemas\Shopping\PlatformConfigInterface;
use Magebit\UcpSpec\MutableApi\Schemas\Shopping\Types\LineItemResponseInterface;
use Magebit\UcpSpec\MutableApi\Schemas\Shopping\Types\MessageInterface;
use Magebit\UcpSpec\MutableApi\Schemas\Shopping\Types\MessageInterfaceFactory;
use Magebit\UcpSpec\MutableApi\Schemas\UcpResponseCheckoutInterface;
use Magebit\UcpSpec\MutableApi\Schemas\UcpResponseCheckoutInterfaceFactory;
use Magebit\UniversalCommerce\Api\ConfigInterface;
use Magebit\UniversalCommerce\Api\QuoteValidatorInterface;
use Magebit\UniversalCommerce\Model\CheckoutMessageBuilder;
use Magebit\UniversalCommerce\Model\Convert\QuoteItemToLineItemResponse;
use Magebit\UniversalCommerce\Model\Convert\QuoteToBuyer;
use Magebit\UniversalCommerce\Model\Convert\QuoteToTotalsResponse;
use Magebit\UniversalCommerce\Model\Discovery\UcpDiscoveryProfile;
use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Catalog\Model\Product;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Stdlib\DateTime\DateTime;
use Magento\Quote\Api\Data\PaymentInterface;
use Magento\Quote\Api\Data\PaymentInterfaceFactory;
use Magento\Quote\Api\Data\CartInterface;
use Magento\Quote\Api\GuestCartManagementInterface;
use Magento\Quote\Api\GuestCartRepositoryInterface;
use Magento\Quote\Model\Quote;
use Magento\Quote\Api\CartRepositoryInterface;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Sales\Api\OrderRepositoryInterface;
use Magento\Framework\UrlInterface;
use Magebit\UcpSpec\MutableApi\Schemas\Shopping\Types\OrderConfirmationInterfaceFactory;
use Magebit\UniversalCommerce\Api\Webhook\WebhookNotifierInterface;
use Magebit\UniversalCommerce\Model\Data\Spec\Schemas\Shopping\CheckoutResponse;

class CheckoutService
{
    /**
     * @param GuestCartManagementInterface $guestCartManagement
     * @param CheckoutResponseInterfaceFactory $checkoutResponseFactory
     * @param GuestCartRepositoryInterface $guestCartRepository
     * @param ProductRepositoryInterface $productRepository
     * @param QuoteItemToLineItemResponse $quoteItemConverter
     * @param QuoteToBuyer $quoteToBuyerConverter
     * @param QuoteToTotalsResponse $totalsConverter
     * @param CartRepositoryInterface $cartRepository
     * @param UcpDiscoveryProfile $ucpDiscoveryProfile
     * @param UcpResponseCheckoutInterfaceFactory $ucpResponseCheckoutFactory
     * @param CapabilityResponseInterfaceFactory $capabilityFactory
     * @param PaymentResponseInterfaceFactory $paymentResponseFactory
     * @param PaymentHandlerResponseInterfaceFactory $paymentHandlerResponseFactory
     * @param ConfigInterface $config
     * @param LinkInterfaceFactory $linkFactory
     * @param DateTime $dateTime
     * @param StoreManagerInterface $storeManager
     * @param QuoteValidatorInterface $quoteValidator
     * @param CheckoutMessageBuilder $messageBuilder
     * @param PaymentInterfaceFactory $paymentFactory
     * @param MessageInterfaceFactory $messageFactory
     * @param OrderRepositoryInterface $orderRepository
     * @param UrlInterface $urlBuilder
     * @param OrderConfirmationInterfaceFactory $orderConfirmationFactory
     * @param WebhookNotifierInterface $webhookNotifier
     */
    public function __construct(
        protected readonly GuestCartManagementInterface $guestCartManagement,
        protected readonly CheckoutResponseInterfaceFactory $checkoutResponseFactory,
        protected readonly GuestCartRepositoryInterface $guestCartRepository,
        protected readonly ProductRepositoryInterface $productRepository,
        protected readonly QuoteItemToLineItemResponse $quoteItemConverter,
        protected readonly QuoteToBuyer $quoteToBuyerConverter,
        protected readonly QuoteToTotalsResponse $totalsConverter,
        protected readonly CartRepositoryInterface $cartRepository,
        protected readonly UcpDiscoveryProfile $ucpDiscoveryProfile,
        protected readonly UcpResponseCheckoutInterfaceFactory $ucpResponseCheckoutFactory,
        protected readonly CapabilityResponseInterfaceFactory $capabilityFactory,
        protected readonly PaymentResponseInterfaceFactory $paymentResponseFactory,
        protected readonly PaymentHandlerResponseInterfaceFactory $paymentHandlerResponseFactory,
        protected readonly ConfigInterface $config,
        protected readonly LinkInterfaceFactory $linkFactory,
        protected readonly DateTime $dateTime,
        protected readonly StoreManagerInterface $storeManager,
        protected readonly QuoteValidatorInterface $quoteValidator,
        protected readonly CheckoutMessageBuilder $messageBuilder,
        protected readonly PaymentInterfaceFactory $paymentFactory,
        protected readonly MessageInterfaceFactory $messageFactory,
        protected readonly OrderRepositoryInterface $orderRepository,
        protected readonly UrlInterface $urlBuilder,
        protected readonly OrderConfirmationInterfaceFactory $orderConfirmationFactory,
        protected readonly WebhookNotifierInterface $webhookNotifier
    ) {
    }

    /**
     * Create checkout session
     *
     * @param CheckoutCreateRequestInterface $request
     * @param PlatformConfigInterface|null $platformConfig
     * @return CheckoutResponseInterface
     */
    public function createCheckout(CheckoutCreateRequestInterface $request, ?PlatformConfigInterface $platformConfig = null): CheckoutResponseInterface
    {
        $maskedCartId = $this->guestCartManagement->createEmptyCart();
        $cart = $this->guestCartRepository->get($maskedCartId);

        // Process buyer information if provided
        if ($request->getBuyer()) {
            $this->addBuyerToCart($cart, $request->getBuyer());
        }

        // Add items to cart
        $this->addItemsToCart($cart, $request->getLineItems());

        /** @var Quote $cart */
        $cart->collectTotals();
        $this->cartRepository->save($cart);

        return $this->buildCheckoutResponse($cart, $maskedCartId);
    }

    /**
     * Get checkout session by ID
     *
     * @param string $sessionId
     * @return CheckoutResponseInterface
     */
    public function getCheckout(string $sessionId): CheckoutResponseInterface
    {
        $cart = $this->guestCartRepository->get($sessionId);

        /** @var Quote $cart */
        $cart->collectTotals();

        return $this->buildCheckoutResponse($cart, $sessionId);
    }

    /**
     * Update checkout session
     *
     * @param string $sessionId
     * @param CheckoutUpdateRequestInterface $request
     * @return CheckoutResponseInterface
     */
    public function updateCheckout(string $sessionId, CheckoutUpdateRequestInterface $request): CheckoutResponseInterface
    {
        $cart = $this->guestCartRepository->get($sessionId);

        if ($request->getBuyer()) {
            $this->addBuyerToCart($cart, $request->getBuyer());
        }

        $this->addItemsToCart($cart, $request->getLineItems());

        /** @var Quote $cart */
        $cart->collectTotals();
        $this->cartRepository->save($cart);

        return $this->buildCheckoutResponse($cart, $sessionId);
    }

    /**
     * Cancel checkout session
     *
     * @param string $sessionId
     * @return CheckoutResponseInterface
     */
    public function cancelCheckout(string $sessionId): CheckoutResponseInterface
    {
        $cart = $this->guestCartRepository->get($sessionId);

        /** @var Quote $cart */
        if (!$cart->getIsActive()) {
            if ($cart->getReservedOrderId() !== null) {
                throw new LocalizedException(__('Order is already placed. Please contact support to cancel the order'));
            }

            throw new LocalizedException(__('Cart is already canceled'));
        }

        $cart->setIsActive(false);
        $this->cartRepository->save($cart);

        return $this->buildCheckoutResponse($cart, $sessionId);
    }

    /**
     * Complete checkout session and place order
     *
     * @param string $sessionId
     * @param PaymentDataInterface $paymentData
     * @param PlatformConfigInterface|null $platformConfig
     * @return CheckoutResponseInterface
     */
    public function completeCheckout(
        string $sessionId,
        PaymentDataInterface $paymentData,
        ?PlatformConfigInterface $platformConfig = null
    ): CheckoutResponseInterface {
        $cart = $this->guestCartRepository->get($sessionId);

        /** @var Quote $cart */
        if (!$cart->getIsActive()) {
            if ($cart->getReservedOrderId() !== null) {
                throw new LocalizedException(__('Order is already placed'));
            }
            throw new LocalizedException(__('Cart is not active. Please create a new checkout session'));
        }

        $paymentInstrument = $paymentData->getPaymentData();
        $handlerId = $paymentInstrument->getHandlerId();
        if (!$handlerId) {
            throw new LocalizedException(__('Payment method is required'));
        }

        // Validate cart before placing order
        $validationMessages = $this->quoteValidator->validate($cart);

        if (!empty($validationMessages)) {
            $errorMessages = array_map(function ($message) {
                return $message->getContent();
            }, $validationMessages);
            throw new LocalizedException(
                __('Cannot complete checkout: %1', implode(', ', $errorMessages))
            );
        }

        $payment = $this->paymentFactory->create();
        $payment->setMethod($handlerId);

        $this->cartRepository->save($cart);

        // Place order and capture order ID
        $orderId = $this->guestCartManagement->placeOrder($sessionId, $payment);

        // Retrieve the created order
        $order = $this->orderRepository->get($orderId);

        // Build order permalink URL
        $orderPermalinkUrl = $this->urlBuilder->getUrl(
            'sales/order/view',
            ['order_id' => $orderId]
        );

        // Create OrderConfirmation object
        $orderConfirmation = $this->orderConfirmationFactory->create();
        $orderConfirmation->setId((string) $orderId);
        $orderConfirmation->setPermalinkUrl($orderPermalinkUrl);

        /** @var CheckoutResponse $response */
        $response = $this->buildCheckoutResponse($cart, $sessionId);
        $response->setStatus(CheckoutResponseInterface::STATUS_COMPLETED);

        // Set order confirmation (UCP spec field)
        $response->setOrder($orderConfirmation);

        // Set custom fields (not in UCP spec, for convenience)
        $response->setOrderId((string) $orderId);
        $response->setOrderPermalinkUrl($orderPermalinkUrl);

        // Send webhook notification if webhook URL is available
        if ($platformConfig && $platformConfig->getWebhookUrl()) {
            $this->webhookNotifier->notify(
                $platformConfig->getWebhookUrl(),
                'order_placed',
                $sessionId,
                [
                    'id' => (string) $orderId,
                    'permalink_url' => $orderPermalinkUrl,
                ]
            );
        }

        return $response;
    }

    /**
     * Build checkout response from cart
     *
     * @param CartInterface $cart
     * @param string $sessionId
     * @return CheckoutResponseInterface
     */
    private function buildCheckoutResponse(CartInterface $cart, string $sessionId): CheckoutResponseInterface
    {
        /** @var CheckoutResponseInterface $response */
        $response = $this->checkoutResponseFactory->create();
        $response->setId($sessionId);
        $response->setUcp($this->buildUcpResponse());

        /** @var string $currency */
        $currency = $cart->getCurrency()?->getStoreCurrencyCode();
        $response->setCurrency($currency);

        // Set buyer information
        $buyer = $this->quoteToBuyerConverter->convert($cart);

        if ($buyer) {
            $response->setBuyer($buyer);
        }

        // Set line items and totals
        $response->setLineItems($this->buildLineItems($cart));
        $response->setTotals($this->totalsConverter->convert($cart));

        // Set payment
        $response->setPayment($this->buildPaymentResponse($cart));

        // Set links
        $response->setLinks($this->buildLinks());

        // Set expires_at
        $response->setExpiresAt($this->calculateExpiryTime());

        // Validate cart - validators now return messages directly
        $messages = $this->quoteValidator->validate($cart);

        // Add any additional messages from cart state
        $additionalMessages = $this->messageBuilder->buildMessages($cart, []);
        if (!empty($additionalMessages)) {
            $messages = array_merge($messages, $additionalMessages);
        }

        if (!empty($messages)) {
            $response->setMessages($messages);
        }

        // Set status based on validation messages
        $status = $this->determineStatus($cart, $messages);
        $response->setStatus($status);

        // Set continue_url ONLY when status is requires_escalation (MUST per UCP spec)
        // or optionally for other non-terminal statuses
        if ($status === CheckoutResponseInterface::STATUS_REQUIRES_ESCALATION) {
            $continueUrl = $this->buildContinueUrl($sessionId);
            if ($continueUrl) {
                $response->setContinueUrl($continueUrl);
            }
        } elseif ($status !== CheckoutResponseInterface::STATUS_COMPLETED &&
                  $status !== CheckoutResponseInterface::STATUS_CANCELED) {
            // Optionally provide continue_url for other non-terminal statuses
            $continueUrl = $this->buildContinueUrl($sessionId);
            if ($continueUrl) {
                $response->setContinueUrl($continueUrl);
            }
        }

        return $response;
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
     * Build line items from cart
     *
     * @param CartInterface $cart
     * @return array<LineItemResponseInterface>
     */
    public function buildLineItems(CartInterface $cart): array
    {
        /** @var Quote $cart */
        $lineItems = [];
        foreach ($cart->getAllItems() as $quoteItem) {
            $lineItems[] = $this->quoteItemConverter->convert($quoteItem);
        }

        return $lineItems;
    }

    /**
     * Build UCP response
     *
     * @return UcpResponseCheckoutInterface
     */
    public function buildUcpResponse(): UcpResponseCheckoutInterface
    {
        $ucpResponse = $this->ucpResponseCheckoutFactory->create();

        $capabilities = array_map(function (array $capability) {
            return $this->capabilityFactory->create([
                'data'=> $capability
            ]);
        }, $this->ucpDiscoveryProfile->getCapabilities());

        $ucpResponse->setCapabilities($capabilities);
        $ucpResponse->setVersion($this->ucpDiscoveryProfile->getVersion());

        return $ucpResponse;
    }

    /**
     * Build payment response
     *
     * @param CartInterface $cart
     * @return PaymentResponseInterface
     */
    public function buildPaymentResponse(CartInterface $cart): PaymentResponseInterface
    {
        $paymentResponse = $this->paymentResponseFactory->create();

        // Get handlers filtered by quote availability
        $handlers = array_map(function ($handler) {
            $handlerResponse = $this->paymentHandlerResponseFactory->create([
                'data'=> $handler
            ]);

            return $handlerResponse;
        }, $this->ucpDiscoveryProfile->getPaymentHandlers($cart));

        $paymentResponse->setHandlers($handlers);

        return $paymentResponse;
    }

    /**
     * Add buyer information to cart
     *
     * @param CartInterface $cart
     * @param BuyerInterface $buyer
     * @return void
     */
    protected function addBuyerToCart(CartInterface $cart, BuyerInterface $buyer): void
    {
        /** @var Quote $cart */
        if ($firstName = $buyer->getFirstName()) {
            $cart->setCustomerFirstname($firstName);
        }

        if ($lastName = $buyer->getLastName()) {
            $cart->setCustomerLastname($lastName);
        }

        if ($email = $buyer->getEmail()) {
            $cart->setCustomerEmail($email);
            $cart->getShippingAddress()->setEmail($email);
        }

        if ($phoneNumber = $buyer->getPhoneNumber()) {
            $cart->getShippingAddress()->setTelephone($phoneNumber);
        }
    }

    /**
     * Build links from configuration
     *
     * @return array<LinkInterface>
     */
    protected function buildLinks(): array
    {
        $linksConfig = $this->config->getCheckoutSessionLinks();

        return array_map(function (array $link): LinkInterface {
            $linkData = [
                'type' => $link['type'],
                'url' => $link['url']
            ];

            if (isset($link['title']) && !empty($link['title'])) {
                $linkData['title'] = $link['title'];
            }

            return $this->linkFactory->create(['data' => $linkData]);
        }, $linksConfig);
    }

    /**
     * Calculate expiry time for checkout session
     *
     * @return string RFC 3339 timestamp
     */
    protected function calculateExpiryTime(): string
    {
        $ttl = $this->config->getCheckoutSessionTtl();
        $expiryTimestamp = $this->dateTime->gmtTimestamp() + $ttl;

        return date('c', $expiryTimestamp);
    }

    /**
     * Build continue URL for checkout session
     *
     * @param string $sessionId
     * @return string|null
     */
    protected function buildContinueUrl(string $sessionId): ?string
    {
        $baseUrl = $this->config->getContinueUrlBase();

        if (empty($baseUrl)) {
            return null;
        }

        // Append session ID to base URL
        return rtrim($baseUrl, '/') . '/' . $sessionId;
    }

    /**
     * Determine checkout status based on messages
     *
     * @param CartInterface $quote
     * @param array<MessageInterface> $messages
     * @return string
     */
    protected function determineStatus(CartInterface $quote, array $messages): string
    {
        /** @var Quote $quote */

        if (!$quote->getIsActive()) {
            if ($quote->getReservedOrderId() !== null) {
                return CheckoutResponseInterface::STATUS_COMPLETED;
            }

            return CheckoutResponseInterface::STATUS_CANCELED;
        }

        if (!empty($messages)) {
            // foreach ($messages as $message) {
            //     $severity = $message->getSeverity();

            //     if ($severity === MessageInterface::SEVERITY_REQUIRES_BUYER_INPUT ||
            //         $severity === MessageInterface::SEVERITY_REQUIRES_BUYER_REVIEW) {
            //         return CheckoutResponseInterface::STATUS_REQUIRES_ESCALATION;
            //     }
            // }

            return CheckoutResponseInterface::STATUS_INCOMPLETE;
        }

        // No errors - ready for completion
        return CheckoutResponseInterface::STATUS_READY_FOR_COMPLETE;
    }
}
