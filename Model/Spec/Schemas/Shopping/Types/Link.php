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
use Magebit\UcpSpec\Api\Schemas\Shopping\Types\LinkInterface;

class Link extends DataTransferObject implements LinkInterface
{
    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->getDataString(LinkInterface::KEY_TYPE);
    }

    /**
     * @return string
     */
    public function getUrl(): string
    {
        return $this->getDataString(LinkInterface::KEY_URL);
    }

    /**
     * @return string|null
     */
    public function getTitle(): string|null
    {
        return $this->getDataStringOrNull(LinkInterface::KEY_TITLE);
    }
}
