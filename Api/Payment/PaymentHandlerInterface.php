<?php

/**
 * This file is part of the Magebit_UniversalCommerce package.
 *
 * @copyright Copyright (c) 2026 Magebit, Ltd. (https://magebit.com/)
 * @author    Magebit <info@magebit.com>
 * @license   MIT
 */

declare(strict_types=1);

namespace Magebit\UniversalCommerce\Api\Payment;

interface PaymentHandlerInterface
{
    /**
     * Get payment handler ID
     *
     * @return string
     */
    public function getId(): string;

    /**
     * Get payment handler name
     *
     * @return string
     */
    public function getName(): string;

    /**
     * Get payment handler version
     *
     * @return string
     */
    public function getVersion(): string;

    /**
     * Get specification URL
     *
     * @return string
     */
    public function getSpec(): string;

    /**
     * Get configuration schema URL
     *
     * @return string
     */
    public function getConfigSchema(): string;

    /**
     * Get instrument schemas
     *
     * @return string[]
     */
    public function getInstrumentSchemas(): array;

    /**
     * Get configuration
     *
     * @return array<string, mixed>
     */
    public function getConfig(): array;
}
