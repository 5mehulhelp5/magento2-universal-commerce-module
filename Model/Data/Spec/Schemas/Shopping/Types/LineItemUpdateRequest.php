<?php

/**
 * @author Magebit <info@magebit.com>
 * @copyright Copyright (c) Magebit, Ltd. (https://magebit.com)
 * @license https://magebit.com/code-license
 */

declare(strict_types=1);

namespace Magebit\UniversalCommerce\Model\Data\Spec\Schemas\Shopping\Types;

use Magebit\UcpSpec\MutableApi\Schemas\Shopping\Types\LineItemUpdateRequestInterface;
use Magebit\UcpSpec\MutableApi\Schemas\Shopping\Types\ItemUpdateRequestInterface;
use Magebit\UcpSpec\MutableApi\Schemas\Shopping\Types\ItemUpdateRequestInterfaceFactory;
use Magebit\UniversalCommerce\Model\Data\DataTransferObject;

/**
 * Line Item Update Request Model
 */
class LineItemUpdateRequest extends DataTransferObject implements LineItemUpdateRequestInterface
{
    /**
     * @param ItemUpdateRequestInterfaceFactory $itemFactory
     * @param array<mixed> $data
     */
    public function __construct(
        private readonly ItemUpdateRequestInterfaceFactory $itemFactory,
        array $data = []
    ) {
        parent::__construct($data);
    }

    /**
     * @inheritDoc
     */
    public function getId(): ?string
    {
        return $this->getDataStringOrNull(self::KEY_ID);
    }

    /**
     * @inheritDoc
     */
    public function setId(?string $id): LineItemUpdateRequestInterface
    {
        return $this->setData(self::KEY_ID, $id);
    }

    /**
     * @inheritDoc
     */
    public function getItem(): ItemUpdateRequestInterface
    {
        return $this->getDataInstance(self::KEY_ITEM, ItemUpdateRequestInterface::class, $this->itemFactory->create(...));
    }

    /**
     * @inheritDoc
     */
    public function setItem(ItemUpdateRequestInterface $item): LineItemUpdateRequestInterface
    {
        return $this->setData(self::KEY_ITEM, $item);
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
    public function setQuantity(int $quantity): LineItemUpdateRequestInterface
    {
        return $this->setData(self::KEY_QUANTITY, $quantity);
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
    public function setParentId(?string $parentId): LineItemUpdateRequestInterface
    {
        return $this->setData(self::KEY_PARENT_ID, $parentId);
    }
}
