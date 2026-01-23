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
use Magebit\UcpSpec\MutableApi\Schemas\Shopping\Types\TotalResponseInterface;

class TotalResponse extends DataTransferObject implements TotalResponseInterface
{
    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->getDataString(TotalResponseInterface::KEY_TYPE);
    }

    /**
     * @return string|null
     */
    public function getDisplayText(): string|null
    {
        return $this->getDataStringOrNull(TotalResponseInterface::KEY_DISPLAY_TEXT);
    }

    /**
     * @return int
     */
    public function getAmount(): int
    {
        return $this->getDataInt(TotalResponseInterface::KEY_AMOUNT);
    }

    /**
     * @param string $type
     * @return self
     */
    public function setType(string $type): self
    {
        $this->setData(TotalResponseInterface::KEY_TYPE, $type);
        return $this;
    }

    /**
     * @param string|null $displayText
     * @return self
     */
    public function setDisplayText(?string $displayText): self
    {
        $this->setData(TotalResponseInterface::KEY_DISPLAY_TEXT, $displayText);
        return $this;
    }

    /**
     * @param int $amount
     * @return self
     */
    public function setAmount(int $amount): self
    {
        $this->setData(TotalResponseInterface::KEY_AMOUNT, $amount);
        return $this;
    }
}
