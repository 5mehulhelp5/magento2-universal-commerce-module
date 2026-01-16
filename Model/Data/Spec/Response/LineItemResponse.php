<?php

/**
 * This file is part of the Magebit_UniversalCommerce package.
 *
 * @copyright Copyright (c) 2026 Magebit, Ltd. (https://magebit.com/)
 * @author    Magebit <info@magebit.com>
 * @license   MIT
 */

declare(strict_types=1);

namespace Magebit\UniversalCommerce\Model\Data\Spec\Response;

use Magebit\UniversalCommerce\Api\Data\Spec\Response\LineItemResponseInterface;
use Magebit\UniversalCommerce\Api\Data\Spec\Response\ItemResponseInterface;
use Magebit\UniversalCommerce\Api\Data\Spec\Response\ItemResponseInterfaceFactory;
use Magebit\UniversalCommerce\Api\Data\Spec\Response\TotalResponseInterface;
use Magebit\UniversalCommerce\Api\Data\Spec\Response\TotalResponseInterfaceFactory;
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
        return $this->getDataString(self::ID);
    }

    /**
     * @inheritDoc
     */
    public function setId(string $id): LineItemResponseInterface
    {
        return $this->setData(self::ID, $id);
    }

    /**
     * @inheritDoc
     */
    public function getItem(): ItemResponseInterface
    {
        return $this->getDataInstance(self::ITEM, ItemResponseInterface::class, $this->itemFactory->create(...));
    }

    /**
     * @inheritDoc
     */
    public function setItem(ItemResponseInterface $item): LineItemResponseInterface
    {
        return $this->setData(self::ITEM, $item);
    }

    /**
     * @inheritDoc
     */
    public function getParentId(): ?string
    {
        return $this->getDataStringOrNull(self::PARENT_ID);
    }

    /**
     * @inheritDoc
     */
    public function setParentId(?string $parentId): LineItemResponseInterface
    {
        return $this->setData(self::PARENT_ID, $parentId);
    }

    /**
     * @inheritDoc
     */
    public function getQuantity(): int
    {
        return $this->getDataInt(self::QUANTITY);
    }

    /**
     * @inheritDoc
     */
    public function setQuantity(int $quantity): LineItemResponseInterface
    {
        return $this->setData(self::QUANTITY, $quantity);
    }

    /**
     * @inheritDoc
     */
    public function getTotals(): array
    {
        return $this->getDataInstanceArray(
            self::TOTALS,
            TotalResponseInterface::class,
            $this->totalFactory->create(...)
        );
    }

    /**
     * @inheritDoc
     */
    public function setTotals(array $totals): LineItemResponseInterface
    {
        return $this->setData(self::TOTALS, $totals);
    }
}
