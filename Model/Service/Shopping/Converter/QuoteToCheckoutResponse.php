<?php

/**
 * This file is part of the Magebit_UniversalCommerce package.
 *
 * @copyright Copyright (c) 2026 Magebit, Ltd. (https://magebit.com/)
 * @author    Magebit <info@magebit.com>
 * @license   MIT
 */

declare(strict_types=1);

namespace Magebit\UniversalCommerce\Model\Service\Shopping\Converter;

use Magebit\UniversalCommerce\Api\Service\Shopping\CheckoutResponseInterface;
use Magebit\UniversalCommerce\Api\Service\Shopping\CheckoutResponseInterfaceFactory;
use Magebit\UcpSpec\Api\Shopping\Types\LineItemResponseInterface;
use Magebit\UcpSpec\Api\Shopping\Types\BuyerInterface;
use Magebit\UcpSpec\Api\Shopping\Types\TotalResponseInterface;
use Magebit\UcpSpec\Api\Shopping\Types\MessageInterface;
use Magebit\UcpSpec\Api\Shopping\Types\LinkInterface;
use Magebit\UcpSpec\Api\Shopping\PaymentInterface;
use Magebit\UcpSpec\Api\Shopping\PaymentInterfaceFactory;
use Magebit\UcpSpec\Api\UcpResponseCheckoutSchemaInterface;
use Magebit\UniversalCommerce\Api\UniversalCommerceProtocolInterface;
use Magebit\UniversalCommerce\Model\Discovery\ServiceRegistry;
use Magento\Framework\Exception\LocalizedException;
use Magento\Quote\Api\Data\CartInterface;
use Magebit\UcpSpec\Api\UcpResponseCheckoutSchemaInterfaceFactory;
use Magento\Quote\Model\Quote;
use Magebit\UniversalCommerce\Model\Service\Shopping\Converter\QuoteToTotalsResponse;
use Magebit\UniversalCommerce\Model\Service\Shopping\Converter\QuoteToBuyerResponse;
use Magebit\UniversalCommerce\Api\Service\Shopping\QuoteValidatorInterface;
use Magebit\UniversalCommerce\Model\Service\Shopping\Converter\QuoteToFulfillmentResponse;
use Magebit\UniversalCommerce\Model\Service\Shopping\Converter\QuoteToDiscountResponse;
use Magebit\UniversalCommerce\Api\CheckoutMetaRepositoryInterface;
use Magebit\UniversalCommerce\Model\Config;
use Magebit\UcpSpec\Api\Shopping\Types\OrderConfirmationInterface;
use Magebit\UcpSpec\Api\Shopping\Types\OrderConfirmationInterfaceFactory;
use Magento\Sales\Api\OrderRepositoryInterface;
use Magento\Framework\Exception\NoSuchEntityException;

class QuoteToCheckoutResponse
{
    /**
     * @param CheckoutResponseInterfaceFactory $checkoutResponseFactory
     * @param QuoteItemToLineItemResponse $quoteItemToLineItemResponse
     * @param UcpResponseCheckoutSchemaInterfaceFactory $ucpResponseFactory
     * @param PaymentInterfaceFactory $paymentFactory
     * @param ServiceRegistry $serviceRegistry
     * @param QuoteToTotalsResponse $quoteToTotalsResponse
     * @param QuoteToBuyerResponse $quoteToBuyerResponse
     * @param QuoteValidatorInterface $quoteValidator
     * @param QuoteToFulfillmentResponse $quoteToFulfillmentResponse
     * @param QuoteToDiscountResponse $quoteToDiscountResponse
     * @param CheckoutMetaRepositoryInterface $checkoutMetaRepository
     * @param OrderConfirmationInterfaceFactory $orderConfirmationFactory
     * @param OrderRepositoryInterface $orderRepository
     * @param Config $config
     */
    public function __construct(
        protected readonly CheckoutResponseInterfaceFactory $checkoutResponseFactory,
        protected readonly QuoteItemToLineItemResponse $quoteItemToLineItemResponse,
        protected readonly UcpResponseCheckoutSchemaInterfaceFactory $ucpResponseFactory,
        protected readonly PaymentInterfaceFactory $paymentFactory,
        protected readonly ServiceRegistry $serviceRegistry,
        protected readonly QuoteToTotalsResponse $quoteToTotalsResponse,
        protected readonly QuoteToBuyerResponse $quoteToBuyerResponse,
        protected readonly QuoteValidatorInterface $quoteValidator,
        protected readonly QuoteToFulfillmentResponse $quoteToFulfillmentResponse,
        protected readonly QuoteToDiscountResponse $quoteToDiscountResponse,
        protected readonly CheckoutMetaRepositoryInterface $checkoutMetaRepository,
        protected readonly OrderConfirmationInterfaceFactory $orderConfirmationFactory,
        protected readonly OrderRepositoryInterface $orderRepository,
        protected readonly Config $config
    ) {
    }

    /**
     * @param CartInterface $quote
     * @param string $maskedCartId
     * @return CheckoutResponseInterface
     */
    public function convert(CartInterface $quote, string $maskedCartId): CheckoutResponseInterface
    {
        /** @var CheckoutResponseInterface $response */
        $response = $this->checkoutResponseFactory->create();
        $response->setId($maskedCartId);

        $response->setLineItems($this->getLineItems($quote));

        if ($buyer = $this->getBuyer($quote)) {
            $response->setBuyer($buyer);
        }

        $response->setUcp($this->getUcp($quote));
        $response->setCurrency($this->getCurrency($quote));
        $response->setTotals($this->getTotals($quote));
        $response->setLinks($this->getLinks($quote));
        $response->setPayment($this->getPayment($quote));

        if ($fulfillment = $this->quoteToFulfillmentResponse->convert($quote)) {
            $response->setFulfillment($fulfillment);
        }

        if ($discounts = $this->quoteToDiscountResponse->convert($quote)) {
            $response->setDiscounts($discounts);
        }

        $order = $this->getOrder($maskedCartId);

        if ($order) {
            $response->setOrder($order);
        }

        $validationErrors = $order ? [] : ($this->quoteValidator->validate($quote) ?? []);
        $response->setMessages($validationErrors);
        $response->setStatus($this->getStatus($quote, $validationErrors, $order !== null));

        return $response;
    }

    /**
     * @param CartInterface $quote
     * @return UcpResponseCheckoutSchemaInterface
     */
    public function getUcp(CartInterface $quote): UcpResponseCheckoutSchemaInterface
    {
        $service = $this->serviceRegistry->getService('dev.ucp.shopping');

        if (!$service) {
            throw new LocalizedException(__('Shopping service not registered'));
        }

        return $this->ucpResponseFactory->create([
            'data' => [
                UcpResponseCheckoutSchemaInterface::KEY_VERSION => UniversalCommerceProtocolInterface::SPEC_VERSION,
                UcpResponseCheckoutSchemaInterface::KEY_CAPABILITIES => $service->getCapabilities(),
                UcpResponseCheckoutSchemaInterface::KEY_PAYMENT_HANDLERS => [],
            ]
        ]);
    }

    /**
     * @param CartInterface $quote
     * @return PaymentInterface
     */
    public function getPayment(CartInterface $quote): PaymentInterface
    {
        return $this->paymentFactory->create([
            'data' => [
                PaymentInterface::KEY_INSTRUMENTS => [],
            ]
        ]);
    }

    /**
     * @param CartInterface $quote
     * @return LineItemResponseInterface[]
     */
    public function getLineItems(CartInterface $quote): array
    {
        /** @var Quote $quote */
        $lineItems = [];

        foreach ($quote->getAllItems() as $item) {
            $lineItems[] = $this->quoteItemToLineItemResponse->convert($item);
        }

        return $lineItems;
    }

    /**
     * @param CartInterface $quote
     * @return BuyerInterface|null
     */
    public function getBuyer(CartInterface $quote): ?BuyerInterface
    {
        return $this->quoteToBuyerResponse->convert($quote);
    }

    /**
     * @param CartInterface $quote
     * @param MessageInterface[] $validationErrors
     * @param bool $hasOrder
     * @return string
     */
    public function getStatus(CartInterface $quote, array $validationErrors, bool $hasOrder = false): string
    {
        // Placing an order deactivates the quote, so order state must win over quote state.
        if ($hasOrder) {
            return CheckoutResponseInterface::STATUS_COMPLETED;
        }

        if (!$quote->getIsActive()) {
            return CheckoutResponseInterface::STATUS_CANCELED;
        }

        if (!empty($validationErrors)) {
            return CheckoutResponseInterface::STATUS_INCOMPLETE;
        }

        return CheckoutResponseInterface::STATUS_READY_FOR_COMPLETE;
    }

    /**
     * @param CartInterface $quote
     * @return string
     */
    public function getCurrency(CartInterface $quote): string
    {
        $currency = $quote->getCurrency()?->getStoreCurrencyCode();
        return $currency ?? 'USD';
    }

    /**
     * @param CartInterface $quote
     * @return TotalResponseInterface[]
     */
    public function getTotals(CartInterface $quote): array
    {
        return $this->quoteToTotalsResponse->convert($quote);
    }

    /**
     * @param CartInterface $quote
     * @return LinkInterface[]
     */
    public function getLinks(CartInterface $quote): array
    {
        return [];
    }

    /**
     * @param string $checkoutId
     * @return OrderConfirmationInterface|null
     */
    protected function getOrder(string $checkoutId): ?OrderConfirmationInterface
    {
        try {
            $orderId = $this->checkoutMetaRepository->getByCheckoutId($checkoutId)->getOrderId();
        } catch (NoSuchEntityException $exception) {
            return null;
        }

        if (!$orderId) {
            return null;
        }

        try {
            $order = $this->orderRepository->get($orderId);
        } catch (NoSuchEntityException $exception) {
            return null;
        }

        /** @var OrderConfirmationInterface $confirmation */
        $confirmation = $this->orderConfirmationFactory->create();
        $confirmation->setId((string) $order->getIncrementId());
        $confirmation->setPermalinkUrl(
            $this->config->getApiBaseUrl((int) $order->getStoreId())
            . '/sales/order/view/order_id/' . $orderId
        );

        return $confirmation;
    }
}
