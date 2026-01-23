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
use Magebit\UcpSpec\Api\Schemas\Shopping\Types\TotalResponseInterface;

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
        $value = $this->getData(TotalResponseInterface::KEY_AMOUNT);
        if (!is_int($value)) {
            throw new \InvalidArgumentException(
                sprintf('Data for key %s is not an int', TotalResponseInterface::KEY_AMOUNT)
            );
        }
        return $value;
    }
}
