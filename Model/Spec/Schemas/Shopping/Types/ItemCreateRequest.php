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
use Magebit\UcpSpec\MutableApi\Schemas\Shopping\Types\ItemCreateRequestInterface;

class ItemCreateRequest extends DataTransferObject implements ItemCreateRequestInterface
{
    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->getDataString(ItemCreateRequestInterface::KEY_ID);
    }

    /**
     * @param string $id
     * @return self
     */
    public function setId(string $id): self
    {
        $this->setData(ItemCreateRequestInterface::KEY_ID, $id);
        return $this;
    }
}
