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
use Magebit\UcpSpec\Api\Schemas\Shopping\Types\MessageInterface;

class Message extends DataTransferObject implements MessageInterface
{
    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->getDataString(MessageInterface::KEY_TYPE);
    }

    /**
     * @return string
     */
    public function getCode(): string
    {
        return $this->getDataString(MessageInterface::KEY_CODE);
    }

    /**
     * @return string|null
     */
    public function getPath(): string|null
    {
        return $this->getDataStringOrNull(MessageInterface::KEY_PATH);
    }

    /**
     * @return string|null
     */
    public function getContentType(): string|null
    {
        return $this->getDataStringOrNull(MessageInterface::KEY_CONTENT_TYPE);
    }

    /**
     * @return string
     */
    public function getContent(): string
    {
        return $this->getDataString(MessageInterface::KEY_CONTENT);
    }

    /**
     * @return string
     */
    public function getSeverity(): string
    {
        return $this->getDataString(MessageInterface::KEY_SEVERITY);
    }
}
