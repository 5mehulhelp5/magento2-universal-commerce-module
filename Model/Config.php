<?php

/**
 * @author Magebit <info@magebit.com>
 * @copyright Copyright (c) Magebit, Ltd. (https://magebit.com)
 * @license https://magebit.com/code-license
 */

declare(strict_types=1);

namespace Magebit\UniversalCommerce\Model;

use Magebit\UniversalCommerce\Api\ConfigInterface;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\Serialize\SerializerInterface;
use Magento\Store\Model\ScopeInterface;

/**
 * Configuration Model
 */
class Config implements ConfigInterface
{
    /**
     * Default session TTL in seconds (6 hours)
     */
    private const DEFAULT_SESSION_TTL = 21600;

    /**
     * @param ScopeConfigInterface $scopeConfig
     * @param SerializerInterface $serializer
     */
    public function __construct(
        protected readonly ScopeConfigInterface $scopeConfig,
        protected readonly SerializerInterface $serializer
    ) {
    }

    /**
     * @inheritDoc
     */
    public function getCheckoutSessionLinks(?int $storeId = null): array
    {
        $value = $this->scopeConfig->getValue(
            self::CONFIG_CHECKOUT_SESSION_LINKS,
            ScopeInterface::SCOPE_STORE,
            $storeId
        );

        if (!$value) {
            return [];
        }

        try {
            $links = $this->serializer->unserialize($value);
            if (!is_array($links)) {
                return [];
            }

            // Filter out empty links and ensure proper structure
            return array_filter($links, function ($link) {
                return isset($link['type'], $link['url']) && !empty($link['type']) && !empty($link['url']);
            });
        } catch (\Exception $e) {
            return [];
        }
    }

    /**
     * @inheritDoc
     */
    public function getCheckoutSessionTtl(?int $storeId = null): int
    {
        $value = $this->scopeConfig->getValue(
            self::CONFIG_CHECKOUT_SESSION_TTL,
            ScopeInterface::SCOPE_STORE,
            $storeId
        );

        return $value ? (int) $value : self::DEFAULT_SESSION_TTL;
    }

    /**
     * @inheritDoc
     */
    public function getContinueUrlBase(?int $storeId = null): string
    {
        return (string) $this->scopeConfig->getValue(
            self::CONFIG_CHECKOUT_CONTINUE_URL_BASE,
            ScopeInterface::SCOPE_STORE,
            $storeId
        );
    }
}
