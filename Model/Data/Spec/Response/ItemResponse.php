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

use Magebit\UniversalCommerce\Api\Data\Spec\Response\ItemResponseInterface;
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
        return $this->getDataString(self::ID);
    }

    /**
     * @inheritDoc
     */
    public function setId(string $id): ItemResponseInterface
    {
        return $this->setData(self::ID, $id);
    }

    /**
     * @inheritDoc
     */
    public function getImageUrl(): ?string
    {
        return $this->getDataStringOrNull(self::IMAGE_URL);
    }

    /**
     * @inheritDoc
     */
    public function setImageUrl(?string $imageUrl): ItemResponseInterface
    {
        return $this->setData(self::IMAGE_URL, $imageUrl);
    }

    /**
     * @inheritDoc
     */
    public function getPrice(): float
    {
        return (float) $this->getData(self::PRICE);
    }

    /**
     * @inheritDoc
     */
    public function setPrice(float $price): ItemResponseInterface
    {
        return $this->setData(self::PRICE, $price);
    }

    /**
     * @inheritDoc
     */
    public function getTitle(): string
    {
        return $this->getDataString(self::TITLE);
    }

    /**
     * @inheritDoc
     */
    public function setTitle(string $title): ItemResponseInterface
    {
        return $this->setData(self::TITLE, $title);
    }
}
