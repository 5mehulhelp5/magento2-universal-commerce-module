<?php

/**
 * This file is part of the Magebit_UniversalCommerce package.
 *
 * @copyright Copyright (c) 2026 Magebit, Ltd. (https://magebit.com/)
 * @author    Magebit <info@magebit.com>
 * @license   MIT
 */

declare(strict_types=1);

namespace Magebit\UniversalCommerce\Model\Data\Spec;

use Magebit\UniversalCommerce\Api\Data\Spec\LineItemCreateRequestInterface;
use Magebit\UniversalCommerce\Api\Data\Spec\ItemCreateRequestInterface;
use Magebit\UniversalCommerce\Api\Data\Spec\ItemCreateRequestInterfaceFactory;
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
        return $this->getDataInstance(self::ITEM, ItemCreateRequestInterface::class, $this->itemFactory->create(...));
    }

    /**
     * @inheritDoc
     */
    public function setItem(ItemCreateRequestInterface $item): LineItemCreateRequestInterface
    {
        return $this->setData(self::ITEM, $item);
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
    public function setQuantity(int $quantity): LineItemCreateRequestInterface
    {
        return $this->setData(self::QUANTITY, $quantity);
    }
}
