<?php

/**
 * This file is part of the Magebit_UniversalCommerce package.
 *
 * @copyright Copyright (c) 2026 Magebit, Ltd. (https://magebit.com/)
 * @author    Magebit <info@magebit.com>
 * @license   MIT
 */

declare(strict_types=1);

namespace Magebit\UniversalCommerce\Model\Discovery\Payment;

use Magebit\UniversalCommerce\Api\Discovery\PaymentHandlerInterface;

class MockPaymentHandler implements PaymentHandlerInterface
{
    public const ID = 'mock_payment_handler';
    public const NAME = 'dev.ucp.mock_payment';
    public const VERSION = '1.0';
    public const SPEC = 'https://ucp.dev/specs/mock';
    public const CONFIG_SCHEMA = 'https://ucp.dev/schemas/mock.json';

    /**
     * Get payment handler ID
     *
     * @return string
     */
    public function getId(): string
    {
        return self::ID;
    }

    /**
     * Get payment handler name
     *
     * @return string
     */
    public function getName(): string
    {
        return self::NAME;
    }

    /**
     * Get payment handler version
     *
     * @return string
     */
    public function getVersion(): string
    {
        return self::VERSION;
    }

    /**
     * Get specification URL
     *
     * @return string
     */
    public function getSpec(): string
    {
        return self::SPEC;
    }

    /**
     * Get configuration schema URL
     *
     * @return string
     */
    public function getConfigSchema(): string
    {
        return self::CONFIG_SCHEMA;
    }

    /**
     * Get instrument schemas
     *
     * @return string[]
     */
    public function getInstrumentSchemas(): array
    {
        return [
            'https://ucp.dev/schemas/shopping/types/card_payment_instrument.json',
        ];
    }

    /**
     * Get configuration
     *
     * @return array<string, mixed>
     */
    public function getConfig(): array
    {
        return [
            'supported_tokens' => ['success_token', 'fail_token'],
        ];
    }
}
