<?php

/**
 * @author Magebit <info@magebit.com>
 * @copyright Copyright (c) Magebit, Ltd. (https://magebit.com)
 * @license https://magebit.com/code-license
 */

declare(strict_types=1);

namespace Magebit\UniversalCommerce\Model;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\ScopeInterface;
use Magento\Store\Model\StoreManagerInterface;

class Config
{
    private const XML_PATH_API_BASE_URL = 'universal_commerce/api/base_url';
    private const XML_PATH_IDEMPOTENCY_TTL_HOURS = 'universal_commerce/idempotency/ttl_hours';
    private const XML_PATH_PAYMENT_METHOD = 'universal_commerce/checkout/payment_method';

    /**
     * @param ScopeConfigInterface $scopeConfig
     * @param StoreManagerInterface $storeManager
     */
    public function __construct(
        private readonly ScopeConfigInterface $scopeConfig,
        private readonly StoreManagerInterface $storeManager,
    ) {
    }

    /**
     * Get API base URL from configuration
     *
     * @param int|null $storeId
     * @return string
     */
    public function getApiBaseUrl(?int $storeId = null): string
    {
        /** @var string|null $baseUrl */
        $baseUrl = $this->scopeConfig->getValue(
            self::XML_PATH_API_BASE_URL,
            ScopeInterface::SCOPE_STORE,
            $storeId
        );

        if ($baseUrl) {
            return (string) rtrim($baseUrl, '/');
        }

        return rtrim($this->storeManager->getStore($storeId)->getBaseUrl(), '/');
    }

    /**
     * How long stored idempotent responses are retained; 0 disables cleanup.
     *
     * @param int|null $storeId
     * @return int
     */
    public function getIdempotencyTtlHours(?int $storeId = null): int
    {
        $value = $this->scopeConfig->getValue(
            self::XML_PATH_IDEMPOTENCY_TTL_HOURS,
            ScopeInterface::SCOPE_STORE,
            $storeId
        );

        return is_numeric($value) ? (int) $value : 0;
    }

    /**
     * Magento payment method applied when an agent completes a checkout.
     *
     * UCP payment handlers are not mapped to Magento methods yet, but an order
     * cannot be placed without one.
     *
     * @param int|null $storeId
     * @return string
     */
    public function getPaymentMethod(?int $storeId = null): string
    {
        $method = $this->scopeConfig->getValue(
            self::XML_PATH_PAYMENT_METHOD,
            ScopeInterface::SCOPE_STORE,
            $storeId
        );

        return is_string($method) && $method !== '' ? $method : 'checkmo';
    }
}
