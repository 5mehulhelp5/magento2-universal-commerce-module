<?php

/**
 * @author Magebit <info@magebit.com>
 * @copyright Copyright (c) Magebit, Ltd. (https://magebit.com)
 * @license https://magebit.com/code-license
 */

declare(strict_types=1);

namespace Magebit\UniversalCommerce\Model\Payment;

use Magebit\UniversalCommerce\Api\Payment\PaymentHandlerInterface;
use Magento\Quote\Api\Data\CartInterface;
use Magento\Framework\App\Config\ScopeConfigInterface;

class PaymentHandlerPool
{
    /**
     * @param ScopeConfigInterface $scopeConfig
     * @param array<PaymentHandlerInterface> $handlers
     */
    public function __construct(
        private readonly ScopeConfigInterface $scopeConfig,
        private readonly array $handlers = []
    ) {
    }

    /**
     * Get all registered handlers
     *
     * @return array<PaymentHandlerInterface>
     */
    public function getAll(): array
    {
        return $this->handlers;
    }

    /**
     * Get handlers available for specific quote
     *
     * Filters handlers based on Magento's payment method availability checks
     * which include country, currency, min/max totals, etc.
     *
     * @param CartInterface $cart
     * @return array<PaymentHandlerInterface>
     */
    public function getAvailableForQuote(CartInterface $cart): array
    {
        return array_filter(
            $this->handlers,
            fn(PaymentHandlerInterface $handler) => $handler->isAvailable($cart)
        );
    }

    /**
     * Get handlers that are enabled in Magento configuration
     *
     * Used for discovery endpoint where there's no quote context.
     * For mapped handlers: checks if Magento payment method is enabled
     * For standalone handlers: includes them if they pass basic checks
     *
     * @return array<PaymentHandlerInterface>
     */
    public function getEnabledHandlers(): array
    {
        return array_filter(
            $this->handlers,
            function (PaymentHandlerInterface $handler) {
                $methodCode = $handler->getMagentoMethodCode();

                if ($methodCode === null) {
                    // Standalone handler - include it
                    return true;
                }

                // Check if Magento payment method is enabled
                return (bool) $this->scopeConfig->getValue(
                    'payment/' . $methodCode . '/active',
                    \Magento\Store\Model\ScopeInterface::SCOPE_STORE
                );
            }
        );
    }

    /**
     * Get handler by ID
     *
     * @param string $handlerId
     * @return PaymentHandlerInterface|null
     */
    public function getById(string $handlerId): ?PaymentHandlerInterface
    {
        return $this->handlers[$handlerId] ?? null;
    }

    /**
     * Get handler by Magento method code
     *
     * @param string $methodCode
     * @return PaymentHandlerInterface|null
     */
    public function getByMagentoMethodCode(string $methodCode): ?PaymentHandlerInterface
    {
        foreach ($this->handlers as $handler) {
            if ($handler->getMagentoMethodCode() === $methodCode) {
                return $handler;
            }
        }

        return null;
    }
}
