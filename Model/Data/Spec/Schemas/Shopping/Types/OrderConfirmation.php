<?php

/**
 * @author Magebit <info@magebit.com>
 * @copyright Copyright (c) Magebit, Ltd. (https://magebit.com)
 * @license https://magebit.com/code-license
 */

declare(strict_types=1);

namespace Magebit\UniversalCommerce\Model\Data\Spec\Schemas\Shopping\Types;

use Magebit\UcpSpec\MutableApi\Schemas\Shopping\Types\OrderConfirmationInterface;
use Magebit\UniversalCommerce\Model\Data\DataTransferObject;

/**
 * Order Confirmation Model
 */
class OrderConfirmation extends DataTransferObject implements OrderConfirmationInterface
{
    /**
     * @inheritDoc
     */
    public function getId(): string
    {
        return $this->getDataString(self::KEY_ID);
    }

    /**
     * @inheritDoc
     */
    public function setId(string $id): self
    {
        return $this->setData(self::KEY_ID, $id);
    }

    /**
     * @inheritDoc
     */
    public function getPermalinkUrl(): string
    {
        return $this->getDataString(self::KEY_PERMALINK_URL);
    }

    /**
     * @inheritDoc
     */
    public function setPermalinkUrl(string $permalinkUrl): self
    {
        return $this->setData(self::KEY_PERMALINK_URL, $permalinkUrl);
    }
}
