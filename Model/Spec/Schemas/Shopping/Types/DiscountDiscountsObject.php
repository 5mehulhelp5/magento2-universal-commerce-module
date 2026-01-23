<?php

/**
 * @author Magebit <info@magebit.com>
 * @copyright Copyright (c) Magebit, Ltd. (https://magebit.com)
 * @license https://magebit.com/code-license
 */

declare(strict_types=1);

namespace Magebit\UniversalCommerce\Model\Spec\Schemas\Shopping\Types;

use Magebit\UniversalCommerce\Model\DataTransferObject;
use Magebit\UcpSpec\MutableApi\Schemas\Shopping\DiscountDiscountsObjectInterface;
use Magebit\UcpSpec\MutableApi\Schemas\Shopping\DiscountAppliedDiscountInterface;

class DiscountDiscountsObject extends DataTransferObject implements DiscountDiscountsObjectInterface
{
    /**
     * @return string[]|null
     */
    public function getCodes(): array|null
    {
        $value = $this->getData(DiscountDiscountsObjectInterface::KEY_CODES);

        if (!is_array($value)) {
            return null;
        }

        return $value;
    }

    /**
     * @param string[]|null $codes
     * @return self
     */
    public function setCodes(?array $codes): self
    {
        $this->setData(DiscountDiscountsObjectInterface::KEY_CODES, $codes);
        return $this;
    }

    /**
     * @return DiscountAppliedDiscountInterface[]|null
     */
    public function getApplied(): array|null
    {
        return $this->getDataArrayOfTypeOrNull(
            DiscountDiscountsObjectInterface::KEY_APPLIED,
            DiscountAppliedDiscountInterface::class
        );
    }

    /**
     * @param DiscountAppliedDiscountInterface[]|null $applied
     * @return self
     */
    public function setApplied(?array $applied): self
    {
        $this->setData(DiscountDiscountsObjectInterface::KEY_APPLIED, $applied);
        return $this;
    }
}
