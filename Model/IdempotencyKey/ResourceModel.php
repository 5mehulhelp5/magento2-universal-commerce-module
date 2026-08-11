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
use Magento\Framework\DB\Adapter\AdapterInterface;
use Magento\Framework\DB\Adapter\DuplicateException;
use Magento\Framework\DB\Sql\Expression;
use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

/**
 * Idempotency Key Resource Model
 */
class ResourceModel extends AbstractDb
{
    private const TABLE_NAME = 'ucp_idempotency_keys';

    /**
     * Initialize resource model
     *
     * @return void
     */
    protected function _construct(): void
    {
        $this->_init(self::TABLE_NAME, IdempotencyKeyInterface::ENTITY_ID);
    }

    /**
     * Insert a claim row, relying on the unique key to arbitrate concurrent callers.
     *
     * @param string $key
     * @param string $requestHash
     * @return bool True when this caller won the claim.
     */
    public function claim(string $key, string $requestHash): bool
    {
        try {
            $this->connection()->insert($this->getMainTable(), [
                IdempotencyKeyInterface::KEY => $key,
                IdempotencyKeyInterface::REQUEST_HASH => $requestHash,
                IdempotencyKeyInterface::RESPONSE_STATUS => null,
                IdempotencyKeyInterface::RESPONSE_BODY => null,
            ]);
        } catch (DuplicateException $exception) {
            return false;
        }

        return true;
    }

    /**
     * Take over a claim whose owner died before storing a response.
     *
     * @param string $key
     * @param string $requestHash
     * @param string $abandonedBefore UTC datetime; claims created before it are considered abandoned.
     * @return bool True when this caller took the claim over.
     */
    public function reclaimAbandoned(string $key, string $requestHash, string $abandonedBefore): bool
    {
        $connection = $this->connection();

        $affected = $connection->update(
            $this->getMainTable(),
            [
                IdempotencyKeyInterface::REQUEST_HASH => $requestHash,
                IdempotencyKeyInterface::CREATED_AT => new Expression('UTC_TIMESTAMP()'),
            ],
            [
                $connection->quoteIdentifier(IdempotencyKeyInterface::KEY) . ' = ?' => $key,
                IdempotencyKeyInterface::RESPONSE_STATUS . ' IS NULL',
                IdempotencyKeyInterface::CREATED_AT . ' < ?' => $abandonedBefore,
            ]
        );

        return $affected > 0;
    }

    /**
     * @param string $expiredBefore UTC datetime; rows created before it are removed.
     * @return int Number of deleted rows.
     */
    public function deleteExpired(string $expiredBefore): int
    {
        return $this->connection()->delete(
            $this->getMainTable(),
            [IdempotencyKeyInterface::CREATED_AT . ' < ?' => $expiredBefore]
        );
    }

    /**
     * getConnection() is typed AdapterInterface|false upstream, but a resource model
     * without a connection cannot work.
     *
     * @return AdapterInterface
     * @throws \RuntimeException
     */
    private function connection(): AdapterInterface
    {
        $connection = $this->getConnection();

        if ($connection === false) {
            throw new \RuntimeException('No database connection available.');
        }

        return $connection;
    }
}
