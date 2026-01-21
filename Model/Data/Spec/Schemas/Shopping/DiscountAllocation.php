<?php

/**
 * @author Magebit <info@magebit.com>
 * @copyright Copyright (c) Magebit, Ltd. (https://magebit.com)
 * @license https://magebit.com/code-license
 */

declare(strict_types=1);

namespace Magebit\UniversalCommerce\Model\Data\Spec\Schemas\Shopping;

use Magebit\UcpSpec\MutableApi\Schemas\Shopping\DiscountAllocationInterface;
use Magebit\UniversalCommerce\Model\Data\DataTransferObject;

/**
 * Discount Allocation Model
 */
class DiscountAllocation extends DataTransferObject implements DiscountAllocationInterface
{
    /**
     * @inheritDoc
     */
    public function getPath(): string
    {
        return $this->getDataString(self::KEY_PATH);
    }

    /**
     * @inheritDoc
     */
    public function setPath(string $path): self
    {
        return $this->setData(self::KEY_PATH, $path);
    }

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
    public function setAmount(int $amount): self
    {
        return $this->setData(self::KEY_AMOUNT, $amount);
    }
}
