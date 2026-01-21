<?php

/**
 * @author Magebit <info@magebit.com>
 * @copyright Copyright (c) Magebit, Ltd. (https://magebit.com)
 * @license https://magebit.com/code-license
 */

declare(strict_types=1);

namespace Magebit\UniversalCommerce\Model\Data\Spec\Schemas\Shopping;

use Magebit\UcpSpec\MutableApi\Schemas\Shopping\DiscountAllocationInterface;
use Magebit\UcpSpec\MutableApi\Schemas\Shopping\DiscountAllocationInterfaceFactory;
use Magebit\UcpSpec\MutableApi\Schemas\Shopping\DiscountAppliedDiscountInterface;
use Magebit\UniversalCommerce\Model\Data\DataTransferObject;

/**
 * Applied Discount Model
 */
class DiscountAppliedDiscount extends DataTransferObject implements DiscountAppliedDiscountInterface
{
    /**
     * @param DiscountAllocationInterfaceFactory $allocationFactory
     * @param array<mixed> $data
     */
    public function __construct(
        private readonly DiscountAllocationInterfaceFactory $allocationFactory,
        array $data = []
    ) {
        parent::__construct($data);
    }

    /**
     * @inheritDoc
     */
    public function getCode(): ?string
    {
        return $this->getDataStringOrNull(self::KEY_CODE);
    }

    /**
     * @inheritDoc
     */
    public function setCode(?string $code): self
    {
        return $this->setData(self::KEY_CODE, $code);
    }

    /**
     * @inheritDoc
     */
    public function getTitle(): string
    {
        return $this->getDataString(self::KEY_TITLE);
    }

    /**
     * @inheritDoc
     */
    public function setTitle(string $title): self
    {
        return $this->setData(self::KEY_TITLE, $title);
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

    /**
     * @inheritDoc
     */
    public function getAutomatic(): ?bool
    {
        $data = $this->getData(self::KEY_AUTOMATIC);
        return is_bool($data) ? $data : null;
    }

    /**
     * @inheritDoc
     */
    public function setAutomatic(?bool $automatic): self
    {
        return $this->setData(self::KEY_AUTOMATIC, $automatic);
    }

    /**
     * @inheritDoc
     */
    public function getMethod(): ?string
    {
        return $this->getDataStringOrNull(self::KEY_METHOD);
    }

    /**
     * @inheritDoc
     */
    public function setMethod(?string $method): self
    {
        return $this->setData(self::KEY_METHOD, $method);
    }

    /**
     * @inheritDoc
     */
    public function getPriority(): ?int
    {
        return $this->getDataIntOrNull(self::KEY_PRIORITY);
    }

    /**
     * @inheritDoc
     */
    public function setPriority(?int $priority): self
    {
        return $this->setData(self::KEY_PRIORITY, $priority);
    }

    /**
     * @inheritDoc
     */
    public function getAllocations(): ?array
    {
        return $this->getDataInstanceArray(
            self::KEY_ALLOCATIONS,
            DiscountAllocationInterface::class,
            $this->allocationFactory->create(...)
        );
    }

    /**
     * @inheritDoc
     */
    public function setAllocations(?array $allocations): self
    {
        return $this->setData(self::KEY_ALLOCATIONS, $allocations);
    }
}
