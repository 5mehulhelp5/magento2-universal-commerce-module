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

use Magento\Quote\Api\Data\CartInterface;
use Magento\Quote\Model\Quote;
use Magebit\UcpSpec\MutableApi\Schemas\Shopping\FulfillmentFulfillmentInterface;
use Magebit\UcpSpec\MutableApi\Schemas\Shopping\FulfillmentFulfillmentInterfaceFactory;
use Magento\Quote\Model\Quote\Address\Rate;
use Magebit\UcpSpec\MutableApi\Schemas\Shopping\Types\FulfillmentMethodResponseInterface;
use Magebit\UcpSpec\MutableApi\Schemas\Shopping\Types\FulfillmentMethodResponseInterfaceFactory;
use Magento\Quote\Model\Quote\Address;
use Magebit\UcpSpec\MutableApi\Schemas\Shopping\Types\FulfillmentGroupResponseInterface;
use Magebit\UcpSpec\MutableApi\Schemas\Shopping\Types\FulfillmentGroupResponseInterfaceFactory;
use Magebit\UcpSpec\MutableApi\Schemas\Shopping\Types\FulfillmentOptionResponseInterface;
use Magebit\UcpSpec\MutableApi\Schemas\Shopping\Types\FulfillmentOptionResponseInterfaceFactory;
use Magebit\UcpSpec\MutableApi\Schemas\Shopping\Types\FulfillmentDestinationResponseInterface;
use Magebit\UcpSpec\MutableApi\Schemas\Shopping\Types\FulfillmentDestinationResponseInterfaceFactory;
use Magebit\UcpSpec\MutableApi\Schemas\Shopping\Types\TotalResponseInterface;
use Magebit\UcpSpec\MutableApi\Schemas\Shopping\Types\TotalResponseInterfaceFactory;

class QuoteToFulfillmentResponse
{
    /**
     * @param FulfillmentFulfillmentInterfaceFactory $fulfillmentFulfillmentFactory
     * @param FulfillmentMethodResponseInterfaceFactory $fulfillmentMethodResponseFactory
     * @param FulfillmentGroupResponseInterfaceFactory $fulfillmentGroupResponseFactory
     * @param FulfillmentOptionResponseInterfaceFactory $fulfillmentOptionResponseFactory
     * @param FulfillmentDestinationResponseInterfaceFactory $fulfillmentDestinationResponseFactory
     * @param TotalResponseInterfaceFactory $totalResponseFactory
     * @param PriceConverter $priceConverter
     */
    public function __construct(
        protected readonly FulfillmentFulfillmentInterfaceFactory $fulfillmentFulfillmentFactory,
        protected readonly FulfillmentMethodResponseInterfaceFactory $fulfillmentMethodResponseFactory,
        protected readonly FulfillmentGroupResponseInterfaceFactory $fulfillmentGroupResponseFactory,
        protected readonly FulfillmentOptionResponseInterfaceFactory $fulfillmentOptionResponseFactory,
        protected readonly FulfillmentDestinationResponseInterfaceFactory $fulfillmentDestinationResponseFactory,
        protected readonly TotalResponseInterfaceFactory $totalResponseFactory,
        protected readonly PriceConverter $priceConverter
    ) {
    }

    /**
     * @param CartInterface $quote
     * @return FulfillmentFulfillmentInterface|null
     */
    public function convert(CartInterface $quote): ?FulfillmentFulfillmentInterface
    {
        /** @var Quote $quote */
        if ($quote->getIsVirtual()) {
            return null;
        }

        $shippingAddress = $quote->getShippingAddress();

        if (!$shippingAddress) {
            return null;
        }

        $shippingAddress->setCollectShippingRates(true);
        $shippingAddress->collectShippingRates();

        $quoteItemIds = array_map(function (Quote\Item $quoteItem) {
            return (string) $quoteItem->getId();
        }, $quote->getAllItems());

        /** @var FulfillmentFulfillmentInterface $response */
        $response = $this->fulfillmentFulfillmentFactory->create();

        $methods = $this->getMethods($shippingAddress, $quoteItemIds);
        if (!empty($methods)) {
            $response->setMethods($methods);
        }

        return $response;
    }

    /**
     * @param Address $shippingAddress
     * @param array<string> $quoteItemIds
     * @return FulfillmentMethodResponseInterface[]
     */
    public function getMethods(Address $shippingAddress, array $quoteItemIds): array
    {
        $shippingRates = $shippingAddress->getAllShippingRates();

        $shippingRates = array_filter($shippingRates, function (Rate $shippingMethod) {
            return !$shippingMethod->getErrorMessage();
        });

        if (empty($shippingRates)) {
            return [];
        }

        // Create one fulfillment method (type: 'shipping')
        /** @var FulfillmentMethodResponseInterface $method */
        $method = $this->fulfillmentMethodResponseFactory->create();
        $method->setId('shipping');
        $method->setType(FulfillmentMethodResponseInterface::TYPE_SHIPPING);
        $method->setLineItemIds($quoteItemIds);

        // Convert shipping address to destination
        $destination = $this->convertAddressToDestination($shippingAddress);
        if ($destination) {
            $method->setDestinations([$destination]);
            $method->setSelectedDestinationId($destination->getId());
        }

        // Create groups with options (shipping rates)
        $group = $this->fulfillmentGroupResponseFactory->create();
        $group->setId('group_1');
        $group->setLineItemIds($quoteItemIds);

        $options = $this->convertShippingRatesToOptions($shippingRates);
        if (!empty($options)) {
            $group->setOptions(array_values($options));
        }

        $method->setGroups([$group]);

        return [$method];
    }

    /**
     * @param Address $address
     * @return FulfillmentDestinationResponseInterface|null
     */
    private function convertAddressToDestination(Address $address): ?FulfillmentDestinationResponseInterface
    {
        if (!$address->getCountryId()) {
            return null;
        }

        $street = $address->getStreet();
        $streetAddress = is_array($street) ? ($street[0] ?? '') : (string) $street;

        /** @var FulfillmentDestinationResponseInterface $destination */
        $destination = $this->fulfillmentDestinationResponseFactory->create();
        $destination->setId((string) $address->getId());

        if ($streetAddress) {
            $destination->setStreetAddress($streetAddress);
        }

        if ($address->getCity()) {
            $destination->setAddressLocality($address->getCity());
        }
        if ($address->getRegion()) {
            $destination->setAddressRegion($address->getRegion());
        }
        if ($address->getCountryId()) {
            $destination->setAddressCountry($address->getCountryId());
        }
        if ($address->getPostcode()) {
            $destination->setPostalCode($address->getPostcode());
        }
        if ($address->getFirstname()) {
            $destination->setFirstName($address->getFirstname());
        }
        if ($address->getLastname()) {
            $destination->setLastName($address->getLastname());
        }
        if ($address->getName()) {
            $destination->setFullName($address->getName());
        }
        if ($address->getTelephone()) {
            $destination->setPhoneNumber($address->getTelephone());
        }

        return $destination;
    }

    /**
     * @param Rate[] $shippingRates
     * @return FulfillmentOptionResponseInterface[]
     */
    private function convertShippingRatesToOptions(array $shippingRates): array
    {
        return array_map(function (Rate $rate) {
            /** @var FulfillmentOptionResponseInterface $option */
            $option = $this->fulfillmentOptionResponseFactory->create();
            $option->setId($rate->getCarrier() . '_' . $rate->getMethod());
            $option->setTitle($rate->getMethodTitle() ?: $rate->getCarrierTitle());
            $option->setDescription($rate->getMethodTitle() ? $rate->getCarrierTitle() : null);
            $option->setCarrier($rate->getCarrierTitle());

            // Create totals for the option
            $price = (float) $rate->getPrice();
            $total = $this->totalResponseFactory->create();
            $total->setType(TotalResponseInterface::TYPE_FULFILLMENT);
            $total->setAmount($this->priceConverter->convert($price));
            $total->setDisplayText($rate->getMethodTitle() ?: $rate->getCarrierTitle());

            $option->setTotals([$total]);

            return $option;
        }, $shippingRates);
    }
}
