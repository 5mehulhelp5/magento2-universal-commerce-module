<?php

/**
 * @author Magebit <info@magebit.com>
 * @copyright Copyright (c) Magebit, Ltd. (https://magebit.com)
 * @license https://magebit.com/code-license
 */

declare(strict_types=1);

namespace Magebit\UniversalCommerce\Model\Spec\Schemas\Shopping\Types;

use Magebit\UniversalCommerce\Model\DataTransferObject;
use Magebit\UcpSpec\MutableApi\Schemas\Shopping\Types\FulfillmentRequestInterface;
use Magebit\UcpSpec\MutableApi\Schemas\Shopping\Types\FulfillmentMethodCreateRequestInterface;

class FulfillmentRequest extends DataTransferObject implements FulfillmentRequestInterface
{
    /**
     * @return FulfillmentMethodCreateRequestInterface[]|null
     */
    public function getMethods(): array|null
    {
        return $this->getDataArrayOfTypeOrNull(
            FulfillmentRequestInterface::KEY_METHODS,
            FulfillmentMethodCreateRequestInterface::class
        );
    }

    /**
     * @param FulfillmentMethodCreateRequestInterface[]|null $methods
     * @return self
     */
    public function setMethods(?array $methods): self
    {
        $this->setData(FulfillmentRequestInterface::KEY_METHODS, $methods);
        return $this;
    }
}
