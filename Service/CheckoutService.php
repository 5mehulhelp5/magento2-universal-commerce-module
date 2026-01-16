<?php


/**
 * This file is part of the Magebit_UniversalCommerce package.
 *
 * @copyright Copyright (c) 2026 Magebit, Ltd. (https://magebit.com/)
 * @author    Magebit <info@magebit.com>
 * @license   MIT
 */

declare(strict_types=1);

namespace Magebit\UniversalCommerce\Service;

use Magebit\UniversalCommerce\Api\Data\Spec\CheckoutCreateRequestInterface;
use Magebit\UniversalCommerce\Api\Data\Spec\LineItemCreateRequestInterface;
use Magebit\UniversalCommerce\Api\Data\Spec\Response\CheckoutResponseInterface;
use Magebit\UniversalCommerce\Api\Data\Spec\Response\CheckoutResponseInterfaceFactory;
use Magebit\UniversalCommerce\Api\Data\Spec\Response\CheckoutResponseStatusInterface;
use Magebit\UniversalCommerce\Api\Data\Spec\Response\CapabilityResponseInterfaceFactory;
use Magebit\UniversalCommerce\Api\Data\Spec\Response\PlatformConfigInterface;
use Magebit\UniversalCommerce\Api\Data\Spec\Response\LineItemResponseInterface;
use Magebit\UniversalCommerce\Api\Data\Spec\Response\UcpCheckoutResponseInterface;
use Magebit\UniversalCommerce\Api\Data\Spec\Response\UcpCheckoutResponseInterfaceFactory;
use Magebit\UniversalCommerce\Model\Convert\QuoteItemToLineItemResponse;
use Magebit\UniversalCommerce\Model\Convert\QuoteToTotalsResponse;
use Magebit\UniversalCommerce\Model\Discovery\UcpDiscoveryProfile;
use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Catalog\Model\Product;
use Magento\Quote\Api\Data\CartInterface;
use Magento\Quote\Api\GuestCartManagementInterface;
use Magento\Quote\Api\GuestCartRepositoryInterface;
use Magento\Quote\Model\Quote;
use Magento\Quote\Api\CartRepositoryInterface;

class CheckoutService
{
    public function __construct(
        protected readonly GuestCartManagementInterface $guestCartManagement,
        protected readonly CheckoutResponseInterfaceFactory $checkoutResponseFactory,
        protected readonly GuestCartRepositoryInterface $guestCartRepository,
        protected readonly ProductRepositoryInterface $productRepository,
        protected readonly QuoteItemToLineItemResponse $quoteItemConverter,
        protected readonly QuoteToTotalsResponse $totalsConverter,
        protected readonly CartRepositoryInterface $cartRepository,
        protected readonly UcpDiscoveryProfile $ucpDiscoveryProfile,
        protected readonly UcpCheckoutResponseInterfaceFactory $ucpCheckoutResponseFactory,
        protected readonly CapabilityResponseInterfaceFactory $capabilityFactory,
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

        /** @var CheckoutResponseInterface $response */
        $response = $this->checkoutResponseFactory->create();
        $response->setId($maskedCartId);
        $response->setUcp($this->buildUcpResponse());
        $response->setStatus(CheckoutResponseStatusInterface::STATUS_INCOMPLETE);

        /** @var string $currency */
        $currency = $cart->getCurrency()?->getStoreCurrencyCode();

        $response->setCurrency($currency);
        $response->setLinks([]);
        $response->setPlatform($platformConfig);

        $this->addItemsToCart($cart, $request->getLineItems());

        $this->cartRepository->save($cart);

        $response->setLineItems($this->buildLineItems($cart));
        $response->setTotals($this->totalsConverter->convert($cart));

        return $response;
    }

    /**
     * Add items to cart
     *
     * @param CartInterface $cart
     * @param array<LineItemCreateRequestInterface> $lineItems
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
        $lineItems = [];
        /** @var Quote $cart */
        foreach ($cart->getAllItems() as $quoteItem) {
            $lineItems[] = $this->quoteItemConverter->convert($quoteItem);
        }

        return $lineItems;
    }

    /**
     * Build UCP response
     *
     * @return UcpCheckoutResponseInterface
     */
    public function buildUcpResponse(): UcpCheckoutResponseInterface
    {
        $ucpResponse = $this->ucpCheckoutResponseFactory->create();

        $capabilities = array_map(function (array $capability) {
            return $this->capabilityFactory->create([
                'data'=> $capability
            ]);
        }, $this->ucpDiscoveryProfile->getCapabilities());

        $ucpResponse->setCapabilities($capabilities);
        $ucpResponse->setVersion($this->ucpDiscoveryProfile->getVersion());

        return $ucpResponse;
    }
}
