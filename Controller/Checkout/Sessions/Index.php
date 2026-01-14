<?php

/**
 * This file is part of the Magebit_UniversalCommerce package.
 *
 * @copyright Copyright (c) 2026 Magebit, Ltd. (https://magebit.com/)
 * @author    Magebit <info@magebit.com>
 * @license   MIT
 */

declare(strict_types=1);

namespace Magebit\UniversalCommerce\Controller\Checkout\Sessions;

use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\Controller\Result\JsonFactory;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\App\Request\Http;
use Magebit\UniversalCommerce\Api\Data\Response\ErrorResponseInterface;
use Magebit\UniversalCommerce\Api\Data\Response\ErrorResponseInterfaceFactory;
use Magebit\UniversalCommerce\Api\Data\Spec\CheckoutCreateRequestInterfaceFactory;
use Magebit\UniversalCommerce\Controller\ApiController;
use Magebit\UniversalCommerce\Model\IdempotencyHandler;
use Magebit\UniversalCommerce\Model\RequestValidator;
use Magento\Framework\App\RequestInterface;
use Magebit\UniversalCommerce\Service\CheckoutService;

class Index extends ApiController implements HttpPostActionInterface
{
    /**
     * @param JsonFactory $jsonFactory
     * @param RequestInterface $request
     * @param RequestValidator $requestValidator
     * @param ErrorResponseInterfaceFactory $errorResponseFactory
     * @param IdempotencyHandler $idempotencyHandler
     * @param CheckoutService $checkoutService
     * @param CheckoutCreateRequestInterfaceFactory $checkoutCreateRequestFactory
     */
    public function __construct(
        JsonFactory $jsonFactory,
        RequestInterface $request,
        RequestValidator $requestValidator,
        ErrorResponseInterfaceFactory $errorResponseFactory,
        private readonly IdempotencyHandler $idempotencyHandler,
        private readonly CheckoutService $checkoutService,
        private readonly CheckoutCreateRequestInterfaceFactory $checkoutCreateRequestFactory,
    ) {
        parent::__construct($jsonFactory, $request, $requestValidator, $errorResponseFactory);
    }

    /**
     * Execute action to create checkout session
     *
     * @return ResultInterface
     */
    public function execute(): ResultInterface
    {
        /** @var Http $request */
        $request = $this->getRequest();

        if ($idempotencyResponse = $this->idempotencyHandler->handle($request)) {
            return $idempotencyResponse;
        }

        // Validate and create request object
        $requestObject = $this->createRequestObjectAndValidate(
            fn($data) => $this->checkoutCreateRequestFactory->create($data)
        );

        // Handle validation errors
        if ($requestObject instanceof ErrorResponseInterface) {
            return $this->makeErrorResponse($requestObject, 400);
        }

        // Pass validated object to service
        $response = $this->checkoutService->createCheckout($requestObject);

        return $this->makeJsonResponse($response);
    }
}
