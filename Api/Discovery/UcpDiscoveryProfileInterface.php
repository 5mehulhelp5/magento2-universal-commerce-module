<?php

/**
 * This file is part of the Magebit_UniversalCommerce package.
 *
 * @copyright Copyright (c) 2026 Magebit, Ltd. (https://magebit.com/)
 * @author    Magebit <info@magebit.com>
 * @license   MIT
 */

declare(strict_types=1);

namespace Magebit\UniversalCommerce\Api\Discovery;

use JsonSerializable;

interface UcpDiscoveryProfileInterface extends JsonSerializable
{
    public const VERSION = 'version';
    public const CAPABILITIES = 'capabilities';
    public const SERVICES = 'services';

    public const PAYMENT_HANDLERS = 'payment_handlers';

    /**
     * Get version
     *
     * @return string
     */
    public function getVersion(): string;

    /**
     * Get services
     *
     * @return array<string, array{version: string, spec: string, rest: array{schema: string, endpoint: string}}>
     */
    public function getServices(): array;

    /**
     * @return array<array{name: string, version: string, spec: string, schema: string}>
     */
    public function getCapabilities(): array;

    /**
     * @return array<mixed>
     */
    public function getPaymentHandlers(): array;
}
