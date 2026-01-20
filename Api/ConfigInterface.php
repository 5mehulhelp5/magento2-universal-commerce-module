<?php

/**
 * @author Magebit <info@magebit.com>
 * @copyright Copyright (c) Magebit, Ltd. (https://magebit.com)
 * @license https://magebit.com/code-license
 */

declare(strict_types=1);

namespace Magebit\UniversalCommerce\Api;

/**
 * Configuration Interface
 */
interface ConfigInterface
{
    public const CONFIG_CHECKOUT_SESSION_LINKS = 'universal_commerce/checkout/session_links';
    public const CONFIG_CHECKOUT_SESSION_TTL = 'universal_commerce/checkout/session_ttl';
    public const CONFIG_CHECKOUT_CONTINUE_URL_BASE = 'universal_commerce/checkout/continue_url_base';

    /**
     * Get checkout session links
     *
     * @param int|null $storeId
     * @return array<array{type:string,url:string,title:string|null}>
     */
    public function getCheckoutSessionLinks(?int $storeId = null): array;

    /**
     * Get checkout session TTL in seconds
     *
     * @param int|null $storeId
     * @return int
     */
    public function getCheckoutSessionTtl(?int $storeId = null): int;

    /**
     * Get continue URL base
     *
     * @param int|null $storeId
     * @return string
     */
    public function getContinueUrlBase(?int $storeId = null): string;
}
