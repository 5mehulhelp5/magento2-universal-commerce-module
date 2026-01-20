<?php

/**
 * This file is part of the Magebit_UniversalCommerce package.
 *
 * @copyright Copyright (c) 2026 Magebit, Ltd. (https://magebit.com/)
 * @author    Magebit <info@magebit.com>
 * @license   MIT
 */

declare(strict_types=1);

namespace Magebit\UniversalCommerce\Model\Data\Spec\Schemas\Shopping\Types;

use Magebit\UcpSpec\MutableApi\Schemas\Shopping\Types\LineItemResponseInterface;
use Magebit\UcpSpec\MutableApi\Schemas\Shopping\Types\ItemResponseInterface;
use Magebit\UcpSpec\MutableApi\Schemas\Shopping\Types\ItemResponseInterfaceFactory;
use Magebit\UcpSpec\MutableApi\Schemas\Shopping\Types\TotalResponseInterface;
use Magebit\UcpSpec\MutableApi\Schemas\Shopping\Types\TotalResponseInterfaceFactory;
use Magebit\UniversalCommerce\Model\Data\DataTransferObject;

/**
 * Line Item Response Model
 */
class LineItemResponse extends DataTransferObject implements LineItemResponseInterface
{
    /**
     * @param ItemResponseInterfaceFactory $itemFactory
     * @param TotalResponseInterfaceFactory $totalFactory
     * @param array<mixed> $data
     */
    public function __construct(
        private readonly ItemResponseInterfaceFactory $itemFactory,
        private readonly TotalResponseInterfaceFactory $totalFactory,
        array $data = []
    ) {
        parent::__construct($data);
    }

    /**
     * @inheritDoc
     */
    public function getId(): string
    {
        return $this->getDataString(self::KEY_ID);
    }

    /**
     * @inheritDoc
     */
    public function setId(string $id): LineItemResponseInterface
    {
        return $this->setData(self::KEY_ID, $id);
    }

    /**
     * @inheritDoc
     */
    public function getItem(): ItemResponseInterface
    {
        return $this->getDataInstance(self::KEY_ITEM, ItemResponseInterface::class, $this->itemFactory->create(...));
    }

    /**
     * @inheritDoc
     */
    public function setItem(ItemResponseInterface $item): LineItemResponseInterface
    {
        return $this->setData(self::KEY_ITEM, $item);
    }

    /**
     * @inheritDoc
     */
    public function getParentId(): ?string
    {
        return $this->getDataStringOrNull(self::KEY_PARENT_ID);
    }

    /**
     * @inheritDoc
     */
    public function setParentId(?string $parentId): LineItemResponseInterface
    {
        return $this->setData(self::KEY_PARENT_ID, $parentId);
    }

    /**
     * @inheritDoc
     */
    public function getQuantity(): int
    {
        return $this->getDataInt(self::KEY_QUANTITY);
    }

    /**
     * @inheritDoc
     */
    public function setQuantity(int $quantity): LineItemResponseInterface
    {
        return $this->setData(self::KEY_QUANTITY, $quantity);
    }

    /**
     * @inheritDoc
     */
    public function getTotals(): array
    {
        return $this->getDataInstanceArray(
            self::KEY_TOTALS,
            TotalResponseInterface::class,
            $this->totalFactory->create(...)
        );
    }

    /**
     * @inheritDoc
     */
    public function setTotals(array $totals): LineItemResponseInterface
    {
        return $this->setData(self::KEY_TOTALS, $totals);
    }
}
