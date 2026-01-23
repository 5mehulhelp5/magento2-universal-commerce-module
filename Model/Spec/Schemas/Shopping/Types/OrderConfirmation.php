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
use Magebit\UcpSpec\MutableApi\Schemas\Shopping\Types\OrderConfirmationInterface;

class OrderConfirmation extends DataTransferObject implements OrderConfirmationInterface
{
    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->getDataString(OrderConfirmationInterface::KEY_ID);
    }

    /**
     * @return string
     */
    public function getPermalinkUrl(): string
    {
        return $this->getDataString(OrderConfirmationInterface::KEY_PERMALINK_URL);
    }

    /**
     * @param string $id
     * @return self
     */
    public function setId(string $id): self
    {
        $this->setData(OrderConfirmationInterface::KEY_ID, $id);
        return $this;
    }

    /**
     * @param string $permalinkUrl
     * @return self
     */
    public function setPermalinkUrl(string $permalinkUrl): self
    {
        $this->setData(OrderConfirmationInterface::KEY_PERMALINK_URL, $permalinkUrl);
        return $this;
    }
}
