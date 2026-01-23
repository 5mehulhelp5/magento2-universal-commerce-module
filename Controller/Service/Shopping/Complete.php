<?php

/**
 * This file is part of the Magebit_UniversalCommerce package.
 *
 * @copyright Copyright (c) 2026 Magebit, Ltd. (https://magebit.com/)
 * @author    Magebit <info@magebit.com>
 * @license   MIT
 */
declare(strict_types=1);

namespace Magebit\UniversalCommerce\Controller\Service\Shopping;

use Magebit\UcpSpec\MutableApi\Schemas\Shopping\PaymentDataInterface;
use Magebit\UcpSpec\MutableApi\Schemas\Shopping\PaymentDataInterfaceFactory;
use Magebit\UcpSpec\MutableApi\Schemas\Shopping\Types\MessageInterfaceFactory;
use Magebit\UniversalCommerce\Controller\ApiController;
use Magento\Framework\Controller\Result\Json as ResultJson;
use Magento\Framework\Controller\Result\JsonFactory;
use Magento\Framework\App\RequestInterface;
use Magebit\UniversalCommerce\Model\Validation\RequestValidator;
use Magebit\UniversalCommerce\Api\Service\Shopping\RestHandlerInterface;
use Magebit\UniversalCommerce\Model\Validation\ValidationResult;
use Magebit\UniversalCommerce\Model\RequestClassBuilder;
use Magebit\UniversalCommerce\Model\IdempotencyHandler;
use Magebit\UniversalCommerce\Model\DataTransferObject;
use Magento\Framework\Exception\LocalizedException;

class Complete extends ApiController
{
    public function __construct(
        JsonFactory $resultJsonFactory,
        RequestInterface $request,
        RequestValidator $requestValidator,
        RequestClassBuilder $requestClassBuilder,
        MessageInterfaceFactory $messageFactory,
        IdempotencyHandler $idempotencyHandler,
        protected readonly RestHandlerInterface $restHandler,
        protected readonly PaymentDataInterfaceFactory $paymentDataFactory
    ) {
        parent::__construct(
            $resultJsonFactory,
            $request,
            $requestValidator,
            $requestClassBuilder,
            $messageFactory,
            $idempotencyHandler
        );
    }

    /**
     * @return ResultJson
     */
    public function execute(): ResultJson
    {
        /** @var string|null $checkoutId */
        $checkoutId = $this->getHttpRequest()->getParam('checkout_id');

        if (!$checkoutId) {
            return $this->makeErrorResponse('requires_escalation', [
                $this->messageFactory->create(['data' => [
                    'type' => 'error',
                    'code' => 'invalid_request',
                    'message' => 'Checkout ID is required',
                ]])
            ], 400);
        }

        $paymentData = $this->getAndValidateRequest(
            PaymentDataInterface::class,
            $this->paymentDataFactory->create(...)
        );

        if ($paymentData instanceof ValidationResult) {
            return $this->validationResultToResponse($paymentData);
        }

        if ($idempotencyResponse = $this->handleIdempotency()) {
            return $idempotencyResponse;
        }

        try {
            $completeCheckoutResponse = $this->restHandler->completeCheckout($checkoutId, $paymentData);
        } catch (LocalizedException $e) {
            return $this->makeErrorResponse('requires_escalation', [
                $this->messageFactory->create(['data' => [
                    'type' => 'error',
                    'code' => 'requires_escalation',
                    'message' => $e->getMessage(),
                ]])
            ], 500);
        }

        if ($completeCheckoutResponse instanceof DataTransferObject) {
            $this->idempotencyHandler->storeResponse($this->getHttpRequest(), $completeCheckoutResponse, 201);

            return $this->makeJsonResponse($completeCheckoutResponse);
        }

        throw new LocalizedException(__('Internal server error'));
    }
}
