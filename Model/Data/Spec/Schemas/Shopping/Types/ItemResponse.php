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

use Magebit\UcpSpec\MutableApi\Schemas\Shopping\Types\ItemResponseInterface;
use Magebit\UniversalCommerce\Model\Data\DataTransferObject;

/**
 * Item Response Model
 */
class ItemResponse extends DataTransferObject implements ItemResponseInterface
{
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
    public function setId(string $id): ItemResponseInterface
    {
        return $this->setData(self::KEY_ID, $id);
    }

    /**
     * @inheritDoc
     */
    public function getImageUrl(): ?string
    {
        return $this->getDataStringOrNull(self::KEY_IMAGE_URL);
    }

    /**
     * @inheritDoc
     */
    public function setImageUrl(?string $imageUrl): ItemResponseInterface
    {
        return $this->setData(self::KEY_IMAGE_URL, $imageUrl);
    }

    /**
     * @inheritDoc
     */
    public function getPrice(): int
    {
        return $this->getDataInt(self::KEY_PRICE);
    }

    /**
     * @inheritDoc
     */
    public function setPrice(int $price): ItemResponseInterface
    {
        return $this->setData(self::KEY_PRICE, $price);
    }

    /**
     * @inheritDoc
     */
    public function getTitle(): string
    {
        return $this->getDataString(self::KEY_TITLE);
    }

    /**
     * @inheritDoc
     */
    public function setTitle(string $title): ItemResponseInterface
    {
        return $this->setData(self::KEY_TITLE, $title);
    }
}
