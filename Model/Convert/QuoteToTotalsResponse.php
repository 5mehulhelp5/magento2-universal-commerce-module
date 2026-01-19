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

use Magebit\UniversalCommerce\Api\Data\Spec\Response\TotalResponseInterface;
use Magebit\UniversalCommerce\Api\Data\Spec\Response\TotalResponseInterfaceFactory;
use Magebit\UniversalCommerce\Helper\PriceConverter;
use Magento\Quote\Api\Data\CartInterface;
use Magento\Quote\Model\Quote;

/**
 * Convert Quote to Totals Response
 */
class QuoteToTotalsResponse
{
    /**
     * @param TotalResponseInterfaceFactory $totalResponseFactory
     * @param PriceConverter $priceConverter
     * @param array<string, string> $typeMapping
     */
    public function __construct(
        private readonly TotalResponseInterfaceFactory $totalResponseFactory,
        private readonly PriceConverter $priceConverter,
        private readonly array $typeMapping = [],
    ) {
    }

    /**
     * Convert quote to totals response array
     *
     * @param CartInterface $cart
     * @return array<TotalResponseInterface>
     */
    public function convert(CartInterface $cart): array
    {
        /** @var Quote $cart */
        $totals = [];

        foreach ($cart->getTotals() as $cartTotal) {
            /** @var TotalResponseInterface $total */
            $total = $this->totalResponseFactory->create();

            $total->setType($this->getType($cartTotal->getCode()));
            $total->setDisplayText((string) $cartTotal->getTitle());
            $total->setAmount($this->priceConverter->toCents((float) $cartTotal->getValue()));

            $totals[] = $total;
        }

        return $totals;
    }

    /**
     * Map Magento total code to UCP type
     *
     * @param string $magentoCode
     * @return string
     */
    private function getType(string $magentoCode): string
    {
        return $this->typeMapping[$magentoCode] ?? $magentoCode;
    }
}
