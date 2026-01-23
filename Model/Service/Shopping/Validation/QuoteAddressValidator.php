<?php

/**
 * This file is part of the Magebit_UniversalCommerce package.
 *
 * @copyright Copyright (c) 2026 Magebit, Ltd. (https://magebit.com/)
 * @author    Magebit <info@magebit.com>
 * @license   MIT
 */

namespace Magebit\UniversalCommerce\Model\Service\Shopping\Validation;

use Magebit\UniversalCommerce\Api\Service\Shopping\QuoteValidatorInterface;
use Magento\Quote\Api\Data\CartInterface;
use Magento\Quote\Model\Quote;
use Magebit\UcpSpec\MutableApi\Schemas\Shopping\Types\MessageInterface;
use Magebit\UcpSpec\MutableApi\Schemas\Shopping\Types\MessageInterfaceFactory;

class QuoteAddressValidator implements QuoteValidatorInterface
{
    /**
     * @param MessageInterfaceFactory $messageFactory
     */
    public function __construct(
        protected readonly MessageInterfaceFactory $messageFactory
    ) {
    }

    /**
     * @param CartInterface $quote
     * @return MessageInterface[]|null
     */
    public function validate(CartInterface $quote): array|null
    {
        /** @var Quote $quote */
        $errors = [];

        $errors = array_merge($errors, $this->validateBillingAddress($quote));
        $errors = array_merge($errors, $this->validateShippingAddress($quote));

        return $errors;
    }

    /**
     * @param CartInterface $quote
     * @return MessageInterface[]
     */
    public function validateBillingAddress(CartInterface $quote): array
    {
        /** @var Quote $quote */
        $billingAddress = $quote->getBillingAddress();

        $errors = [];

        if (!$billingAddress->getFirstName()) {
            $errors[] = $this->createMessage('First name is required', '$.buyer.first_name');
        }

        if (!$billingAddress->getLastName()) {
            $errors[] = $this->createMessage('Last name is required', '$.buyer.last_name');
        }

        if (!$billingAddress->getTelephone()) {
            $errors[] = $this->createMessage('Telephone is required', '$.buyer.phone_number');
        }

        return $errors;
    }

    /**
     * @param CartInterface $quote
     * @return MessageInterface[]
     */
    public function validateShippingAddress(CartInterface $quote): array
    {
        /** @var Quote $quote */
        $shippingAddress = $quote->getShippingAddress();

        if ($quote->getIsVirtual()) {
            return [];
        }

        $errors = [];

        if (!$shippingAddress->getStreet()) {
            $errors[] = $this->createMessage('Street is required', '$.fulfillment.methods[0].destination.street_address');
        }

        if (!$shippingAddress->getCity()) {
            $errors[] = $this->createMessage('City is required', '$.fulfillment.methods[0].destination.address_locality');
        }

        if (!$shippingAddress->getCountry()) {
            $errors[] = $this->createMessage('Country is required', '$.fulfillment.methods[0].destination.address_country');
        }

        if (!$shippingAddress->getPostcode()) {
            $errors[] = $this->createMessage('Postcode is required', '$.fulfillment.methods[0].destination.postal_code');
        }

        if (!$shippingAddress->getRegion()) {
            $errors[] = $this->createMessage('Region is required', '$.fulfillment.methods[0].destination.address_region');
        }

        return $errors;
    }

    /**
     * @param string $message
     * @param string $path
     * @param string $code
     * @param string $severity
     * @return MessageInterface
     */
    public function createMessage(
        string $message,
        string $path,
        string $code = 'missing',
        string $severity = MessageInterface::SEVERITY_REQUIRES_BUYER_INPUT
    ): MessageInterface {
        return $this->messageFactory->create([ 'data' => [
            'type' => 'error',
            'path' => $path,
            'code' => $code,
            'severity' => $severity,
            'content' => $message,
        ]]);
    }
}
