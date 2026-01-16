<?php

/**
 * This file is part of the Magebit_UniversalCommerce package.
 *
 * @copyright Copyright (c) 2026 Magebit, Ltd. (https://magebit.com/)
 * @author    Magebit <info@magebit.com>
 * @license   MIT
 */

declare(strict_types=1);

namespace Magebit\UniversalCommerce\Controller;

use InvalidArgumentException;
use Magebit\UniversalCommerce\Api\Data\Response\ErrorResponseInterface;
use Magebit\UniversalCommerce\Api\Data\Response\ErrorResponseInterfaceFactory;
use Magebit\UniversalCommerce\Api\Data\Response\MessageInterface;
use Magebit\UniversalCommerce\Api\Data\Response\MessageInterfaceFactory;
use Magebit\UniversalCommerce\Model\RequestValidator;
use Magento\Framework\App\ActionInterface;
use Magento\Framework\App\CsrfAwareActionInterface;
use Magento\Framework\App\Request\InvalidRequestException;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\App\Request\Http;
use Magento\Framework\Controller\Result\JsonFactory;
use Magento\Framework\Controller\Result\Json as ResultJson;
use Magento\Framework\DataObject;

abstract class ApiController implements ActionInterface, CsrfAwareActionInterface
{
    /**
     * @param JsonFactory $resultJsonFactory
     * @param RequestInterface $request
     * @param RequestValidator $requestValidator
     * @param ErrorResponseInterfaceFactory $errorResponseFactory
     * @param MessageInterfaceFactory $messageFactory
     */
    public function __construct(
        protected readonly JsonFactory $resultJsonFactory,
        protected readonly RequestInterface $request,
        protected readonly RequestValidator $requestValidator,
        protected readonly ErrorResponseInterfaceFactory $errorResponseFactory,
        protected readonly MessageInterfaceFactory $messageFactory,
    ) {
    }

    /**
     * Create and validate request object from JSON
     *
     * @template T
     * @param callable(array<mixed>): T $factory
     * @return T|ErrorResponseInterface
     */
    protected function createRequestObjectAndValidate(callable $factory): mixed
    {
        /** @var Http $request */
        $request = $this->getRequest();

        /** @var string $content */
        $content = $request->getContent();
        $rawData = json_decode($content, true);

        if (!is_array($rawData)) {
            return $this->errorResponseFactory->create(['data' => [
                ErrorResponseInterface::STATUS => ErrorResponseInterface::STATUS_INVALID_REQUEST,
                ErrorResponseInterface::MESSAGES => [[
                    'type' => 'error',
                    'code' => 'invalid_json',
                    'severity' => 'recoverable',
                    'content' => 'Invalid JSON in request body',
                ]],
            ]]);
        }

        $requestObject = $factory(['data' => $rawData]);

        if ($validationError = $this->requestValidator->validate($requestObject)) {
            return $validationError;
        }

        return $requestObject;
    }

    /**
     * Create error message
     *
     * @param string $code
     * @param string $content
     * @param string $severity
     * @param string $type
     * @return MessageInterface
     */
    protected function createErrorMessage(
        string $code,
        string $content,
        string $severity = MessageInterface::SEVERITY_RECOVERABLE,
        string $type = MessageInterface::TYPE_ERROR
    ): MessageInterface {
        $message = $this->messageFactory->create();
        $message->setType($type);
        $message->setCode($code);
        $message->setSeverity($severity);
        $message->setContent($content);

        return $message;
    }

    /**
     * Create error response from exception
     *
     * @param \Exception $exception
     * @param string $code
     * @param string $severity
     * @param int $statusCode
     * @return ResultJson
     */
    protected function createErrorResponseFromException(
        \Exception $exception,
        string $code = 'server_error',
        string $severity = MessageInterface::SEVERITY_RECOVERABLE,
        int $statusCode = 500
    ): ResultJson {
        $message = $this->createErrorMessage($code, $exception->getMessage(), $severity);
        return $this->createErrorResponseWithMessages([$message], $statusCode);
    }

    /**
     * Create error response with messages
     *
     * @param MessageInterface[] $messages
     * @param int $statusCode
     * @param string $status
     * @return ResultJson
     */
    protected function createErrorResponseWithMessages(
        array $messages,
        int $statusCode = 400,
        string $status = ErrorResponseInterface::STATUS_REQUIRES_ESCALATION
    ): ResultJson {
        $errorResponse = $this->errorResponseFactory->create();
        $errorResponse->setStatus($status);
        $errorResponse->setMessages($messages);

        return $this->makeErrorResponse($errorResponse, $statusCode);
    }

    /**
     * Create simple error response
     *
     * @param string $code
     * @param string $content
     * @param string $severity
     * @param int $statusCode
     * @return ResultJson
     */
    protected function createSimpleErrorResponse(
        string $code,
        string $content,
        string $severity = MessageInterface::SEVERITY_RECOVERABLE,
        int $statusCode = 400
    ): ResultJson {
        $message = $this->createErrorMessage($code, $content, $severity);
        return $this->createErrorResponseWithMessages([$message], $statusCode);
    }

    /**
     * Make error response
     *
     * @param ErrorResponseInterface $errorResponse
     * @param int $statusCode
     * @return ResultJson
     * @throws InvalidArgumentException
     */
    public function makeErrorResponse(ErrorResponseInterface $errorResponse, int $statusCode = 400): ResultJson
    {
        return $this->makeJsonResponse($errorResponse->toArray(), $statusCode);
    }

    /**
     * Make JSON response
     *
     * @param array<mixed>|DataObject $data
     * @param int $statusCode
     * @return ResultJson
     */
    public function makeJsonResponse(array|DataObject $data, int $statusCode = 200): ResultJson
    {
        $resultJson = $this->resultJsonFactory->create();
        $resultJson->setData($data);
        $resultJson->setHttpResponseCode($statusCode);

        return $resultJson;
    }

    /**
     * @param RequestInterface $request
     * @return InvalidRequestException|null
     */
    public function createCsrfValidationException(RequestInterface $request): ?InvalidRequestException
    {
        return null;
    }

    /**
     * @param RequestInterface $request
     * @return bool|null
     */
    public function validateForCsrf(RequestInterface $request): ?bool
    {
        return true;
    }

    /**
     * @return RequestInterface
     */
    public function getRequest(): RequestInterface
    {
        return $this->request;
    }
}
