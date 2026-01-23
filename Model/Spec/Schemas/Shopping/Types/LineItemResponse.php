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
use Magebit\UcpSpec\MutableApi\Schemas\Shopping\Types\LineItemResponseInterface;
use Magebit\UcpSpec\MutableApi\Schemas\Shopping\Types\ItemResponseInterface;
use Magebit\UcpSpec\MutableApi\Schemas\Shopping\Types\TotalResponseInterface;

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
        return $this->getDataInt(LineItemResponseInterface::KEY_QUANTITY);
    }

    /**
     * @return TotalResponseInterface[]
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

    /**
     * @param string $id
     * @return self
     */
    public function setId(string $id): self
    {
        $this->setData(LineItemResponseInterface::KEY_ID, $id);
        return $this;
    }

    /**
     * @param ItemResponseInterface $item
     * @return self
     */
    public function setItem(ItemResponseInterface $item): self
    {
        $this->setData(LineItemResponseInterface::KEY_ITEM, $item);
        return $this;
    }

    /**
     * @param int $quantity
     * @return self
     */
    public function setQuantity(int $quantity): self
    {
        $this->setData(LineItemResponseInterface::KEY_QUANTITY, $quantity);
        return $this;
    }

    /**
     * @param TotalResponseInterface[] $totals
     * @return self
     */
    public function setTotals(array $totals): self
    {
        $this->setData(LineItemResponseInterface::KEY_TOTALS, $totals);
        return $this;
    }

    /**
     * @param string|null $parentId
     * @return self
     */
    public function setParentId(?string $parentId): self
    {
        $this->setData(LineItemResponseInterface::KEY_PARENT_ID, $parentId);
        return $this;
    }
}
