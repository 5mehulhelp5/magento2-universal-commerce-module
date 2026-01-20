<?php

/**
 * @author Magebit <info@magebit.com>
 * @copyright Copyright (c) Magebit, Ltd. (https://magebit.com)
 * @license https://magebit.com/code-license
 */

declare(strict_types=1);

namespace Magebit\UniversalCommerce\Model;

use Magebit\UcpSpec\MutableApi\Schemas\Shopping\Types\MessageInterface;
use Magebit\UcpSpec\MutableApi\Schemas\Shopping\Types\MessageInterfaceFactory;
use Magento\Quote\Api\Data\CartInterface;
use Magento\Quote\Model\Quote;

/**
 * Checkout Message Builder
 * Builds UCP-compliant messages for checkout validation
 */
class CheckoutMessageBuilder
{
    /**
     * @param MessageInterfaceFactory $messageFactory
     */
    public function __construct(
        protected readonly MessageInterfaceFactory $messageFactory
    ) {
    }

    /**
     * Build messages from validation errors
     *
     * @param CartInterface $quote
     * @param string[] $validationErrors
     * @return MessageInterface[]
     */
    public function buildMessages(CartInterface $quote, array $validationErrors): array
    {
        /** @var Quote $quote */
        $messages = [];

        // Check if cart is inactive
        if (!$quote->getIsActive()) {
            // Cart is canceled
            $messages[] = $this->createMessage(
                'error',
                'cart_not_active',
                'Cart is not active. Please create a new checkout session',
                MessageInterface::SEVERITY_RECOVERABLE
            );

            return $messages;
        }

        // Convert validation errors to messages
        foreach ($validationErrors as $error) {
            $messages[] = $this->createValidationErrorMessage($error);
        }

        return $messages;
    }

    /**
     * Create a validation error message
     *
     * @param string $errorText
     * @return MessageInterface
     */
    protected function createValidationErrorMessage(string $errorText): MessageInterface
    {
        // Determine error code and severity based on error text
        $code = $this->determineErrorCode($errorText);
        $severity = $this->determineSeverity($errorText);

        return $this->createMessage('error', $code, $errorText, $severity);
    }

    /**
     * Create a message object
     *
     * @param string $type
     * @param string $code
     * @param string $content
     * @param string $severity
     * @return MessageInterface
     */
    protected function createMessage(
        string $type,
        string $code,
        string $content,
        string $severity
    ): MessageInterface {
        /** @var MessageInterface $message */
        $message = $this->messageFactory->create();
        $message->setType($type);
        $message->setCode($code);
        $message->setContent($content);
        $message->setSeverity($severity);
        $message->setContentType(MessageInterface::CONTENT_TYPE_PLAIN);

        return $message;
    }

    /**
     * Determine error code from error text
     *
     * @param string $errorText
     * @return string
     */
    protected function determineErrorCode(string $errorText): string
    {
        $errorText = strtolower($errorText);

        if (str_contains($errorText, 'required') || str_contains($errorText, 'missing')) {
            return 'missing';
        }

        if (str_contains($errorText, 'invalid')) {
            return 'invalid';
        }

        if (str_contains($errorText, 'stock') || str_contains($errorText, 'available')) {
            return 'out_of_stock';
        }

        return 'invalid';
    }

    /**
     * Determine severity from error text
     *
     * @param string $errorText
     * @return string
     */
    protected function determineSeverity(string $errorText): string
    {
        $errorText = strtolower($errorText);

        // Buyer information errors require buyer input
        if (str_contains($errorText, 'buyer') ||
            str_contains($errorText, 'customer') ||
            str_contains($errorText, 'email') ||
            str_contains($errorText, 'phone') ||
            str_contains($errorText, 'name')) {
            return MessageInterface::SEVERITY_REQUIRES_BUYER_INPUT;
        }

        // Stock and availability issues are recoverable by the agent
        if (str_contains($errorText, 'stock') || str_contains($errorText, 'available')) {
            return MessageInterface::SEVERITY_RECOVERABLE;
        }

        // Default to requires buyer input for most validation errors
        return MessageInterface::SEVERITY_REQUIRES_BUYER_INPUT;
    }
}
