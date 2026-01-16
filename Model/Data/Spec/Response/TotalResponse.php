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

use Magebit\UniversalCommerce\Api\Data\Spec\Response\TotalResponseInterface;
use Magebit\UniversalCommerce\Model\Data\DataTransferObject;

/**
 * Total Response Model
 */
class TotalResponse extends DataTransferObject implements TotalResponseInterface
{
    /**
     * @inheritDoc
     */
    public function getAmount(): float
    {
        return (float) $this->getData(self::AMOUNT);
    }

    /**
     * @inheritDoc
     */
    public function setAmount(float $amount): TotalResponseInterface
    {
        return $this->setData(self::AMOUNT, $amount);
    }

    /**
     * @inheritDoc
     */
    public function getDisplayText(): ?string
    {
        return $this->getDataStringOrNull(self::DISPLAY_TEXT);
    }

    /**
     * @inheritDoc
     */
    public function setDisplayText(?string $displayText): TotalResponseInterface
    {
        return $this->setData(self::DISPLAY_TEXT, $displayText);
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
    public function setType(string $type): TotalResponseInterface
    {
        return $this->setData(self::TYPE, $type);
    }
}
