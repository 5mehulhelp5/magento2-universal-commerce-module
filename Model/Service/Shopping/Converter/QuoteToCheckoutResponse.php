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

use Magebit\UcpSpec\MutableApi\Schemas\Shopping\FulfillmentCheckoutInterface;
use Magebit\UcpSpec\MutableApi\Schemas\Shopping\FulfillmentCheckoutInterfaceFactory;
use Magebit\UcpSpec\MutableApi\Schemas\Shopping\Types\LineItemResponseInterface;
use Magebit\UcpSpec\MutableApi\Schemas\Shopping\Types\BuyerInterface;
use Magebit\UcpSpec\MutableApi\Schemas\Shopping\Types\TotalResponseInterface;
use Magebit\UcpSpec\MutableApi\Schemas\Shopping\Types\MessageInterface;
use Magebit\UcpSpec\MutableApi\Schemas\Shopping\Types\LinkInterface;
use Magebit\UcpSpec\MutableApi\Schemas\Shopping\PaymentResponseInterface;
use Magebit\UcpSpec\MutableApi\Schemas\Shopping\PaymentResponseInterfaceFactory;
use Magebit\UcpSpec\MutableApi\Schemas\UcpResponseCheckoutInterface;
use Magebit\UniversalCommerce\Api\UniversalCommerceProtocolInterface;
use Magebit\UniversalCommerce\Model\Discovery\ServiceRegistry;
use Magento\Framework\Exception\LocalizedException;
use Magento\Quote\Api\Data\CartInterface;
use Magebit\UcpSpec\MutableApi\Schemas\UcpResponseCheckoutInterfaceFactory;
use Magento\Quote\Model\Quote;
use Magebit\UniversalCommerce\Model\Service\Shopping\Converter\QuoteToTotalsResponse;
use Magebit\UniversalCommerce\Model\Service\Shopping\Converter\QuoteToBuyerResponse;
use Magebit\UniversalCommerce\Api\Service\Shopping\QuoteValidatorInterface;
use Magebit\UniversalCommerce\Model\Service\Shopping\Converter\QuoteToFulfillmentResponse;

class QuoteToCheckoutResponse
{
    /**
     * @param FulfillmentCheckoutInterfaceFactory $checkoutResponseFactory
     * @param QuoteItemToLineItemResponse $quoteItemToLineItemResponse
     * @param UcpResponseCheckoutInterfaceFactory $ucpResponseFactory
     * @param PaymentResponseInterfaceFactory $paymentResponseFactory
     * @param ServiceRegistry $serviceRegistry
     * @param QuoteToTotalsResponse $quoteToTotalsResponse
     * @param QuoteToBuyerResponse $quoteToBuyerResponse
     * @param QuoteValidatorInterface $quoteValidator
     * @param QuoteToFulfillmentResponse $quoteToFulfillmentResponse
     */
    public function __construct(
        protected readonly FulfillmentCheckoutInterfaceFactory $checkoutResponseFactory,
        protected readonly QuoteItemToLineItemResponse $quoteItemToLineItemResponse,
        protected readonly UcpResponseCheckoutInterfaceFactory $ucpResponseFactory,
        protected readonly PaymentResponseInterfaceFactory $paymentResponseFactory,
        protected readonly ServiceRegistry $serviceRegistry,
        protected readonly QuoteToTotalsResponse $quoteToTotalsResponse,
        protected readonly QuoteToBuyerResponse $quoteToBuyerResponse,
        protected readonly QuoteValidatorInterface $quoteValidator,
        protected readonly QuoteToFulfillmentResponse $quoteToFulfillmentResponse
    ) {
    }

    /**
     * @param CartInterface $quote
     * @param string $maskedCartId
     * @return FulfillmentCheckoutInterface
     */
    public function convert(CartInterface $quote, string $maskedCartId): FulfillmentCheckoutInterface
    {
        /** @var FulfillmentCheckoutInterface $response */
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

        $validationErrors = $this->quoteValidator->validate($quote) ?? [];
        $response->setMessages($validationErrors);
        $response->setStatus($this->getStatus($quote, $validationErrors));

        return $response;
    }

    /**
     * @param CartInterface $quote
     * @return UcpResponseCheckoutInterface
     */
    public function getUcp(CartInterface $quote): UcpResponseCheckoutInterface
    {
        $service = $this->serviceRegistry->getService('dev.ucp.shopping');

        if (!$service) {
            throw new LocalizedException(__('Shopping service not registered'));
        }

        return $this->ucpResponseFactory->create([
            'data' => [
                UcpResponseCheckoutInterface::KEY_VERSION => UniversalCommerceProtocolInterface::SPEC_VERSION,
                UcpResponseCheckoutInterface::KEY_CAPABILITIES => $service->getCapabilities(),
            ]
        ]);
    }

    /**
     * @param CartInterface $quote
     * @return PaymentResponseInterface
     */
    public function getPayment(CartInterface $quote): PaymentResponseInterface
    {
        return $this->paymentResponseFactory->create([
            'data' => [
                PaymentResponseInterface::KEY_HANDLERS => [],
                PaymentResponseInterface::KEY_INSTRUMENTS => [],
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
     * @return string
     */
    public function getStatus(CartInterface $quote, array $validationErrors): string
    {
        if (!$quote->getIsActive()) {
            return FulfillmentCheckoutInterface::STATUS_CANCELED;
        }

        if (!empty($validationErrors)) {
            return FulfillmentCheckoutInterface::STATUS_INCOMPLETE;
        }

        return FulfillmentCheckoutInterface::STATUS_READY_FOR_COMPLETE;
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
}
