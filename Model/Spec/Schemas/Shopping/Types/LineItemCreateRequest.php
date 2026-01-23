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
use Magebit\UcpSpec\MutableApi\Schemas\Shopping\Types\LineItemCreateRequestInterface;
use Magebit\UcpSpec\MutableApi\Schemas\Shopping\Types\ItemCreateRequestInterface;

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
     * @param ItemCreateRequestInterface $item
     * @return self
     */
    public function setItem(ItemCreateRequestInterface $item): self
    {
        $this->setData(LineItemCreateRequestInterface::KEY_ITEM, $item);
        return $this;
    }

    /**
     * @return int
     */
    public function getQuantity(): int
    {
        return $this->getDataInt(LineItemCreateRequestInterface::KEY_QUANTITY);
    }

    /**
     * @param int $quantity
     * @return self
     */
    public function setQuantity(int $quantity): self
    {
        $this->setData(LineItemCreateRequestInterface::KEY_QUANTITY, $quantity);
        return $this;
    }
}
