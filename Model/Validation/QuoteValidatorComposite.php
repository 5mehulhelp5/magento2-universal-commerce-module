<?php

/**
 * @author Magebit <info@magebit.com>
 * @copyright Copyright (c) Magebit, Ltd. (https://magebit.com)
 * @license https://magebit.com/code-license
 */

declare(strict_types=1);

namespace Magebit\UniversalCommerce\Model\Validation;

use Magebit\UcpSpec\MutableApi\Schemas\Shopping\Types\MessageInterface;
use Magebit\UniversalCommerce\Api\QuoteValidatorInterface;
use Magento\Quote\Api\Data\CartInterface;

/**
 * Composite Quote Validator
 * Aggregates multiple validators and returns combined validation messages
 */
class QuoteValidatorComposite implements QuoteValidatorInterface
{
    /**
     * @param QuoteValidatorInterface[] $validators
     */
    public function __construct(
        private readonly array $validators = []
    ) {
    }

    /**
     * Validate quote using all registered validators
     *
     * @param CartInterface $quote
     * @return MessageInterface[]
     */
    public function validate(CartInterface $quote): array
    {
        /** @var MessageInterface[] $messages */
        $messages = [];

        foreach ($this->validators as $validator) {
            $validatorMessages = $validator->validate($quote);
            if (!empty($validatorMessages)) {
                foreach ($validatorMessages as $message) {
                    $messages[] = $message;
                }
            }
        }

        return $messages;
    }
}
