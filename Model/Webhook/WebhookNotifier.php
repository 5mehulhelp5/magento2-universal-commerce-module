<?php

/**
 * @author Magebit <info@magebit.com>
 * @copyright Copyright (c) Magebit, Ltd. (https://magebit.com)
 * @license https://magebit.com/code-license
 */

declare(strict_types=1);

namespace Magebit\UniversalCommerce\Model\Webhook;

use Magebit\UniversalCommerce\Api\Webhook\WebhookNotifierInterface;
use Magento\Framework\HTTP\ClientInterface;
use Psr\Log\LoggerInterface;

/**
 * Webhook Notifier Service
 *
 * Sends webhook notifications to platform endpoints
 */
class WebhookNotifier implements WebhookNotifierInterface
{
    /**
     * @param ClientInterface $httpClient
     * @param LoggerInterface $logger
     */
    public function __construct(
        private readonly ClientInterface $httpClient,
        private readonly LoggerInterface $logger
    ) {
    }

    /**
     * Send webhook notification to platform
     *
     * Sends HTTP POST request with JSON payload.
     * Errors are logged but don't throw exceptions (fire and forget).
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
    ): void {
        $payload = [
            'event_type' => $eventType,
            'checkout_id' => $checkoutId,
        ];

        if ($orderData !== null) {
            $payload['order'] = $orderData;
        }

        try {
            $jsonPayload = json_encode($payload);
            if ($jsonPayload === false) {
                $this->logger->error('Failed to encode webhook payload', [
                    'webhook_url' => $webhookUrl,
                    'event_type' => $eventType,
                    'checkout_id' => $checkoutId,
                ]);
                return;
            }

            $this->httpClient->setHeaders([
                'Content-Type' => 'application/json',
            ]);

            $this->httpClient->post($webhookUrl, $jsonPayload);

            $statusCode = $this->httpClient->getStatus();

            if ($statusCode < 200 || $statusCode >= 300) {
                $this->logger->warning('Webhook notification failed', [
                    'webhook_url' => $webhookUrl,
                    'event_type' => $eventType,
                    'checkout_id' => $checkoutId,
                    'status_code' => $statusCode,
                    'response_body' => $this->httpClient->getBody(),
                ]);
            }
        } catch (\Exception $e) {
            $this->logger->error('Failed to send webhook notification', [
                'webhook_url' => $webhookUrl,
                'event_type' => $eventType,
                'checkout_id' => $checkoutId,
                'exception' => $e->getMessage(),
            ]);
        }
    }
}
