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
use Magebit\UcpSpec\Api\Schemas\Shopping\Types\LineItemResponseInterface;
use Magebit\UcpSpec\Api\Schemas\Shopping\Types\ItemResponseInterface;
use Magebit\UcpSpec\Api\Schemas\Shopping\Types\TotalResponseInterface;

class LineItemResponse extends DataTransferObject implements LineItemResponseInterface
{
    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->getDataString(LineItemResponseInterface::KEY_ID);
    }

    /**
     * @return ItemResponseInterface
     */
    public function getItem(): ItemResponseInterface
    {
        return $this->getDataOfType(LineItemResponseInterface::KEY_ITEM, ItemResponseInterface::class);
    }

    /**
     * @return int
     */
    public function getQuantity(): int
    {
        $value = $this->getData(LineItemResponseInterface::KEY_QUANTITY);
        if (!is_int($value)) {
            throw new \InvalidArgumentException(
                sprintf('Data for key %s is not an int', LineItemResponseInterface::KEY_QUANTITY)
            );
        }
        return $value;
    }

    /**
     * @return array<TotalResponseInterface>
     */
    public function getTotals(): array
    {
        return $this->getDataArrayOfType(
            LineItemResponseInterface::KEY_TOTALS,
            TotalResponseInterface::class
        );
    }

    /**
     * @return string|null
     */
    public function getParentId(): string|null
    {
        return $this->getDataStringOrNull(LineItemResponseInterface::KEY_PARENT_ID);
    }
}
