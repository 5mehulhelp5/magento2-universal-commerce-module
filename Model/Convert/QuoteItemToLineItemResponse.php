<?php

/**
 * This file is part of the Magebit_UniversalCommerce package.
 *
 * @copyright Copyright (c) 2026 Magebit, Ltd. (https://magebit.com/)
 * @author    Magebit <info@magebit.com>
 * @license   MIT
 */

declare(strict_types=1);

namespace Magebit\UniversalCommerce\Model\Convert;

use Magebit\UniversalCommerce\Api\Data\Spec\Response\ItemResponseInterface;
use Magebit\UniversalCommerce\Api\Data\Spec\Response\ItemResponseInterfaceFactory;
use Magebit\UniversalCommerce\Api\Data\Spec\Response\LineItemResponseInterface;
use Magebit\UniversalCommerce\Api\Data\Spec\Response\LineItemResponseInterfaceFactory;
use Magebit\UniversalCommerce\Api\Data\Spec\Response\TotalResponseInterface;
use Magebit\UniversalCommerce\Api\Data\Spec\Response\TotalResponseInterfaceFactory;
use Magebit\UniversalCommerce\Api\Data\Spec\Response\TotalResponseTypeInterface;
use Magento\Catalog\Helper\Image as ImageHelper;
use Magento\Quote\Model\Quote\Item as QuoteItem;

/**
 * Convert Quote Item to Line Item Response
 */
class QuoteItemToLineItemResponse
{
    /**
     * @param LineItemResponseInterfaceFactory $lineItemResponseFactory
     * @param ItemResponseInterfaceFactory $itemResponseFactory
     * @param TotalResponseInterfaceFactory $totalResponseFactory
     * @param ImageHelper $imageHelper
     */
    public function __construct(
        protected readonly LineItemResponseInterfaceFactory $lineItemResponseFactory,
        protected readonly ItemResponseInterfaceFactory $itemResponseFactory,
        protected readonly TotalResponseInterfaceFactory $totalResponseFactory,
        protected readonly ImageHelper $imageHelper,
    ) {
    }

    /**
     * Convert quote item to line item response
     *
     * @param QuoteItem $quoteItem
     * @return LineItemResponseInterface
     */
    public function convert(QuoteItem $quoteItem): LineItemResponseInterface
    {
        $lineItem = $this->lineItemResponseFactory->create();
        $lineItem->setId((string) $quoteItem->getItemId());
        $lineItem->setQuantity((int) $quoteItem->getQty());
        $lineItem->setItem($this->convertItem($quoteItem));
        $lineItem->setTotals($this->convertTotals($quoteItem));

        return $lineItem;
    }

    /**
     * Convert quote item to item response
     *
     * @param QuoteItem $quoteItem
     * @return ItemResponseInterface
     */
    public function convertItem(QuoteItem $quoteItem): ItemResponseInterface
    {
        $product = $quoteItem->getProduct();

        $item = $this->itemResponseFactory->create();
        $item->setId($product->getSku());
        $item->setTitle($product->getName());
        $item->setPrice((float) $quoteItem->getPrice());

        // Get proper product image URL
        $imageUrl = $this->getProductImageUrl($quoteItem);
        if ($imageUrl) {
            $item->setImageUrl($imageUrl);
        }

        return $item;
    }

    /**
     * Convert quote item totals
     *
     * @param QuoteItem $quoteItem
     * @return array<TotalResponseInterface>
     */
    public function convertTotals(QuoteItem $quoteItem): array
    {
        $totals = [];

        // Subtotal (price * quantity before discounts)
        $subtotal = (float) $quoteItem->getRowTotal();
        if ($subtotal > 0) {
            $total = $this->totalResponseFactory->create();
            $total->setType(TotalResponseTypeInterface::TYPE_SUBTOTAL);
            $total->setAmount($subtotal);
            $total->setDisplayText('Subtotal');
            $totals[] = $total;
        }

        // Total (including tax)
        $rowTotal = (float) $quoteItem->getRowTotalInclTax();
        $total = $this->totalResponseFactory->create();
        $total->setType(TotalResponseTypeInterface::TYPE_TOTAL);
        $total->setAmount($rowTotal);
        $total->setDisplayText('Total');
        $totals[] = $total;

        return $totals;
    }

    /**
     * Get product image URL
     *
     * @param QuoteItem $quoteItem
     * @return string|null
     */
    public function getProductImageUrl(QuoteItem $quoteItem): ?string
    {
        $product = $quoteItem->getProduct();

        try {
            $imageUrl = $this->imageHelper
                ->init($product, 'product_base_image')
                ->getUrl();

            return $imageUrl ?: null;
        } catch (\Exception $e) {
            return null;
        }
    }
}
