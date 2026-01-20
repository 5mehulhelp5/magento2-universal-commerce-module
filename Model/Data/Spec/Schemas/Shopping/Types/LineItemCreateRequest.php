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

use Magebit\UcpSpec\MutableApi\Schemas\Shopping\Types\LineItemCreateRequestInterface;
use Magebit\UcpSpec\MutableApi\Schemas\Shopping\Types\ItemCreateRequestInterface;
use Magebit\UcpSpec\MutableApi\Schemas\Shopping\Types\ItemCreateRequestInterfaceFactory;
use Magebit\UniversalCommerce\Model\Data\DataTransferObject;

/**
 * Line Item Create Request Model
 */
class LineItemCreateRequest extends DataTransferObject implements LineItemCreateRequestInterface
{
    /**
     * @param ItemCreateRequestInterfaceFactory $itemFactory
     * @param array<mixed> $data
     */
    public function __construct(
        private readonly ItemCreateRequestInterfaceFactory $itemFactory,
        array $data = []
    ) {
        parent::__construct($data);
    }

    /**
     * @inheritDoc
     */
    public function getItem(): ItemCreateRequestInterface
    {
        return $this->getDataInstance(self::KEY_ITEM, ItemCreateRequestInterface::class, $this->itemFactory->create(...));
    }

    /**
     * @inheritDoc
     */
    public function setItem(ItemCreateRequestInterface $item): LineItemCreateRequestInterface
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
    public function setQuantity(int $quantity): LineItemCreateRequestInterface
    {
        return $this->setData(self::KEY_QUANTITY, $quantity);
    }
}
