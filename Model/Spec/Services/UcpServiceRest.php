<?php

/**
 * This file is part of the Magebit_UniversalCommerce package.
 *
 * @copyright Copyright (c) 2026 Magebit, Ltd. (https://magebit.com/)
 * @author    Magebit <info@magebit.com>
 * @license   MIT
 */

declare(strict_types=1);

namespace Magebit\UniversalCommerce\Model\Spec\Services;

use Magebit\UniversalCommerce\Model\DataTransferObject;
use Magebit\UcpSpec\Api\Services\UCPServiceRestInterface;

class UcpServiceRest extends DataTransferObject implements UCPServiceRestInterface
{
    /**
     * @return string
     */
    public function getSchema(): string
    {
        return $this->getDataString(UCPServiceRestInterface::KEY_SCHEMA);
    }

    /**
     * @return string
     */
    public function getEndpoint(): string
    {
        return $this->getDataString(UCPServiceRestInterface::KEY_ENDPOINT);
    }

    /**
     * @return array<mixed>
     */
    public function jsonSerialize(): array
    {
        return $this->toArray();
    }
}
