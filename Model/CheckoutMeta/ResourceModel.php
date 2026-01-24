<?php

/**
 * @author Magebit <info@magebit.com>
 * @copyright Copyright (c) Magebit, Ltd. (https://magebit.com)
 * @license https://magebit.com/code-license
 */

declare(strict_types=1);

namespace Magebit\UniversalCommerce\Model\CheckoutMeta;

use Magebit\UniversalCommerce\Api\Data\CheckoutMetaInterface;
use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

/**
 * Checkout Meta Resource Model
 */
class ResourceModel extends AbstractDb
{
    private const TABLE_NAME = 'ucp_checkout_meta';

    /**
     * Initialize resource model
     *
     * @return void
     */
    protected function _construct(): void
    {
        $this->_init(self::TABLE_NAME, CheckoutMetaInterface::ENTITY_ID);
    }
}
