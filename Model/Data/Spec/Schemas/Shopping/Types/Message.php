<?php

/**
 * @author Magebit <info@magebit.com>
 * @copyright Copyright (c) Magebit, Ltd. (https://magebit.com)
 * @license https://magebit.com/code-license
 */

declare(strict_types=1);

namespace Magebit\UniversalCommerce\Model\Data\Spec\Schemas\Shopping\Types;

use Magebit\UcpSpec\MutableApi\Schemas\Shopping\Types\MessageInterface;
use Magebit\UniversalCommerce\Model\Data\DataTransferObject;

/**
 * Message Model
 */
class Message extends DataTransferObject implements MessageInterface
{
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
    public function setType(string $type): MessageInterface
    {
        return $this->setData(self::KEY_TYPE, $type);
    }

    /**
     * @inheritDoc
     */
    public function getCode(): string
    {
        return $this->getDataString(self::KEY_CODE);
    }

    /**
     * @inheritDoc
     */
    public function setCode(string $code): MessageInterface
    {
        return $this->setData(self::KEY_CODE, $code);
    }

    /**
     * @inheritDoc
     */
    public function getPath(): ?string
    {
        return $this->getDataStringOrNull(self::KEY_PATH);
    }

    /**
     * @inheritDoc
     */
    public function setPath(?string $path): MessageInterface
    {
        return $this->setData(self::KEY_PATH, $path);
    }

    /**
     * @inheritDoc
     */
    public function getContentType(): ?string
    {
        return $this->getDataStringOrNull(self::KEY_CONTENT_TYPE);
    }

    /**
     * @inheritDoc
     */
    public function setContentType(?string $contentType): MessageInterface
    {
        return $this->setData(self::KEY_CONTENT_TYPE, $contentType);
    }

    /**
     * @inheritDoc
     */
    public function getContent(): string
    {
        return $this->getDataString(self::KEY_CONTENT);
    }

    /**
     * @inheritDoc
     */
    public function setContent(string $content): MessageInterface
    {
        return $this->setData(self::KEY_CONTENT, $content);
    }

    /**
     * @inheritDoc
     */
    public function getSeverity(): string
    {
        return $this->getDataString(self::KEY_SEVERITY);
    }

    /**
     * @inheritDoc
     */
    public function setSeverity(string $severity): MessageInterface
    {
        return $this->setData(self::KEY_SEVERITY, $severity);
    }
}
