<?php

/**
 * This file is part of the Magebit_UniversalCommerce package.
 *
 * @copyright Copyright (c) 2026 Magebit, Ltd. (https://magebit.com/)
 * @author    Magebit <info@magebit.com>
 * @license   MIT
 */

declare(strict_types=1);

namespace Magebit\UniversalCommerce\Api;

use Magebit\UniversalCommerce\Api\Data\IdempotencyKeyInterface;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;

/**
 * Repository Interface for Idempotency Key Model
 * Provides CRUD operations and retrieval methods for idempotency key records
 */
interface IdempotencyKeyRepositoryInterface
{
    /**
     * Save idempotency key record
     *
     * @param IdempotencyKeyInterface $idempotencyKey
     * @return IdempotencyKeyInterface
     * @throws CouldNotSaveException
     */
    public function save(IdempotencyKeyInterface $idempotencyKey): IdempotencyKeyInterface;

    /**
     * Get idempotency key record by ID
     *
     * @param int $entityId
     * @return IdempotencyKeyInterface
     * @throws NoSuchEntityException
     */
    public function getById(int $entityId): IdempotencyKeyInterface;

    /**
     * Get idempotency key record by key
     *
     * @param string $key
     * @return IdempotencyKeyInterface
     * @throws NoSuchEntityException
     */
    public function getByKey(string $key): IdempotencyKeyInterface;

    /**
     * Delete idempotency key record
     *
     * @param IdempotencyKeyInterface $idempotencyKey
     * @return bool
     * @throws CouldNotDeleteException
     */
    public function delete(IdempotencyKeyInterface $idempotencyKey): bool;

    /**
     * Delete idempotency key record by ID
     *
     * @param int $entityId
     * @return bool
     * @throws CouldNotDeleteException
     * @throws NoSuchEntityException
     */
    public function deleteById(int $entityId): bool;
}
