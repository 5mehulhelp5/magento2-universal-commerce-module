<?php

/**
 * @author Magebit <info@magebit.com>
 * @copyright Copyright (c) Magebit, Ltd. (https://magebit.com)
 * @license https://magebit.com/code-license
 */

declare(strict_types=1);

namespace Magebit\UniversalCommerce\Model\Spec\Schemas\Shopping\Types;

use Magebit\UniversalCommerce\Model\DataTransferObject;
use Magebit\UcpSpec\MutableApi\Schemas\Shopping\DiscountAppliedDiscountInterface;
use Magebit\UcpSpec\MutableApi\Schemas\Shopping\DiscountAllocationInterface;

class DiscountAppliedDiscount extends DataTransferObject implements DiscountAppliedDiscountInterface
{
    /**
     * @return string|null
     */
    public function getCode(): string|null
    {
        return $this->getDataStringOrNull(DiscountAppliedDiscountInterface::KEY_CODE);
    }

    /**
     * @param string|null $code
     * @return self
     */
    public function setCode(?string $code): self
    {
        $this->setData(DiscountAppliedDiscountInterface::KEY_CODE, $code);
        return $this;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->getDataString(DiscountAppliedDiscountInterface::KEY_TITLE);
    }

    /**
     * @param string $title
     * @return self
     */
    public function setTitle(string $title): self
    {
        $this->setData(DiscountAppliedDiscountInterface::KEY_TITLE, $title);
        return $this;
    }

    /**
     * @return int
     */
    public function getAmount(): int
    {
        return $this->getDataInt(DiscountAppliedDiscountInterface::KEY_AMOUNT);
    }

    /**
     * @param int $amount
     * @return self
     */
    public function setAmount(int $amount): self
    {
        $this->setData(DiscountAppliedDiscountInterface::KEY_AMOUNT, $amount);
        return $this;
    }

    /**
     * @return bool|null
     */
    public function getAutomatic(): bool|null
    {
        $value = $this->getData(DiscountAppliedDiscountInterface::KEY_AUTOMATIC);
        return is_bool($value) ? $value : null;
    }

    /**
     * @param bool|null $automatic
     * @return self
     */
    public function setAutomatic(?bool $automatic): self
    {
        $this->setData(DiscountAppliedDiscountInterface::KEY_AUTOMATIC, $automatic);
        return $this;
    }

    /**
     * @return string|null
     */
    public function getMethod(): string|null
    {
        return $this->getDataStringOrNull(DiscountAppliedDiscountInterface::KEY_METHOD);
    }

    /**
     * @param string|null $method
     * @return self
     */
    public function setMethod(?string $method): self
    {
        $this->setData(DiscountAppliedDiscountInterface::KEY_METHOD, $method);
        return $this;
    }

    /**
     * @return int|null
     */
    public function getPriority(): int|null
    {
        return $this->getDataIntOrNull(DiscountAppliedDiscountInterface::KEY_PRIORITY);
    }

    /**
     * @param int|null $priority
     * @return self
     */
    public function setPriority(?int $priority): self
    {
        $this->setData(DiscountAppliedDiscountInterface::KEY_PRIORITY, $priority);
        return $this;
    }

    /**
     * @return DiscountAllocationInterface[]|null
     */
    public function getAllocations(): array|null
    {
        return $this->getDataArrayOfTypeOrNull(
            DiscountAppliedDiscountInterface::KEY_ALLOCATIONS,
            DiscountAllocationInterface::class
        );
    }

    /**
     * @param DiscountAllocationInterface[]|null $allocations
     * @return self
     */
    public function setAllocations(?array $allocations): self
    {
        $this->setData(DiscountAppliedDiscountInterface::KEY_ALLOCATIONS, $allocations);
        return $this;
    }
}
