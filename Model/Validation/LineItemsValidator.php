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
 * Line Items Validator
 * Validates that quote has items and they are valid
 */
class LineItemsValidator extends AbstractValidator
{
    /**
     * Validate line items in quote
     *
     * @param CartInterface $quote
     * @return MessageInterface[]
     */
    public function validate(CartInterface $quote): array
    {
        /** @var Quote $quote */
        $messages = [];

        if (!$quote->hasItems() || $quote->getItemsCount() === 0) {
            $messages[] = $this->createMessage(
                'missing',
                'Cart must contain at least one item',
                MessageInterface::SEVERITY_RECOVERABLE,
                '$.line_items'
            );
            return $messages;
        }

        // Check for items with errors
        $itemIndex = 0;
        foreach ($quote->getAllItems() as $item) {
            if ($item->getHasError()) {
                $messages[] = $this->createMessage(
                    'invalid',
                    sprintf('Item "%s" has an error: %s', $item->getName(), $item->getMessage()),
                    MessageInterface::SEVERITY_RECOVERABLE,
                    sprintf('$.line_items[%d]', $itemIndex)
                );
            }

            // Check stock availability
            if ($item->getProduct() && !$item->getProduct()->isSaleable()) {
                $messages[] = $this->createMessage(
                    'out_of_stock',
                    sprintf('Item "%s" is not available for sale', $item->getName()),
                    MessageInterface::SEVERITY_RECOVERABLE,
                    sprintf('$.line_items[%d]', $itemIndex)
                );
            }

            $itemIndex++;
        }

        return $messages;
    }
}
