<?php

/**
 * This file is part of the Magebit_UniversalCommerce package.
 *
 * @copyright Copyright (c) 2026 Magebit, Ltd. (https://magebit.com/)
 * @author    Magebit <info@magebit.com>
 * @license   MIT
 */

declare(strict_types=1);

namespace Magebit\UniversalCommerce\Model\Data\Spec\Schemas\Shopping;

use Magebit\UcpSpec\MutableApi\Schemas\Shopping\PlatformConfigInterface;
use Magebit\UniversalCommerce\Model\Data\DataTransferObject;

/**
 * Platform Config
 */
class PlatformConfig extends DataTransferObject implements PlatformConfigInterface
{
    /**
     * @inheritDoc
     */
    public function getWebhookUrl(): string
    {
        return $this->getDataString(self::KEY_WEBHOOK_URL);
    }

    /**
     * @inheritDoc
     */
    public function setWebhookUrl(string $webhookUrl): PlatformConfigInterface
    {
        return $this->setData(self::KEY_WEBHOOK_URL, $webhookUrl);
    }
}
