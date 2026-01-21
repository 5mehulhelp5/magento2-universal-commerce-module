<?php

/**
 * @author Magebit <info@magebit.com>
 * @copyright Copyright (c) Magebit, Ltd. (https://magebit.com)
 * @license https://magebit.com/code-license
 */

declare(strict_types=1);

namespace Magebit\UniversalCommerce\Controller\Checkout\Sessions;

use Magebit\UniversalCommerce\Api\Data\Response\ErrorResponseInterface;
use Magebit\UniversalCommerce\Api\Data\Response\ErrorResponseInterfaceFactory;
use Magebit\UniversalCommerce\Api\Data\Response\MessageInterface;
use Magebit\UniversalCommerce\Api\Data\Response\MessageInterfaceFactory;
use Magebit\UniversalCommerce\Controller\ApiController;
use Magebit\UniversalCommerce\Model\Data\Spec\Schemas\Shopping\CheckoutResponse;
use Magebit\UniversalCommerce\Model\RequestValidator;
use Magebit\UniversalCommerce\Service\CheckoutService;
use Magebit\UcpSpec\MutableApi\Schemas\Shopping\PaymentDataInterfaceFactory;
use Magebit\UniversalCommerce\Model\AgentProfileParser;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\App\Request\Http;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\Controller\Result\JsonFactory;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;

/**
 * Complete Checkout Session Controller
 */
class Complete extends ApiController implements HttpPostActionInterface
{
    /**
     * @param JsonFactory $jsonFactory
     * @param RequestInterface $request
     * @param RequestValidator $requestValidator
     * @param ErrorResponseInterfaceFactory $errorResponseFactory
     * @param MessageInterfaceFactory $messageFactory
     * @param CheckoutService $checkoutService
     * @param PaymentDataInterfaceFactory $paymentDataFactory
     * @param AgentProfileParser $agentProfileParser
     */
    public function __construct(
        JsonFactory $jsonFactory,
        RequestInterface $request,
        RequestValidator $requestValidator,
        ErrorResponseInterfaceFactory $errorResponseFactory,
        MessageInterfaceFactory $messageFactory,
        private readonly CheckoutService $checkoutService,
        private readonly PaymentDataInterfaceFactory $paymentDataFactory,
        private readonly AgentProfileParser $agentProfileParser
    ) {
        parent::__construct($jsonFactory, $request, $requestValidator, $errorResponseFactory, $messageFactory);
    }

    /**
     * Execute action to complete checkout session
     *
     * @return ResultInterface
     */
    public function execute(): ResultInterface
    {
        /** @var Http $request */
        $request = $this->getRequest();

        $sessionId = $request->getParam('id');
        if (!$sessionId || !is_string($sessionId)) {
            return $this->createSimpleErrorResponse(
                'invalid_request',
                'Session ID is required',
                MessageInterface::SEVERITY_RECOVERABLE,
                400
            );
        }

        // Validate and create request object
        $requestObject = $this->createRequestObjectAndValidate(
            fn($data) => $this->paymentDataFactory->create($data)
        );

        // Handle validation errors
        if ($requestObject instanceof ErrorResponseInterface) {
            return $this->makeErrorResponse($requestObject, 400);
        }

        try {
            // Parse agent profile to get webhook URL
            $ucpAgentHeader = $request->getHeader('UCP-Agent');
            $platformConfig = null;

            if ($ucpAgentHeader) {
                $platformConfig = $this->agentProfileParser->parse((string) $ucpAgentHeader);
            }

            $response = $this->checkoutService->completeCheckout($sessionId, $requestObject, $platformConfig);

            /** @var CheckoutResponse $response */
            return $this->makeJsonResponse($response->toArray());
        } catch (NoSuchEntityException $e) {
            return $this->createSimpleErrorResponse(
                'not_found',
                $e->getMessage(),
                MessageInterface::SEVERITY_RECOVERABLE,
                404
            );
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
