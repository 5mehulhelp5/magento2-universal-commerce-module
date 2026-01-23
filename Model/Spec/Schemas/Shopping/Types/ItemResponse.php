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
use Magebit\UcpSpec\Api\Schemas\Shopping\Types\ItemResponseInterface;

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
        $value = $this->getData(ItemResponseInterface::KEY_PRICE);
        if (!is_int($value)) {
            throw new \InvalidArgumentException(
                sprintf('Data for key %s is not an int', ItemResponseInterface::KEY_PRICE)
            );
        }
        return $value;
    }

    /**
     * @return string|null
     */
    public function getImageUrl(): string|null
    {
        return $this->getDataStringOrNull(ItemResponseInterface::KEY_IMAGE_URL);
    }
}
