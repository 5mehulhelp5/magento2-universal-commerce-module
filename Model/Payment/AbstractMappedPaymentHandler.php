<?php

/**
 * @author Magebit <info@magebit.com>
 * @copyright Copyright (c) Magebit, Ltd. (https://magebit.com)
 * @license https://magebit.com/code-license
 */

declare(strict_types=1);

namespace Magebit\UniversalCommerce\Model\Payment;

use Magebit\UniversalCommerce\Api\Payment\PaymentHandlerInterface;
use Magento\Payment\Model\MethodList;
use Magento\Quote\Api\Data\CartInterface;
use Magento\Framework\App\Config\ScopeConfigInterface;

abstract class AbstractMappedPaymentHandler implements PaymentHandlerInterface
{
    /**
     * @param MethodList $paymentMethodList
     * @param ScopeConfigInterface $scopeConfig
     */
    public function __construct(
        protected readonly MethodList $paymentMethodList,
        protected readonly ScopeConfigInterface $scopeConfig
    ) {
    }

    /**
     * Check if payment handler is available for the given quote
     *
     * Uses Magento's native payment method availability checks which include:
     * - Method enabled in config
     * - Country restrictions
     * - Currency restrictions
     * - Min/Max order total
     * - Customer group restrictions
     * - Method's custom isAvailable() logic
     *
     * @param CartInterface $cart
     * @return bool
     */
    public function isAvailable(CartInterface $cart): bool
    {
        $methodCode = $this->getMagentoMethodCode();

        if ($methodCode === null) {
            // Standalone handler - no Magento method mapping
            return true;
        }

        // Get available payment methods for this quote
        // This respects all Magento's native availability checks
        $availableMethods = $this->paymentMethodList->getAvailableMethods($cart);

        foreach ($availableMethods as $method) {
            if ($method->getCode() === $methodCode) {
                return true;
            }
        }

        return false;
    }

    /**
     * Check if the Magento payment method is enabled in configuration
     *
     * @return bool
     */
    protected function isMethodEnabled(): bool
    {
        $methodCode = $this->getMagentoMethodCode();

        if ($methodCode === null) {
            return true;
        }

        return (bool) $this->scopeConfig->getValue(
            'payment/' . $methodCode . '/active',
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
    }
}
