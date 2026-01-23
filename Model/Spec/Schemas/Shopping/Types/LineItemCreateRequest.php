<?php

/**
 * This file is part of the Magebit_UniversalCommerce package.
 *
 * @copyright Copyright (c) 2026 Magebit, Ltd. (https://magebit.com/)
 * @author    Magebit <info@magebit.com>
 * @license   MIT
 */

declare(strict_types=1);

namespace Magebit\UniversalCommerce\Model\Spec\Schemas\Shopping\Types;

use Magebit\UniversalCommerce\Model\DataTransferObject;
use Magebit\UcpSpec\Api\Schemas\Shopping\Types\LineItemCreateRequestInterface;
use Magebit\UcpSpec\Api\Schemas\Shopping\Types\ItemCreateRequestInterface;

class LineItemCreateRequest extends DataTransferObject implements LineItemCreateRequestInterface
{
    /**
     * @return ItemCreateRequestInterface
     */
    public function getItem(): ItemCreateRequestInterface
    {
        return $this->getDataOfType(LineItemCreateRequestInterface::KEY_ITEM, ItemCreateRequestInterface::class);
    }

    /**
     * @return int
     */
    public function getQuantity(): int
    {
        $value = $this->getData(LineItemCreateRequestInterface::KEY_QUANTITY);
        if (!is_int($value)) {
            throw new \InvalidArgumentException(
                sprintf('Data for key %s is not an int', LineItemCreateRequestInterface::KEY_QUANTITY)
            );
        }
        return $value;
    }
}
