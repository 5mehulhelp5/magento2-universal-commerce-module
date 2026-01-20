<?php

/**
 * @author Magebit <info@magebit.com>
 * @copyright Copyright (c) Magebit, Ltd. (https://magebit.com)
 * @license https://magebit.com/code-license
 */

declare(strict_types=1);

namespace Magebit\UniversalCommerce\Model\Validation;

use Magebit\UcpSpec\MutableApi\Schemas\Shopping\Types\MessageInterface;
use Magebit\UcpSpec\MutableApi\Schemas\Shopping\Types\MessageInterfaceFactory;
use Magebit\UniversalCommerce\Api\QuoteValidatorInterface;

/**
 * Abstract Validator
 * Base class for quote validators with common message creation functionality
 */
abstract class AbstractValidator implements QuoteValidatorInterface
{
    /**
     * @param MessageInterfaceFactory $messageFactory
     */
    public function __construct(
        protected readonly MessageInterfaceFactory $messageFactory
    ) {
    }

    /**
     * Create a validation message
     *
     * @param string $code
     * @param string $content
     * @param string $severity
     * @param string|null $path
     * @param string $type
     * @return MessageInterface
     */
    protected function createMessage(
        string $code,
        string $content,
        string $severity,
        ?string $path = null,
        string $type = 'error'
    ): MessageInterface {
        /** @var MessageInterface $message */
        $message = $this->messageFactory->create();
        $message->setType($type);
        $message->setCode($code);
        $message->setContent($content);
        $message->setContentType(MessageInterface::CONTENT_TYPE_PLAIN);
        $message->setSeverity($severity);

        if ($path) {
            $message->setPath($path);
        }

        return $message;
    }
}
