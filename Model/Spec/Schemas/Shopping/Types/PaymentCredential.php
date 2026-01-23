<?php

/**
 * @author Magebit <info@magebit.com>
 * @copyright Copyright (c) Magebit, Ltd. (https://magebit.com)
 * @license https://magebit.com/code-license
 */

declare(strict_types=1);

namespace Magebit\UniversalCommerce\Model\Spec\Schemas\Shopping\Types;

use Magebit\UniversalCommerce\Model\DataTransferObject;
use Magebit\UcpSpec\MutableApi\Schemas\Shopping\Types\PaymentCredentialInterface;

class PaymentCredential extends DataTransferObject implements PaymentCredentialInterface
{
    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->getDataString(PaymentCredentialInterface::KEY_TYPE);
    }

    /**
     * @param string $type
     * @return self
     */
    public function setType(string $type): self
    {
        $this->setData(PaymentCredentialInterface::KEY_TYPE, $type);
        return $this;
    }
}
