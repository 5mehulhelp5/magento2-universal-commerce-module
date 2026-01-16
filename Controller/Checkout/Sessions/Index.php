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

use Magebit\UniversalCommerce\Api\Data\Response\ErrorResponseInterface;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\Controller\Result\JsonFactory;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\App\Request\Http;
use Magebit\UniversalCommerce\Api\Data\Response\ErrorResponseInterfaceFactory;
use Magebit\UniversalCommerce\Api\Data\Response\MessageInterface;
use Magebit\UniversalCommerce\Api\Data\Response\MessageInterfaceFactory;
use Magebit\UniversalCommerce\Api\Data\Spec\CheckoutCreateRequestInterfaceFactory;
use Magebit\UniversalCommerce\Controller\ApiController;
use Magebit\UniversalCommerce\Model\AgentProfileParser;
use Magebit\UniversalCommerce\Model\IdempotencyHandler;
use Magebit\UniversalCommerce\Model\Data\Spec\Response\CheckoutResponse;
use Magebit\UniversalCommerce\Model\RequestValidator;
use Magento\Framework\App\RequestInterface;
use Magebit\UniversalCommerce\Service\CheckoutService;
use Magento\Framework\Exception\LocalizedException;

class Index extends ApiController implements HttpPostActionInterface
{
    /**
     * @param JsonFactory $jsonFactory
     * @param RequestInterface $request
     * @param RequestValidator $requestValidator
     * @param ErrorResponseInterfaceFactory $errorResponseFactory
     * @param MessageInterfaceFactory $messageFactory
     * @param AgentProfileParser $agentProfileParser
     * @param IdempotencyHandler $idempotencyHandler
     * @param CheckoutService $checkoutService
     * @param CheckoutCreateRequestInterfaceFactory $checkoutCreateRequestFactory
     */
    public function __construct(
        JsonFactory $jsonFactory,
        RequestInterface $request,
        RequestValidator $requestValidator,
        ErrorResponseInterfaceFactory $errorResponseFactory,
        MessageInterfaceFactory $messageFactory,
        private readonly AgentProfileParser $agentProfileParser,
        private readonly IdempotencyHandler $idempotencyHandler,
        private readonly CheckoutService $checkoutService,
        private readonly CheckoutCreateRequestInterfaceFactory $checkoutCreateRequestFactory,
    ) {
        parent::__construct($jsonFactory, $request, $requestValidator, $errorResponseFactory, $messageFactory);
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
        try {
            $ucpAgentHeader = $request->getHeader('UCP-Agent');

            if (!$ucpAgentHeader) {
                return $this->createSimpleErrorResponse(
                    'invalid_request',
                    'UCP-Agent header is required',
                    MessageInterface::SEVERITY_RECOVERABLE,
                    400
                );
            }

            $agentProfile = $this->agentProfileParser->parse((string) $ucpAgentHeader);

            $response = $this->checkoutService->createCheckout($requestObject, $agentProfile);
            /** @var CheckoutResponse $response */
            $this->idempotencyHandler->storeResponse($request, $response, 201);
            return $this->makeJsonResponse($response->toArray());
        } catch (LocalizedException $e) {
            return $this->createSimpleErrorResponse(
                'invalid_request',
                $e->getMessage(),
                MessageInterface::SEVERITY_RECOVERABLE,
                400
            );
        } catch (\Exception $e) {
            return $this->createSimpleErrorResponse(
                'internal_server_error',
                'An unexpected error occurred',
                MessageInterface::SEVERITY_RECOVERABLE,
                500
            );
        }
    }
}
