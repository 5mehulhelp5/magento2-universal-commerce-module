<?php

/**
 * This file is part of the Magebit_UniversalCommerce package.
 *
 * @copyright Copyright (c) 2026 Magebit, Ltd. (https://magebit.com/)
 * @author    Magebit <info@magebit.com>
 * @license   MIT
 */

declare(strict_types=1);

namespace Magebit\UniversalCommerce\Test\Unit\Model\Stub;

use Magebit\UniversalCommerce\Model\DataTransferObject;

/**
 * Declares one map key so the base class behaviour can be exercised directly.
 */
class MapKeyedDto extends DataTransferObject
{
    /** @var string[] */
    protected array $jsonObjectKeys = ['payment_handlers'];
}
