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

use Magebit\UcpSpec\MutableApi\Schemas\Shopping\CheckoutCreateRequestInterface;
use Magebit\UcpSpec\Api\Schemas\Shopping\CheckoutResponseInterface;

interface RestHandlerInterface
{
    /**
     * @param CheckoutCreateRequestInterface $request
     * @return CheckoutResponseInterface
     */
    public function createCheckout(CheckoutCreateRequestInterface $request): CheckoutResponseInterface;
}
