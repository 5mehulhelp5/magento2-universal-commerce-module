<?php

/**
 * This file is part of the Magebit_UniversalCommerce package.
 *
 * @copyright Copyright (c) 2026 Magebit, Ltd. (https://magebit.com/)
 * @author    Magebit <info@magebit.com>
 * @license   MIT
 */

declare(strict_types=1);

namespace Magebit\UniversalCommerce\Model\Spec\Schemas\Shopping;

use Magebit\UcpSpec\Api\Shopping\DiscountResponseCheckoutInterface;
use Magebit\UcpSpec\Api\Shopping\DiscountResponseDiscountsObjectInterface;
use Magebit\UcpSpec\Api\Shopping\FulfillmentCreateRequestCheckoutInterface;
use Magebit\UcpSpec\Api\Shopping\Types\FulfillmentRequestInterface;
use Magebit\UcpSpec\Data\Shopping\CheckoutCreateRequest as GeneratedCheckoutCreateRequest;
use Magebit\UniversalCommerce\Api\Service\Shopping\CheckoutCreateRequestInterface;

/**
 * The base checkout request plus the fulfillment and discount extensions, which the spec ships as
 * separate schemas and therefore never composes into one type of its own.
 */
class CheckoutCreateRequest extends GeneratedCheckoutCreateRequest implements CheckoutCreateRequestInterface
{
    /**
     * @return FulfillmentRequestInterface|null
     */
    public function getFulfillment(): ?FulfillmentRequestInterface
    {
        return $this->instanceOrNull(
            FulfillmentCreateRequestCheckoutInterface::KEY_FULFILLMENT,
            FulfillmentRequestInterface::class
        );
    }

    /**
     * @param FulfillmentRequestInterface|null $fulfillment
     * @return self
     */
    public function setFulfillment(?FulfillmentRequestInterface $fulfillment): self
    {
        return $this->set(FulfillmentCreateRequestCheckoutInterface::KEY_FULFILLMENT, $fulfillment);
    }

    /**
     * @return DiscountResponseDiscountsObjectInterface|null
     */
    public function getDiscounts(): ?DiscountResponseDiscountsObjectInterface
    {
        return $this->instanceOrNull(
            DiscountResponseCheckoutInterface::KEY_DISCOUNTS,
            DiscountResponseDiscountsObjectInterface::class
        );
    }

    /**
     * @param DiscountResponseDiscountsObjectInterface|null $discounts
     * @return self
     */
    public function setDiscounts(?DiscountResponseDiscountsObjectInterface $discounts): self
    {
        return $this->set(DiscountResponseCheckoutInterface::KEY_DISCOUNTS, $discounts);
    }
}
