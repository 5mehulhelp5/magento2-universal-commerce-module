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

use Magebit\UcpSpec\MutableApi\Schemas\Shopping\Types\LinkInterface;
use Magebit\UniversalCommerce\Model\Data\DataTransferObject;

/**
 * Link Model
 */
class Link extends DataTransferObject implements LinkInterface
{
    /**
     * @inheritDoc
     */
    public function getTitle(): ?string
    {
        return $this->getDataStringOrNull(self::KEY_TITLE);
    }

    /**
     * @inheritDoc
     */
    public function setTitle(?string $title): LinkInterface
    {
        return $this->setData(self::KEY_TITLE, $title);
    }

    /**
     * @inheritDoc
     */
    public function getType(): string
    {
        return $this->getDataString(self::KEY_TYPE);
    }

    /**
     * @inheritDoc
     */
    public function setType(string $type): LinkInterface
    {
        return $this->setData(self::KEY_TYPE, $type);
    }

    /**
     * @inheritDoc
     */
    public function getUrl(): string
    {
        return $this->getDataString(self::KEY_URL);
    }

    /**
     * @inheritDoc
     */
    public function setUrl(string $url): LinkInterface
    {
        return $this->setData(self::KEY_URL, $url);
    }
}
