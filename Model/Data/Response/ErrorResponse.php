<?php

/**
 * This file is part of the Magebit_UniversalCommerce package.
 *
 * @copyright Copyright (c) 2026 Magebit, Ltd. (https://magebit.com/)
 * @author    Magebit <info@magebit.com>
 * @license   MIT
 */

declare(strict_types=1);

namespace Magebit\UniversalCommerce\Model\Data\Response;

use Magebit\UniversalCommerce\Api\Data\Response\ErrorResponseInterface;
use Magebit\UniversalCommerce\Api\Data\Response\MessageInterface;
use Magento\Framework\DataObject;

/**
 * Error Response Model
 * Represents an error response in UCP format
 */
class ErrorResponse extends DataObject implements ErrorResponseInterface
{
    /**
     * @inheritDoc
     */
    public function getStatus(): string
    {
        return (string) $this->getData(self::STATUS);
    }

    /**
     * @inheritDoc
     */
    public function setStatus(string $status): ErrorResponseInterface
    {
        return $this->setData(self::STATUS, $status);
    }

    /**
     * @inheritDoc
     */
    public function getMessages(): array
    {
        return $this->getData(self::MESSAGES) ?? [];
    }

    /**
     * @inheritDoc
     */
    public function setMessages(array $messages): ErrorResponseInterface
    {
        return $this->setData(self::MESSAGES, $messages);
    }

    /**
     * @inheritDoc
     */
    public function addMessage(MessageInterface $message): ErrorResponseInterface
    {
        $messages = $this->getMessages();
        $messages[] = $message;
        return $this->setMessages($messages);
    }

    /**
     * Convert to array for JSON serialization
     *
     * @param array<string> $keys
     * @return array<string, mixed>
     */
    public function toArray(array $keys = []): array
    {
        $messages = [];
        foreach ($this->getMessages() as $message) {
            /** @var Message $message */
            $messages[] = [
                MessageInterface::TYPE => $message->getType(),
                MessageInterface::CODE => $message->getCode(),
                MessageInterface::SEVERITY => $message->getSeverity(),
                MessageInterface::CONTENT => $message->getContent(),
            ];
        }

        return [
            self::STATUS => $this->getStatus(),
            self::MESSAGES => $messages,
        ];
    }
}
