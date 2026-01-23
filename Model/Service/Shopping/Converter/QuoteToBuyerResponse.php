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

use Magebit\AgenticCommerce\Model\Data\Buyer;
use Magebit\UcpSpec\MutableApi\Schemas\Shopping\Types\BuyerInterface;
use Magebit\UcpSpec\MutableApi\Schemas\Shopping\Types\BuyerInterfaceFactory;
use Magento\Quote\Api\Data\CartInterface;
use Magento\Quote\Model\Quote;

class QuoteToBuyerResponse
{
    /**
     * @param BuyerInterfaceFactory $buyerInterfaceFactory
     */
    public function __construct(
        protected readonly BuyerInterfaceFactory $buyerInterfaceFactory,
    ) {
    }

    /**
     * @param CartInterface $quote
     * @return BuyerInterface|null
     */
    public function convert(CartInterface $quote): ?BuyerInterface
    {
        /** @var Quote $quote */
        /** @var BuyerInterface $buyer */
        $buyer = $this->buyerInterfaceFactory->create();

        if ($quote->getCustomerFirstname()) {
            $buyer->setFirstName($quote->getCustomerFirstname());
        }

        if ($quote->getCustomerLastname()) {
            $buyer->setLastName($quote->getCustomerLastname());
        }

        if ($quote->getCustomerEmail()) {
            $buyer->setEmail($quote->getCustomerEmail());
        }

        if ($quote->getBillingAddress()->getTelephone()) {
            $buyer->setPhoneNumber($quote->getBillingAddress()->getTelephone());
        }

        /** @var Buyer $buyer */
        if ($buyer->isEmpty()) {
            return null;
        }

        return $buyer;
    }
}
