<?php

/**
 * This file is part of the Magebit_UniversalCommerce package.
 *
 * @copyright Copyright (c) 2026 Magebit, Ltd. (https://magebit.com/)
 * @author    Magebit <info@magebit.com>
 * @license   MIT
 */

declare(strict_types=1);

namespace Magebit\UniversalCommerce\Model\Payment;

use Magebit\UcpSpec\Api\Schemas\Shopping\Types\PaymentInstrumentInterface;
use Magebit\UniversalCommerce\Api\Payment\PaymentHandlerInterface;
use Magento\Quote\Api\Data\CartInterface;
use Magento\Quote\Api\Data\PaymentInterface;
use Magento\Quote\Api\Data\PaymentInterfaceFactory;

class MockPaymentHandler implements PaymentHandlerInterface
{
    public const ID = 'mock_payment_handler';
    public const NAME = 'dev.ucp.mock_payment';
    public const VERSION = '1.0';
    public const SPEC = 'https://ucp.dev/specs/mock';
    public const CONFIG_SCHEMA = 'https://ucp.dev/schemas/mock.json';

    /**
     * @param PaymentInterfaceFactory $paymentFactory
     */
    public function __construct(
        protected readonly PaymentInterfaceFactory $paymentFactory
    ) {
    }

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

    /**
     * Get the Magento payment method code this handler maps to
     *
     * @return string|null
     */
    public function getMagentoMethodCode(): ?string
    {
        return null; // Standalone handler - not mapped to a Magento payment method
    }

    /**
     * Check if payment handler is available
     *
     * @param CartInterface $cart
     * @return bool
     */
    public function isAvailable(CartInterface $cart): bool
    {
        return true;
    }

    /**
     * Handle payment
     *
     * @param CartInterface $cart
     * @param PaymentInstrumentInterface $paymentData
     * @return PaymentInterface
     */
    public function handle(CartInterface $cart, PaymentInstrumentInterface $paymentData): PaymentInterface
    {
        /** @var PaymentInterface $payment */
        $payment = $this->paymentFactory->create();
        $payment->setMethod(self::ID);
        return $payment;
    }
}
