<?php

/**
 * This file is part of the Magebit_UniversalCommerce package.
 *
 * @copyright Copyright (c) 2026 Magebit, Ltd. (https://magebit.com/)
 * @author    Magebit <info@magebit.com>
 * @license   MIT
 */

declare(strict_types=1);

namespace Magebit\UniversalCommerce\Model\Data\Response;

use Magebit\UniversalCommerce\Api\Data\Response\MessageInterface;
use Magento\Framework\DataObject;

/**
 * Message Model
 * Represents an error, warning, or info message
 */
class Message extends DataObject implements MessageInterface
{
    /**
     * @inheritDoc
     */
    public function getType(): string
    {
        return (string) $this->getData(self::TYPE);
    }

    /**
     * @inheritDoc
     */
    public function setType(string $type): MessageInterface
    {
        return $this->setData(self::TYPE, $type);
    }

    /**
     * @inheritDoc
     */
    public function getCode(): string
    {
        return (string) $this->getData(self::CODE);
    }

    /**
     * @inheritDoc
     */
    public function setCode(string $code): MessageInterface
    {
        return $this->setData(self::CODE, $code);
    }

    /**
     * @inheritDoc
     */
    public function getSeverity(): string
    {
        return (string) $this->getData(self::SEVERITY);
    }

    /**
     * @inheritDoc
     */
    public function setSeverity(string $severity): MessageInterface
    {
        return $this->setData(self::SEVERITY, $severity);
    }

    /**
     * @inheritDoc
     */
    public function getContent(): string
    {
        return (string) $this->getData(self::CONTENT);
    }

    /**
     * @inheritDoc
     */
    public function setContent(string $content): MessageInterface
    {
        return $this->setData(self::CONTENT, $content);
    }
}
