<?php

/**
 * @author Magebit <info@magebit.com>
 * @copyright Copyright (c) Magebit, Ltd. (https://magebit.com)
 * @license https://magebit.com/code-license
 */

declare(strict_types=1);

namespace Magebit\UniversalCommerce\Model\Spec\Schemas\Shopping\Types;

use Magebit\UniversalCommerce\Model\DataTransferObject;
use Magebit\UcpSpec\MutableApi\Schemas\Shopping\Types\LineItemUpdateRequestInterface;
use Magebit\UcpSpec\MutableApi\Schemas\Shopping\Types\ItemUpdateRequestInterface;

class LineItemUpdateRequest extends DataTransferObject implements LineItemUpdateRequestInterface
{
    /**
     * @return string|null
     */
    public function getId(): string|null
    {
        return $this->getDataStringOrNull(LineItemUpdateRequestInterface::KEY_ID);
    }

    /**
     * @param string|null $id
     * @return self
     */
    public function setId(?string $id): self
    {
        $this->setData(LineItemUpdateRequestInterface::KEY_ID, $id);
        return $this;
    }

    /**
     * @return ItemUpdateRequestInterface
     */
    public function getItem(): ItemUpdateRequestInterface
    {
        return $this->getDataOfType(LineItemUpdateRequestInterface::KEY_ITEM, ItemUpdateRequestInterface::class);
    }

    /**
     * @param ItemUpdateRequestInterface $item
     * @return self
     */
    public function setItem(ItemUpdateRequestInterface $item): self
    {
        $this->setData(LineItemUpdateRequestInterface::KEY_ITEM, $item);
        return $this;
    }

    /**
     * @return int
     */
    public function getQuantity(): int
    {
        return $this->getDataInt(LineItemUpdateRequestInterface::KEY_QUANTITY);
    }

    /**
     * @param int $quantity
     * @return self
     */
    public function setQuantity(int $quantity): self
    {
        $this->setData(LineItemUpdateRequestInterface::KEY_QUANTITY, $quantity);
        return $this;
    }

    /**
     * @return string|null
     */
    public function getParentId(): string|null
    {
        return $this->getDataStringOrNull(LineItemUpdateRequestInterface::KEY_PARENT_ID);
    }

    /**
     * @param string|null $parentId
     * @return self
     */
    public function setParentId(?string $parentId): self
    {
        $this->setData(LineItemUpdateRequestInterface::KEY_PARENT_ID, $parentId);
        return $this;
    }
}
