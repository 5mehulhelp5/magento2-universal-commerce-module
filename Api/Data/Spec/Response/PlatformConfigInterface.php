<?php

/**
 * This file is part of the Magebit_UniversalCommerce package.
 *
 * @copyright Copyright (c) 2026 Magebit, Ltd. (https://magebit.com/)
 * @author    Magebit <info@magebit.com>
 * @license   MIT
 */

declare(strict_types=1);

namespace Magebit\UniversalCommerce\Api\Data\Spec\Response;

/**
 * Platform Config Interface
 */
interface PlatformConfigInterface
{
    public const WEBHOOK_URL = 'webhook_url';

    /**
     * Get webhook URL
     *
     * @return string|null
     */
    public function getWebhookUrl(): ?string;

    /**
     * Set webhook URL
     *
     * @param string|null $webhookUrl
     * @return $this
     */
    public function setWebhookUrl(?string $webhookUrl): self;
}
