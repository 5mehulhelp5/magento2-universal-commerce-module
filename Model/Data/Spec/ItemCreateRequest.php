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

use Magebit\UniversalCommerce\Api\Data\Spec\ItemCreateRequestInterface;
use Magebit\UniversalCommerce\Model\Data\DataTransferObject;

/**
 * Item Create Request Model
 */
class ItemCreateRequest extends DataTransferObject implements ItemCreateRequestInterface
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
    public function setId(string $id): ItemCreateRequestInterface
    {
        return $this->setData(self::ID, $id);
    }
}
