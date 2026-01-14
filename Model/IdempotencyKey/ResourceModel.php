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
}
