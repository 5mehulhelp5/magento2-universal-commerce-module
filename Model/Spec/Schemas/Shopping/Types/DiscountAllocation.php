<?php

/**
 * @author Magebit <info@magebit.com>
 * @copyright Copyright (c) Magebit, Ltd. (https://magebit.com)
 * @license https://magebit.com/code-license
 */

declare(strict_types=1);

namespace Magebit\UniversalCommerce\Model\Spec\Schemas\Shopping\Types;

use Magebit\UniversalCommerce\Model\DataTransferObject;
use Magebit\UcpSpec\MutableApi\Schemas\Shopping\DiscountAllocationInterface;

class DiscountAllocation extends DataTransferObject implements DiscountAllocationInterface
{
    /**
     * @return string
     */
    public function getPath(): string
    {
        return $this->getDataString(DiscountAllocationInterface::KEY_PATH);
    }

    /**
     * @param string $path
     * @return self
     */
    public function setPath(string $path): self
    {
        $this->setData(DiscountAllocationInterface::KEY_PATH, $path);
        return $this;
    }

    /**
     * @return int
     */
    public function getAmount(): int
    {
        return $this->getDataInt(DiscountAllocationInterface::KEY_AMOUNT);
    }

    /**
     * @param int $amount
     * @return self
     */
    public function setAmount(int $amount): self
    {
        $this->setData(DiscountAllocationInterface::KEY_AMOUNT, $amount);
        return $this;
    }
}
