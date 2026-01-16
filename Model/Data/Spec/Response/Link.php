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

use Magebit\UniversalCommerce\Api\Data\Spec\Response\LinkInterface;
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
        return $this->getDataStringOrNull(self::TITLE);
    }

    /**
     * @inheritDoc
     */
    public function setTitle(?string $title): LinkInterface
    {
        return $this->setData(self::TITLE, $title);
    }

    /**
     * @inheritDoc
     */
    public function getType(): string
    {
        return $this->getDataString(self::TYPE);
    }

    /**
     * @inheritDoc
     */
    public function setType(string $type): LinkInterface
    {
        return $this->setData(self::TYPE, $type);
    }

    /**
     * @inheritDoc
     */
    public function getUrl(): string
    {
        return $this->getDataString(self::URL);
    }

    /**
     * @inheritDoc
     */
    public function setUrl(string $url): LinkInterface
    {
        return $this->setData(self::URL, $url);
    }
}
