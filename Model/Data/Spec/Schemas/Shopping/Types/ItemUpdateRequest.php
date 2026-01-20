<?php

/**
 * @author Magebit <info@magebit.com>
 * @copyright Copyright (c) Magebit, Ltd. (https://magebit.com)
 * @license https://magebit.com/code-license
 */

declare(strict_types=1);

namespace Magebit\UniversalCommerce\Model\Data\Spec\Schemas\Shopping\Types;

use Magebit\UcpSpec\MutableApi\Schemas\Shopping\Types\ItemUpdateRequestInterface;
use Magebit\UniversalCommerce\Model\Data\DataTransferObject;

/**
 * Item Update Request Model
 */
class ItemUpdateRequest extends DataTransferObject implements ItemUpdateRequestInterface
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
    public function setId(string $id): ItemUpdateRequestInterface
    {
        return $this->setData(self::KEY_ID, $id);
    }
}
