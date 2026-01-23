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
use Magebit\UcpSpec\MutableApi\Schemas\Shopping\Types\ItemResponseInterface;

class ItemResponse extends DataTransferObject implements ItemResponseInterface
{
    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->getDataString(ItemResponseInterface::KEY_ID);
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->getDataString(ItemResponseInterface::KEY_TITLE);
    }

    /**
     * @return int
     */
    public function getPrice(): int
    {
        return $this->getDataInt(ItemResponseInterface::KEY_PRICE);
    }

    /**
     * @return string|null
     */
    public function getImageUrl(): string|null
    {
        return $this->getDataStringOrNull(ItemResponseInterface::KEY_IMAGE_URL);
    }

    /**
     * @param string $id
     * @return self
     */
    public function setId(string $id): self
    {
        $this->setData(ItemResponseInterface::KEY_ID, $id);
        return $this;
    }

    /**
     * @param string $title
     * @return self
     */
    public function setTitle(string $title): self
    {
        $this->setData(ItemResponseInterface::KEY_TITLE, $title);
        return $this;
    }

    /**
     * @param int $price
     * @return self
     */
    public function setPrice(int $price): self
    {
        $this->setData(ItemResponseInterface::KEY_PRICE, $price);
        return $this;
    }

    /**
     * @param string|null $imageUrl
     * @return self
     */
    public function setImageUrl(?string $imageUrl): self
    {
        $this->setData(ItemResponseInterface::KEY_IMAGE_URL, $imageUrl);
        return $this;
    }
}
