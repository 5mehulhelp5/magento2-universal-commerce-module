<?php

/**
 * This file is part of the Magebit_UniversalCommerce package.
 *
 * @copyright Copyright (c) 2026 Magebit, Ltd. (https://magebit.com/)
 * @author    Magebit <info@magebit.com>
 * @license   MIT
 */

declare(strict_types=1);

namespace Magebit\UniversalCommerce\Api\Data;

/**
 * Interface for Idempotency Key Model
 * Provides methods to manage idempotency records for request deduplication
 */
interface IdempotencyKeyInterface
{
    public const ENTITY_ID = 'entity_id';
    public const KEY = 'key';
    public const REQUEST_HASH = 'request_hash';
    public const RESPONSE_STATUS = 'response_status';
    public const RESPONSE_BODY = 'response_body';
    public const CREATED_AT = 'created_at';
    public const UPDATED_AT = 'updated_at';

    /**
     * Get entity ID
     *
     * @return int|null
     */
    public function getEntityId(): ?int;

    /**
     * Get key
     *
     * @return string|null
     */
    public function getKey(): ?string;

    /**
     * Set key
     *
     * @param string $key
     * @return $this
     */
    public function setKey(string $key): self;

    /**
     * Get request hash
     *
     * @return string|null
     */
    public function getRequestHash(): ?string;

    /**
     * Set request hash
     *
     * @param string $requestHash
     * @return $this
     */
    public function setRequestHash(string $requestHash): self;

    /**
     * Get response status
     *
     * @return string|null
     */
    public function getResponseStatus(): ?string;

    /**
     * Set response status
     *
     * @param string $responseStatus
     * @return $this
     */
    public function setResponseStatus(string $responseStatus): self;

    /**
     * Get response body
     *
     * @return string|null
     */
    public function getResponseBody(): ?string;

    /**
     * Set response body
     *
     * @param string $responseBody
     * @return $this
     */
    public function setResponseBody(string $responseBody): self;

    /**
     * Get created at
     *
     * @return string|null
     */
    public function getCreatedAt(): ?string;

    /**
     * Set created at
     *
     * @param string $createdAt
     * @return $this
     */
    public function setCreatedAt(string $createdAt): self;

    /**
     * Get updated at
     *
     * @return string|null
     */
    public function getUpdatedAt(): ?string;

    /**
     * Set updated at
     *
     * @param string $updatedAt
     * @return $this
     */
    public function setUpdatedAt(string $updatedAt): self;
}
