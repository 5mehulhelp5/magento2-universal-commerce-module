<?php

/**
 * @author Magebit <info@magebit.com>
 * @copyright Copyright (c) Magebit, Ltd. (https://magebit.com)
 * @license https://magebit.com/code-license
 */

declare(strict_types=1);

namespace Magebit\UniversalCommerce\Model\Validation;

use Magebit\UcpSpec\MutableApi\Schemas\Shopping\Types\MessageInterface;
use Magento\Quote\Api\Data\CartInterface;
use Magento\Quote\Model\Quote;

/**
 * Buyer Information Validator
 * Validates that required buyer information is present in the quote
 */
class BuyerValidator extends AbstractValidator
{
    /**
     * Validate buyer information in quote
     *
     * @param CartInterface $quote
     * @return MessageInterface[]
     */
    public function validate(CartInterface $quote): array
    {
        /** @var Quote $quote */
        $messages = [];

        if (!$quote->getCustomerFirstname()) {
            $messages[] = $this->createMessage(
                'missing',
                'Buyer first name is required',
                MessageInterface::SEVERITY_REQUIRES_BUYER_INPUT,
                '$.buyer.first_name'
            );
        }

        if (!$quote->getCustomerLastname()) {
            $messages[] = $this->createMessage(
                'missing',
                'Buyer last name is required',
                MessageInterface::SEVERITY_REQUIRES_BUYER_INPUT,
                '$.buyer.last_name'
            );
        }

        if (!$quote->getCustomerEmail()) {
            $messages[] = $this->createMessage(
                'missing',
                'Buyer email is required',
                MessageInterface::SEVERITY_REQUIRES_BUYER_INPUT,
                '$.buyer.email'
            );
        }

        return $messages;
    }
}
