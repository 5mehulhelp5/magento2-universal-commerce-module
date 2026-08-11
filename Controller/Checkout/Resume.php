<?php

/**
 * This file is part of the Magebit_UniversalCommerce package.
 *
 * @copyright Copyright (c) 2026 Magebit, Ltd. (https://magebit.com/)
 * @author    Magebit <info@magebit.com>
 * @license   MIT
 */

declare(strict_types=1);

namespace Magebit\UniversalCommerce\Controller\Checkout;

use Magento\Checkout\Model\Session as CheckoutSession;
use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\Controller\Result\RedirectFactory;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\App\RequestInterface;
use Magento\Quote\Api\GuestCartRepositoryInterface;
use Magento\Framework\Exception\NoSuchEntityException;
use Psr\Log\LoggerInterface;

/**
 * Hands an agent-built cart back to the buyer's browser, which is what `continue_url` points at.
 */
class Resume implements HttpGetActionInterface
{
    /**
     * @param RequestInterface $request
     * @param GuestCartRepositoryInterface $guestCartRepository
     * @param CheckoutSession $checkoutSession
     * @param RedirectFactory $redirectFactory
     * @param LoggerInterface $logger
     */
    public function __construct(
        private readonly RequestInterface $request,
        private readonly GuestCartRepositoryInterface $guestCartRepository,
        private readonly CheckoutSession $checkoutSession,
        private readonly RedirectFactory $redirectFactory,
        private readonly LoggerInterface $logger
    ) {
    }

    /**
     * @return ResultInterface
     */
    public function execute(): ResultInterface
    {
        $redirect = $this->redirectFactory->create();
        $maskedCartId = $this->request->getParam('id', '');

        if (!is_string($maskedCartId) || $maskedCartId === '') {
            return $redirect->setPath('checkout/cart');
        }

        try {
            $cart = $this->guestCartRepository->get($maskedCartId);
        } catch (NoSuchEntityException $exception) {
            $this->logger->info('UCP resume: unknown cart ' . $maskedCartId);

            return $redirect->setPath('checkout/cart');
        }

        $this->checkoutSession->setQuoteId($cart->getId());

        return $redirect->setPath('checkout');
    }
}
