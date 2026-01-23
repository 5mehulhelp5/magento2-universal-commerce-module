<?php

/**
 * @author Magebit <info@magebit.com>
 * @copyright Copyright (c) Magebit, Ltd. (https://magebit.com)
 * @license https://magebit.com/code-license
 */

declare(strict_types=1);

namespace Magebit\UniversalCommerce\Model\Spec\Schemas\Shopping\Types;

use Magebit\UniversalCommerce\Model\DataTransferObject;
use Magebit\UcpSpec\MutableApi\Schemas\Shopping\Types\FulfillmentGroupCreateRequestInterface;

class FulfillmentGroupCreateRequest extends DataTransferObject implements FulfillmentGroupCreateRequestInterface
{
    /**
     * @return string|null
     */
    public function getSelectedOptionId(): string|null
    {
        return $this->getDataStringOrNull(FulfillmentGroupCreateRequestInterface::KEY_SELECTED_OPTION_ID);
    }

    /**
     * @param string|null $selectedOptionId
     * @return self
     */
    public function setSelectedOptionId(?string $selectedOptionId): self
    {
        $this->setData(FulfillmentGroupCreateRequestInterface::KEY_SELECTED_OPTION_ID, $selectedOptionId);
        return $this;
    }
}
