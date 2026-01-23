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

use Magebit\UniversalCommerce\Api\Service\Shopping\CheckoutUpdateRequestInterfaceFactory;
use Magebit\UcpSpec\MutableApi\Schemas\Shopping\Types\MessageInterfaceFactory;
use Magebit\UniversalCommerce\Api\Service\Shopping\CheckoutUpdateRequestInterface;
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

class Update extends ApiController
{
    public function __construct(
        JsonFactory $resultJsonFactory,
        RequestInterface $request,
        RequestValidator $requestValidator,
        RequestClassBuilder $requestClassBuilder,
        MessageInterfaceFactory $messageFactory,
        IdempotencyHandler $idempotencyHandler,
        protected readonly CheckoutUpdateRequestInterfaceFactory $checkoutUpdateRequestFactory,
        protected readonly RestHandlerInterface $restHandler
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

        $checkoutUpdateRequest = $this->getAndValidateRequest(
            CheckoutUpdateRequestInterface::class,
            $this->checkoutUpdateRequestFactory->create(...)
        );

        if ($checkoutUpdateRequest instanceof ValidationResult) {
            return $this->validationResultToResponse($checkoutUpdateRequest);
        }

        if ($idempotencyResponse = $this->handleIdempotency()) {
            return $idempotencyResponse;
        }

        return $this->errorBoundary(function () use ($checkoutId, $checkoutUpdateRequest) {
            $checkoutResponse = $this->restHandler->updateCheckout($checkoutId, $checkoutUpdateRequest);

            if ($checkoutResponse instanceof DataTransferObject) {
                $this->idempotencyHandler->storeResponse($this->getHttpRequest(), $checkoutResponse, 201);

                return $this->makeJsonResponse($checkoutResponse);
            }

            throw new LocalizedException(__('Internal server error'));
        });
    }
}
