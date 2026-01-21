<?php

/**
 * @author Magebit <info@magebit.com>
 * @copyright Copyright (c) Magebit, Ltd. (https://magebit.com)
 * @license https://magebit.com/code-license
 */

declare(strict_types=1);

namespace Magebit\UniversalCommerce\Api\Webhook;

interface WebhookNotifierInterface
{
    /**
     * Send webhook notification to platform
     *
     * @param string $webhookUrl
     * @param string $eventType
     * @param string $checkoutId
     * @param array<mixed>|null $orderData
     * @return void
     */
    public function notify(
        string $webhookUrl,
        string $eventType,
        string $checkoutId,
        ?array $orderData = null
    ): void;
}
