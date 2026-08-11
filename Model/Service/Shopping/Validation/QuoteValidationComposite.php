<?php

/**
 * This file is part of the Magebit_UniversalCommerce package.
 *
 * @copyright Copyright (c) 2026 Magebit, Ltd. (https://magebit.com/)
 * @author    Magebit <info@magebit.com>
 * @license   MIT
 */

namespace Magebit\UniversalCommerce\Model\Service\Shopping\Validation;

use Magebit\UniversalCommerce\Api\Service\Shopping\QuoteValidatorInterface;
use Magento\Quote\Api\Data\CartInterface;
use Magebit\UcpSpec\Api\Shopping\Types\MessageInterface;

class QuoteValidationComposite implements QuoteValidatorInterface
{
    /**
     * @param QuoteValidatorInterface[] $validators
     */
    public function __construct(
        private readonly array $validators = []
    ) {
    }

    /**
     * @param CartInterface $quote
     * @return MessageInterface[]|null
     */
    public function validate(CartInterface $quote): array|null
    {
        /** @var MessageInterface[] $errors */
        $errors = [];

        foreach ($this->validators as $validator) {
            if ($validatorErrors = $validator->validate($quote)) {
                $errors = array_merge($errors, $validatorErrors);
            }
        }

        return $errors;
    }
}
