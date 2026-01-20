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

use Magebit\UcpSpec\MutableApi\Schemas\Shopping\Types\TotalResponseInterface;
use Magebit\UniversalCommerce\Model\Data\DataTransferObject;

/**
 * Total Response Model
 */
class TotalResponse extends DataTransferObject implements TotalResponseInterface
{
    /**
     * @inheritDoc
     */
    public function getAmount(): int
    {
        return $this->getDataInt(self::KEY_AMOUNT);
    }

    /**
     * @inheritDoc
     */
    public function setAmount(int $amount): TotalResponseInterface
    {
        return $this->setData(self::KEY_AMOUNT, $amount);
    }

    /**
     * @inheritDoc
     */
    public function getDisplayText(): ?string
    {
        return $this->getDataStringOrNull(self::KEY_DISPLAY_TEXT);
    }

    /**
     * @inheritDoc
     */
    public function setDisplayText(?string $displayText): TotalResponseInterface
    {
        return $this->setData(self::KEY_DISPLAY_TEXT, $displayText);
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
    public function setType(string $type): TotalResponseInterface
    {
        return $this->setData(self::KEY_TYPE, $type);
    }
}
