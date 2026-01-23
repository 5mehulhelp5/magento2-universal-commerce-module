<?php

/**
 * This file is part of the Magebit_UniversalCommerce package.
 *
 * @copyright Copyright (c) 2026 Magebit, Ltd. (https://magebit.com/)
 * @author    Magebit <info@magebit.com>
 * @license   MIT
 */

namespace Magebit\UniversalCommerce\Api\Service\Shopping;

use Magebit\UcpSpec\MutableApi\Schemas\Shopping\Types\MessageInterface;
use Magento\Quote\Api\Data\CartInterface;

interface QuoteValidatorInterface
{
    /**
     * @param CartInterface $quote
     * @return MessageInterface[]|null
     */
    public function validate(CartInterface $quote): array|null;
}
