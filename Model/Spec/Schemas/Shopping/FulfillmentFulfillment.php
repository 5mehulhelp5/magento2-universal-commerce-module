<?php

/**
 * @author Magebit <info@magebit.com>
 * @copyright Copyright (c) Magebit, Ltd. (https://magebit.com)
 * @license https://magebit.com/code-license
 */

declare(strict_types=1);

namespace Magebit\UniversalCommerce\Model\Spec\Schemas\Shopping;

use Magebit\UniversalCommerce\Model\DataTransferObject;
use Magebit\UcpSpec\MutableApi\Schemas\Shopping\FulfillmentFulfillmentInterface;
use Magebit\UcpSpec\MutableApi\Schemas\Shopping\Types\FulfillmentMethodResponseInterface;
use Magebit\UcpSpec\MutableApi\Schemas\Shopping\Types\FulfillmentAvailableMethodResponseInterface;

class FulfillmentFulfillment extends DataTransferObject implements FulfillmentFulfillmentInterface
{
    /**
     * @return FulfillmentMethodResponseInterface[]|null
     */
    public function getMethods(): array|null
    {
        return $this->getDataArrayOfTypeOrNull(
            FulfillmentFulfillmentInterface::KEY_METHODS,
            FulfillmentMethodResponseInterface::class
        );
    }

    /**
     * @param FulfillmentMethodResponseInterface[]|null $methods
     * @return self
     */
    public function setMethods(?array $methods): self
    {
        $this->setData(FulfillmentFulfillmentInterface::KEY_METHODS, $methods);
        return $this;
    }

    /**
     * @return FulfillmentAvailableMethodResponseInterface[]|null
     */
    public function getAvailableMethods(): array|null
    {
        return $this->getDataArrayOfTypeOrNull(
            FulfillmentFulfillmentInterface::KEY_AVAILABLE_METHODS,
            FulfillmentAvailableMethodResponseInterface::class
        );
    }

    /**
     * @param FulfillmentAvailableMethodResponseInterface[]|null $availableMethods
     * @return self
     */
    public function setAvailableMethods(?array $availableMethods): self
    {
        $this->setData(FulfillmentFulfillmentInterface::KEY_AVAILABLE_METHODS, $availableMethods);
        return $this;
    }
}
