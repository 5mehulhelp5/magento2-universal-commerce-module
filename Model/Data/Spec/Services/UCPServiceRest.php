<?php

/**
 * @author Magebit <info@magebit.com>
 * @copyright Copyright (c) Magebit, Ltd. (https://magebit.com)
 * @license https://magebit.com/code-license
 */

declare(strict_types=1);

namespace Magebit\UniversalCommerce\Model\Data\Spec\Services;

use Magebit\UcpSpec\MutableApi\Services\UCPServiceRestInterface;
use Magebit\UniversalCommerce\Model\Data\DataTransferObject;

/**
 * UCP Service REST transport binding
 */
class UCPServiceRest extends DataTransferObject implements UCPServiceRestInterface
{
    /**
     * @inheritDoc
     */
    public function getSchema(): string
    {
        return $this->getDataString(self::KEY_SCHEMA);
    }

    /**
     * @inheritDoc
     */
    public function setSchema(string $schema): self
    {
        return $this->setData(self::KEY_SCHEMA, $schema);
    }

    /**
     * @inheritDoc
     */
    public function getEndpoint(): string
    {
        return $this->getDataString(self::KEY_ENDPOINT);
    }

    /**
     * @inheritDoc
     */
    public function setEndpoint(string $endpoint): self
    {
        return $this->setData(self::KEY_ENDPOINT, $endpoint);
    }
}
