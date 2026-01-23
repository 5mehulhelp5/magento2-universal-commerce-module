<?php

/**
 * @author Magebit <info@magebit.com>
 * @copyright Copyright (c) Magebit, Ltd. (https://magebit.com)
 * @license https://magebit.com/code-license
 */

declare(strict_types=1);

namespace Magebit\UniversalCommerce\Model\Spec\Schemas\Shopping\Types;

use Magebit\UniversalCommerce\Model\DataTransferObject;
use Magebit\UcpSpec\MutableApi\Schemas\Shopping\Types\ItemUpdateRequestInterface;

class ItemUpdateRequest extends DataTransferObject implements ItemUpdateRequestInterface
{
    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->getDataString(ItemUpdateRequestInterface::KEY_ID);
    }

    /**
     * @param string $id
     * @return self
     */
    public function setId(string $id): self
    {
        $this->setData(ItemUpdateRequestInterface::KEY_ID, $id);
        return $this;
    }
}
