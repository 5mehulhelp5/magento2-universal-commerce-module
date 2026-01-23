<?php

/**
 * This file is part of the Magebit_UniversalCommerce package.
 *
 * @copyright Copyright (c) 2026 Magebit, Ltd. (https://magebit.com/)
 * @author    Magebit <info@magebit.com>
 * @license   MIT
 */
declare(strict_types=1);

namespace Magebit\UniversalCommerce\Api\Service\Shopping;

use Magebit\UcpSpec\MutableApi\Schemas\Shopping\CheckoutUpdateRequestInterface as BaseRequestInterface;
use Magebit\UcpSpec\MutableApi\Schemas\Shopping\Types\FulfillmentRequestInterface;
use Magebit\UcpSpec\MutableApi\Schemas\Shopping\DiscountDiscountsObjectInterface;

interface CheckoutUpdateRequestInterface extends BaseRequestInterface
{
    /**
     * @return \Magebit\UcpSpec\MutableApi\Schemas\Shopping\Types\FulfillmentRequestInterface|null
     */
    public function getFulfillment(): ?\Magebit\UcpSpec\MutableApi\Schemas\Shopping\Types\FulfillmentRequestInterface;

    /**
     * @param \Magebit\UcpSpec\MutableApi\Schemas\Shopping\Types\FulfillmentRequestInterface|null $fulfillment
     * @return self
     */
    public function setFulfillment(?FulfillmentRequestInterface $fulfillment): self;

    /**
     * @return \Magebit\UcpSpec\MutableApi\Schemas\Shopping\DiscountDiscountsObjectInterface|null
     */
    public function getDiscounts(): ?\Magebit\UcpSpec\MutableApi\Schemas\Shopping\DiscountDiscountsObjectInterface;

    /**
     * @param \Magebit\UcpSpec\MutableApi\Schemas\Shopping\DiscountDiscountsObjectInterface|null $discounts
     * @return self
     */
    public function setDiscounts(?DiscountDiscountsObjectInterface $discounts): self;
}
