<?php

/**
 * @author Magebit <info@magebit.com>
 * @copyright Copyright (c) Magebit, Ltd. (https://magebit.com)
 * @license https://magebit.com/code-license
 */

declare(strict_types=1);

namespace Magebit\UniversalCommerce\Controller\Checkout\Sessions;

use Magebit\UniversalCommerce\Api\Data\Response\ErrorResponseInterfaceFactory;
use Magebit\UniversalCommerce\Api\Data\Response\MessageInterface;
use Magebit\UniversalCommerce\Api\Data\Response\MessageInterfaceFactory;
use Magebit\UniversalCommerce\Controller\ApiController;
use Magebit\UniversalCommerce\Model\AgentProfileParser;
use Magebit\UniversalCommerce\Model\Data\Spec\Schemas\Shopping\CheckoutResponse;
use Magebit\UniversalCommerce\Model\RequestValidator;
use Magebit\UniversalCommerce\Service\CheckoutService;
use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\App\Request\Http;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\Controller\Result\JsonFactory;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;

/**
 * Get Checkout Session Controller
 */
class Retrieve extends ApiController implements HttpGetActionInterface
{
    /**
     * @param JsonFactory $jsonFactory
     * @param RequestInterface $request
     * @param RequestValidator $requestValidator
     * @param ErrorResponseInterfaceFactory $errorResponseFactory
     * @param MessageInterfaceFactory $messageFactory
     * @param AgentProfileParser $agentProfileParser
     * @param CheckoutService $checkoutService
     */
    public function __construct(
        JsonFactory $jsonFactory,
        RequestInterface $request,
        RequestValidator $requestValidator,
        ErrorResponseInterfaceFactory $errorResponseFactory,
        MessageInterfaceFactory $messageFactory,
        private readonly AgentProfileParser $agentProfileParser,
        private readonly CheckoutService $checkoutService,
    ) {
        parent::__construct($jsonFactory, $request, $requestValidator, $errorResponseFactory, $messageFactory);
    }

    /**
     * Execute action to retrieve checkout session
     *
     * @return ResultInterface
     */
    public function execute(): ResultInterface
    {
        /** @var Http $request */
        $request = $this->getRequest();

        // Validate UCP-Agent header
        $ucpAgentHeader = $request->getHeader('UCP-Agent');
        if (!$ucpAgentHeader) {
            return $this->createSimpleErrorResponse(
                'invalid_request',
                'UCP-Agent header is required',
                MessageInterface::SEVERITY_RECOVERABLE,
                400
            );
        }

        // Get session ID from URL parameter
        $sessionId = $request->getParam('id');
        if (!$sessionId) {
            return $this->createSimpleErrorResponse(
                'invalid_request',
                'Session ID is required',
                MessageInterface::SEVERITY_RECOVERABLE,
                400
            );
        }

        try {
            // Parse agent profile (for future use)
            $agentProfile = $this->agentProfileParser->parse((string) $ucpAgentHeader);

            // Get checkout session
            $response = $this->checkoutService->getCheckout($sessionId);

            /** @var CheckoutResponse $response */
            return $this->makeJsonResponse($response->toArray());
        } catch (NoSuchEntityException $e) {
            return $this->createSimpleErrorResponse(
                'not_found',
                'Checkout session not found',
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
