<?php

/**
 * @author Magebit <info@magebit.com>
 * @copyright Copyright (c) Magebit, Ltd. (https://magebit.com)
 * @license https://magebit.com/code-license
 */

declare(strict_types=1);

namespace Magebit\UniversalCommerce\Model\Convert;

use Magebit\UcpSpec\MutableApi\Schemas\Shopping\Types\BuyerInterface;
use Magebit\UcpSpec\MutableApi\Schemas\Shopping\Types\BuyerInterfaceFactory;
use Magento\Quote\Model\Quote;

/**
 * Convert Quote to Buyer
 */
class QuoteToBuyer
{
    /**
     * @param BuyerInterfaceFactory $buyerFactory
     */
    public function __construct(
        protected readonly BuyerInterfaceFactory $buyerFactory
    ) {
    }

    /**
     * Convert quote to buyer object
     *
     * @param Quote $quote
     * @return BuyerInterface|null
     */
    public function convert(Quote $quote): ?BuyerInterface
    {
        $firstName = $this->getBuyerFirstName($quote);
        $lastName = $this->getBuyerLastName($quote);
        $email = $this->getBuyerEmail($quote);

        // Return null if we don't have minimum required information
        if (!$firstName || !$lastName || !$email) {
            return null;
        }

        /** @var BuyerInterface $buyer */
        $buyer = $this->buyerFactory->create();
        $buyer->setFirstName($firstName);
        $buyer->setLastName($lastName);
        $buyer->setEmail($email);

        $phoneNumber = $this->getBuyerPhoneNumber($quote);
        if ($phoneNumber) {
            $buyer->setPhoneNumber($phoneNumber);
        }

        return $buyer;
    }

    /**
     * Get buyer first name from quote
     *
     * @param Quote $quote
     * @return string|null
     */
    protected function getBuyerFirstName(Quote $quote): ?string
    {
        if ($quote->getCustomerFirstname()) {
            return $quote->getCustomerFirstname();
        }

        $shippingAddress = $quote->getShippingAddress();
        if ($shippingAddress && $shippingAddress->getFirstname()) {
            return $shippingAddress->getFirstname();
        }

        return null;
    }

    /**
     * Get buyer last name from quote
     *
     * @param Quote $quote
     * @return string|null
     */
    protected function getBuyerLastName(Quote $quote): ?string
    {
        if ($quote->getCustomerLastname()) {
            return $quote->getCustomerLastname();
        }

        $shippingAddress = $quote->getShippingAddress();
        if ($shippingAddress && $shippingAddress->getLastname()) {
            return $shippingAddress->getLastname();
        }

        return null;
    }

    /**
     * Get buyer email from quote
     *
     * @param Quote $quote
     * @return string|null
     */
    protected function getBuyerEmail(Quote $quote): ?string
    {
        if ($quote->getCustomerEmail()) {
            return $quote->getCustomerEmail();
        }

        $shippingAddress = $quote->getShippingAddress();
        if ($shippingAddress && $shippingAddress->getEmail()) {
            return $shippingAddress->getEmail();
        }

        return null;
    }

    /**
     * Get buyer phone number from quote
     *
     * @param Quote $quote
     * @return string|null
     */
    protected function getBuyerPhoneNumber(Quote $quote): ?string
    {
        $shippingAddress = $quote->getShippingAddress();
        if ($shippingAddress && $shippingAddress->getTelephone()) {
            return $shippingAddress->getTelephone();
        }

        return null;
    }
}
