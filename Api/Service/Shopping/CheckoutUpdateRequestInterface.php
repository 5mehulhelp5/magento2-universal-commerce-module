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

use Magebit\UcpSpec\Api\Shopping\CheckoutUpdateRequestInterface as BaseRequestInterface;
use Magebit\UcpSpec\Api\Shopping\Types\FulfillmentRequestInterface;
use Magebit\UcpSpec\Api\Shopping\DiscountResponseDiscountsObjectInterface;

interface CheckoutUpdateRequestInterface extends BaseRequestInterface
{
    /**
     * @return \Magebit\UcpSpec\Api\Shopping\Types\FulfillmentRequestInterface|null
     */
    public function getFulfillment(): ?\Magebit\UcpSpec\Api\Shopping\Types\FulfillmentRequestInterface;

    /**
     * @param \Magebit\UcpSpec\Api\Shopping\Types\FulfillmentRequestInterface|null $fulfillment
     * @return self
     */
    public function setFulfillment(?FulfillmentRequestInterface $fulfillment): self;

    /**
     * @return \Magebit\UcpSpec\Api\Shopping\DiscountResponseDiscountsObjectInterface|null
     */
    public function getDiscounts(): ?\Magebit\UcpSpec\Api\Shopping\DiscountResponseDiscountsObjectInterface;

    /**
     * @param \Magebit\UcpSpec\Api\Shopping\DiscountResponseDiscountsObjectInterface|null $discounts
     * @return self
     */
    public function setDiscounts(?DiscountResponseDiscountsObjectInterface $discounts): self;
}
