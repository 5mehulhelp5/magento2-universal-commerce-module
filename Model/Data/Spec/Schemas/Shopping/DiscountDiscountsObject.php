<?php

/**
 * @author Magebit <info@magebit.com>
 * @copyright Copyright (c) Magebit, Ltd. (https://magebit.com)
 * @license https://magebit.com/code-license
 */

declare(strict_types=1);

namespace Magebit\UniversalCommerce\Model\Data\Spec\Schemas\Shopping;

use Magebit\UcpSpec\MutableApi\Schemas\Shopping\DiscountAppliedDiscountInterface;
use Magebit\UcpSpec\MutableApi\Schemas\Shopping\DiscountAppliedDiscountInterfaceFactory;
use Magebit\UcpSpec\MutableApi\Schemas\Shopping\DiscountDiscountsObjectInterface;
use Magebit\UniversalCommerce\Model\Data\DataTransferObject;

/**
 * Discount Discounts Object Model
 */
class DiscountDiscountsObject extends DataTransferObject implements DiscountDiscountsObjectInterface
{
    /**
     * @param DiscountAppliedDiscountInterfaceFactory $appliedDiscountFactory
     * @param array<mixed> $data
     */
    public function __construct(
        private readonly DiscountAppliedDiscountInterfaceFactory $appliedDiscountFactory,
        array $data = []
    ) {
        parent::__construct($data);
    }

    /**
     * @inheritDoc
     */
    public function getCodes(): ?array
    {
        $codes = $this->getData(self::KEY_CODES);
        if ($codes === null) {
            return null;
        }
        if (!is_array($codes)) {
            return null;
        }
        return array_values(array_filter($codes, 'is_string'));
    }

    /**
     * @inheritDoc
     */
    public function setCodes(?array $codes): self
    {
        return $this->setData(self::KEY_CODES, $codes);
    }

    /**
     * @inheritDoc
     */
    public function getApplied(): ?array
    {
        return $this->getDataInstanceArray(
            self::KEY_APPLIED,
            DiscountAppliedDiscountInterface::class,
            $this->appliedDiscountFactory->create(...)
        );
    }

    /**
     * @inheritDoc
     */
    public function setApplied(?array $applied): self
    {
        return $this->setData(self::KEY_APPLIED, $applied);
    }
}
