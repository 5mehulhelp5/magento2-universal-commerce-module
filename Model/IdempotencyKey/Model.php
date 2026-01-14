<?php

/**
 * This file is part of the Magebit_UniversalCommerce package.
 *
 * @copyright Copyright (c) 2026 Magebit, Ltd. (https://magebit.com/)
 * @author    Magebit <info@magebit.com>
 * @license   MIT
 */

declare(strict_types=1);

namespace Magebit\UniversalCommerce\Model\IdempotencyKey;

use Magebit\UniversalCommerce\Api\Data\IdempotencyKeyInterface;
use Magento\Framework\Model\AbstractModel;

/**
 * Idempotency Key Model
 */
class Model extends AbstractModel implements IdempotencyKeyInterface
{
    /**
     * Initialize resource model
     *
     * @return void
     */
    protected function _construct(): void
    {
        $this->_init(ResourceModel::class);
    }

    /**
     * @inheritDoc
     */
    public function getEntityId(): ?int
    {
        $value = $this->getData(self::ENTITY_ID);
        return $value !== null && $value !== '' ? (int) $value : null;
    }

    /**
     * @inheritDoc
     */
    public function getKey(): ?string
    {
        $value = $this->getData(self::KEY);
        return $value !== null ? (string) $value : null;
    }

    /**
     * @inheritDoc
     */
    public function setKey(string $key): IdempotencyKeyInterface
    {
        return $this->setData(self::KEY, $key);
    }

    /**
     * @inheritDoc
     */
    public function getRequestHash(): ?string
    {
        $value = $this->getData(self::REQUEST_HASH);
        return $value !== null ? (string) $value : null;
    }

    /**
     * @inheritDoc
     */
    public function setRequestHash(string $requestHash): IdempotencyKeyInterface
    {
        return $this->setData(self::REQUEST_HASH, $requestHash);
    }

    /**
     * @inheritDoc
     */
    public function getResponseStatus(): ?string
    {
        $value = $this->getData(self::RESPONSE_STATUS);
        return $value !== null ? (string) $value : null;
    }

    /**
     * @inheritDoc
     */
    public function setResponseStatus(string $responseStatus): IdempotencyKeyInterface
    {
        return $this->setData(self::RESPONSE_STATUS, $responseStatus);
    }

    /**
     * @inheritDoc
     */
    public function getResponseBody(): ?string
    {
        $value = $this->getData(self::RESPONSE_BODY);
        return $value !== null ? (string) $value : null;
    }

    /**
     * @inheritDoc
     */
    public function setResponseBody(string $responseBody): IdempotencyKeyInterface
    {
        return $this->setData(self::RESPONSE_BODY, $responseBody);
    }

    /**
     * @inheritDoc
     */
    public function getCreatedAt(): ?string
    {
        $value = $this->getData(self::CREATED_AT);
        return $value !== null ? (string) $value : null;
    }

    /**
     * @inheritDoc
     */
    public function setCreatedAt(string $createdAt): IdempotencyKeyInterface
    {
        return $this->setData(self::CREATED_AT, $createdAt);
    }

    /**
     * @inheritDoc
     */
    public function getUpdatedAt(): ?string
    {
        $value = $this->getData(self::UPDATED_AT);
        return $value !== null ? (string) $value : null;
    }

    /**
     * @inheritDoc
     */
    public function setUpdatedAt(string $updatedAt): IdempotencyKeyInterface
    {
        return $this->setData(self::UPDATED_AT, $updatedAt);
    }
}
