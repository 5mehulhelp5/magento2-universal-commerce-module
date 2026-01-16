<?php

/**
 * This file is part of the Magebit_UniversalCommerce package.
 *
 * @copyright Copyright (c) 2026 Magebit, Ltd. (https://magebit.com/)
 * @author    Magebit <info@magebit.com>
 * @license   MIT
 */

declare(strict_types=1);

namespace Magebit\UniversalCommerce\Model\Data\Spec\Response;

use Magebit\UniversalCommerce\Api\Data\Spec\Response\PlatformConfigInterface;
use Magebit\UniversalCommerce\Model\Data\DataTransferObject;

/**
 * Platform Config
 */
class PlatformConfig extends DataTransferObject implements PlatformConfigInterface
{
    /**
     * @inheritDoc
     */
    public function getWebhookUrl(): ?string
    {
        return $this->getDataStringOrNull(self::WEBHOOK_URL);
    }

    /**
     * @inheritDoc
     */
    public function setWebhookUrl(?string $webhookUrl): PlatformConfigInterface
    {
        return $this->setData(self::WEBHOOK_URL, $webhookUrl);
    }
}
