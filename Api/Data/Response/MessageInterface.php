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
 * Message Interface
 * Represents an error, warning, or info message in UCP format
 */
interface MessageInterface
{
    public const TYPE = 'type';
    public const CODE = 'code';
    public const SEVERITY = 'severity';
    public const CONTENT = 'content';

    // Type constants
    public const TYPE_ERROR = 'error';
    public const TYPE_WARNING = 'warning';
    public const TYPE_INFO = 'info';

    // Severity constants
    public const SEVERITY_RECOVERABLE = 'recoverable';
    public const SEVERITY_REQUIRES_BUYER_INPUT = 'requires_buyer_input';
    public const SEVERITY_REQUIRES_BUYER_REVIEW = 'requires_buyer_review';

    /**
     * Get message type
     *
     * @return string
     */
    public function getType(): string;

    /**
     * Set message type
     *
     * @param string $type
     * @return $this
     */
    public function setType(string $type): self;

    /**
     * Get error code
     *
     * @return string
     */
    public function getCode(): string;

    /**
     * Set error code
     *
     * @param string $code
     * @return $this
     */
    public function setCode(string $code): self;

    /**
     * Get severity level
     *
     * @return string
     */
    public function getSeverity(): string;

    /**
     * Set severity level
     *
     * @param string $severity
     * @return $this
     */
    public function setSeverity(string $severity): self;

    /**
     * Get message content
     *
     * @return string
     */
    public function getContent(): string;

    /**
     * Set message content
     *
     * @param string $content
     * @return $this
     */
    public function setContent(string $content): self;
}
