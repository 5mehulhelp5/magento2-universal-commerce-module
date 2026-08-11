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

use Magebit\UniversalCommerce\Api\IdempotencyKeyRepositoryInterface;
use Magebit\UniversalCommerce\Model\Config;
use Magento\Framework\Stdlib\DateTime\DateTime;

/**
 * Cron entry point that purges stored idempotent responses past their configured TTL.
 */
class Cleanup
{
    private const SECONDS_PER_HOUR = 3600;

    /**
     * @param IdempotencyKeyRepositoryInterface $idempotencyRepository
     * @param Config $config
     * @param DateTime $dateTime
     */
    public function __construct(
        private readonly IdempotencyKeyRepositoryInterface $idempotencyRepository,
        private readonly Config $config,
        private readonly DateTime $dateTime
    ) {
    }

    /**
     * @return int Number of deleted rows.
     */
    public function execute(): int
    {
        $ttlHours = $this->config->getIdempotencyTtlHours();

        if ($ttlHours < 1) {
            return 0;
        }

        $expiredBefore = $this->dateTime->gmtDate(
            'Y-m-d H:i:s',
            $this->dateTime->gmtTimestamp() - $ttlHours * self::SECONDS_PER_HOUR
        );

        return $this->idempotencyRepository->deleteExpired($expiredBefore);
    }
}
