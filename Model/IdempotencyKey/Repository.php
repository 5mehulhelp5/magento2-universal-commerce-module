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
use Magebit\UniversalCommerce\Api\IdempotencyKeyRepositoryInterface;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use Psr\Log\LoggerInterface;

/**
 * Repository for Idempotency Key Model
 * Handles CRUD operations for idempotency key records
 */
class Repository implements IdempotencyKeyRepositoryInterface
{
    /**
     * @param ResourceModel $resourceModel
     * @param ModelFactory $idempotencyKeyFactory
     * @param LoggerInterface $logger
     */
    public function __construct(
        private readonly ResourceModel $resourceModel,
        private readonly ModelFactory $idempotencyKeyFactory,
        private readonly LoggerInterface $logger
    ) {
    }

    /**
     * @inheritDoc
     */
    public function save(IdempotencyKeyInterface $idempotencyKey): IdempotencyKeyInterface
    {
        try {
            /** @var Model $idempotencyKey */
            $this->resourceModel->save($idempotencyKey);
        } catch (\Exception $exception) {
            $this->logger->error($exception->getMessage());
            throw new CouldNotSaveException(
                __('Could not save the idempotency key record: %1', $exception->getMessage()),
                $exception
            );
        }

        return $idempotencyKey;
    }

    /**
     * @inheritDoc
     */
    public function getById(int $entityId): IdempotencyKeyInterface
    {
        $idempotencyKey = $this->idempotencyKeyFactory->create();
        $this->resourceModel->load($idempotencyKey, $entityId);

        if (!$idempotencyKey->getEntityId()) {
            throw new NoSuchEntityException(
                __('Idempotency key record with ID "%1" does not exist.', $entityId)
            );
        }

        return $idempotencyKey;
    }

    /**
     * @inheritDoc
     */
    public function getByKey(string $key): IdempotencyKeyInterface
    {
        $idempotencyKey = $this->idempotencyKeyFactory->create();
        $this->resourceModel->load($idempotencyKey, $key, IdempotencyKeyInterface::KEY);

        if (!$idempotencyKey->getEntityId()) {
            throw new NoSuchEntityException(
                __('Idempotency key record with key "%1" does not exist.', $key)
            );
        }

        return $idempotencyKey;
    }

    /**
     * @inheritDoc
     */
    public function claim(string $key, string $requestHash): bool
    {
        return $this->resourceModel->claim($key, $requestHash);
    }

    /**
     * @inheritDoc
     */
    public function reclaimAbandoned(string $key, string $requestHash, string $abandonedBefore): bool
    {
        return $this->resourceModel->reclaimAbandoned($key, $requestHash, $abandonedBefore);
    }

    /**
     * @inheritDoc
     */
    public function deleteExpired(string $expiredBefore): int
    {
        return $this->resourceModel->deleteExpired($expiredBefore);
    }

    /**
     * @inheritDoc
     */
    public function delete(IdempotencyKeyInterface $idempotencyKey): bool
    {
        try {
            /** @var Model $idempotencyKey */
            $this->resourceModel->delete($idempotencyKey);
        } catch (\Exception $exception) {
            $this->logger->error($exception->getMessage());
            throw new CouldNotDeleteException(
                __('Could not delete the idempotency key record: %1', $exception->getMessage()),
                $exception
            );
        }

        return true;
    }

    /**
     * @inheritDoc
     */
    public function deleteById(int $entityId): bool
    {
        return $this->delete($this->getById($entityId));
    }
}
