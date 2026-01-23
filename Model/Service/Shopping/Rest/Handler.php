<?php

/**
 * This file is part of the Magebit_UniversalCommerce package.
 *
 * @copyright Copyright (c) 2026 Magebit, Ltd. (https://magebit.com/)
 * @author    Magebit <info@magebit.com>
 * @license   MIT
 */
declare(strict_types=1);

namespace Magebit\UniversalCommerce\Model\Service\Shopping\Rest;

use Magebit\UniversalCommerce\Api\Service\Shopping\RestHandlerInterface;
use Magebit\UcpSpec\Api\Schemas\Shopping\CheckoutCreateRequestInterface;
use Magebit\UcpSpec\Api\Schemas\Shopping\CheckoutResponseInterface;

class Handler implements RestHandlerInterface
{
    /**
     * @param CheckoutCreateRequestInterface $request
     * @return CheckoutResponseInterface
     */
    public function createCheckout(): CheckoutResponseInterface
    {
        throw new \Exception('Not implemented');
    }
}
