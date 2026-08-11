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
     * Atomically claim a key so that only one concurrent caller executes the operation.
     *
     * @param string $key
     * @param string $requestHash
     * @return bool True when this caller won the claim.
     */
    public function claim(string $key, string $requestHash): bool;

    /**
     * Take over a claim whose owner died before storing a response.
     *
     * @param string $key
     * @param string $requestHash
     * @param string $abandonedBefore UTC datetime; claims created before it are considered abandoned.
     * @return bool True when this caller took the claim over.
     */
    public function reclaimAbandoned(string $key, string $requestHash, string $abandonedBefore): bool;

    /**
     * Delete records created before the given point in time.
     *
     * @param string $expiredBefore UTC datetime.
     * @return int Number of deleted rows.
     */
    public function deleteExpired(string $expiredBefore): int;

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
