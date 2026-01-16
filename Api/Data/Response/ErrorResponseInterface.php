<?php

/**
 * This file is part of the Magebit_UniversalCommerce package.
 *
 * @copyright Copyright (c) 2026 Magebit, Ltd. (https://magebit.com/)
 * @author    Magebit <info@magebit.com>
 * @license   MIT
 */

declare(strict_types=1);

namespace Magebit\UniversalCommerce\Api\Data\Response;

/**
 * Error Response Interface
 * Represents an error response in UCP format
 */
interface ErrorResponseInterface
{
    public const STATUS = 'status';
    public const MESSAGES = 'messages';

    // Status constants
    public const STATUS_REQUIRES_ESCALATION = 'requires_escalation';
    public const STATUS_INVALID_REQUEST = 'invalid_request';

    /**
     * Get status
     *
     * @return string
     */
    public function getStatus(): string;

    /**
     * Set status
     *
     * @param string $status
     * @return $this
     */
    public function setStatus(string $status): self;

    /**
     * Get messages
     *
     * @return MessageInterface[]
     */
    public function getMessages(): array;

    /**
     * Set messages
     *
     * @param MessageInterface[] $messages
     * @return $this
     */
    public function setMessages(array $messages): self;

    /**
     * Add a message
     *
     * @param MessageInterface $message
     * @return $this
     */
    public function addMessage(MessageInterface $message): self;

    /**
     * Convert to array for JSON serialization
     *
     * @param array<string> $keys
     * @return array<string, mixed>
     */
    public function toArray(array $keys = []): array;
}
