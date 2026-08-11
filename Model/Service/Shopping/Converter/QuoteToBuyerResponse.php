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

use Magebit\UcpSpec\Api\Shopping\Types\BuyerInterface;
use Magebit\UcpSpec\Api\Shopping\Types\BuyerInterfaceFactory;
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
        $billingAddress = $quote->getBillingAddress();

        $firstName = $quote->getCustomerFirstname() ?: $billingAddress->getFirstname();
        $lastName = $quote->getCustomerLastname() ?: $billingAddress->getLastname();
        $email = $quote->getCustomerEmail() ?: $billingAddress->getEmail();
        $phoneNumber = $billingAddress->getTelephone();

        // An all-empty buyer is omitted rather than sent as an empty object.
        if (!$firstName && !$lastName && !$email && !$phoneNumber) {
            return null;
        }

        /** @var BuyerInterface $buyer */
        $buyer = $this->buyerInterfaceFactory->create();

        if ($firstName) {
            $buyer->setFirstName($firstName);
        }

        if ($lastName) {
            $buyer->setLastName($lastName);
        }

        if ($email) {
            $buyer->setEmail($email);
        }

        if ($phoneNumber) {
            $buyer->setPhoneNumber($phoneNumber);
        }

        return $buyer;
    }
}
