<?php

/**
 * @author Magebit <info@magebit.com>
 * @copyright Copyright (c) Magebit, Ltd. (https://magebit.com)
 * @license https://magebit.com/code-license
 */

declare(strict_types=1);

namespace Magebit\UniversalCommerce\Api;

use Magebit\UcpSpec\MutableApi\Schemas\Shopping\Types\MessageInterface;
use Magento\Quote\Api\Data\CartInterface;

/**
 * Quote Validator Interface
 */
interface QuoteValidatorInterface
{
    /**
     * Validate quote and return array of messages
     *
     * @param CartInterface $quote
     * @return MessageInterface[]
     */
    public function validate(CartInterface $quote): array;
}
