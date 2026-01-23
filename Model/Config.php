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
}
