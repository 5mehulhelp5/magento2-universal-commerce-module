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

use Magento\Framework\App\ActionInterface;
use Magento\Framework\App\CsrfAwareActionInterface;
use Magento\Framework\App\Request\InvalidRequestException;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\Controller\Result\JsonFactory;
use Magento\Framework\Controller\Result\Json as ResultJson;
use Magento\Framework\DataObject;
use Magebit\UniversalCommerce\Model\Validation\RequestValidator;
use Magebit\UniversalCommerce\Model\Validation\ValidationResult;
use Magebit\UniversalCommerce\Model\RequestClassBuilder;
use Magebit\UcpSpec\MutableApi\Schemas\Shopping\Types\MessageInterface;
use Magebit\UcpSpec\MutableApi\Schemas\Shopping\Types\MessageInterfaceFactory;
use Magento\Framework\App\Request\Http;
use Magento\Framework\Exception\LocalizedException;
use Magebit\UniversalCommerce\Model\IdempotencyHandler;

abstract class ApiController implements ActionInterface, CsrfAwareActionInterface
{
    /**
     * @param JsonFactory $resultJsonFactory
     * @param RequestInterface $request
     * @param RequestValidator $requestValidator
     * @param RequestClassBuilder $requestClassBuilder
     * @param MessageInterfaceFactory $messageFactory
     * @param IdempotencyHandler $idempotencyHandler
     */
    public function __construct(
        protected readonly JsonFactory $resultJsonFactory,
        protected readonly RequestInterface $request,
        protected readonly RequestValidator $requestValidator,
        protected readonly RequestClassBuilder $requestClassBuilder,
        protected readonly MessageInterfaceFactory $messageFactory,
        protected readonly IdempotencyHandler $idempotencyHandler
    ) {
    }

    /**
     * @template T
     * @param class-string<T> $classType
     * @param callable $factory
     * @return T|ValidationResult
     */
    public function getAndValidateRequest(string $classType, callable $factory): mixed
    {
        $request = $this->getHttpRequest();
        $data = $request->getContent();
        $rawData = (array) json_decode($data, true);

        $validationResult = $this->requestValidator->validate($rawData, $classType);

        if (!$validationResult->isValid()) {
            return $validationResult;
        }

        $requestObject = $factory();
        $this->requestClassBuilder->populateWithArray($requestObject, $rawData, $classType);

        return $requestObject;
    }

    /**
     * Handle idempotency
     *
     * @return ResultJson|null
     */
    public function handleIdempotency(): ?ResultJson
    {
        try {
            if ($idempotencyResponse = $this->idempotencyHandler->handle($this->getHttpRequest())) {
                return $idempotencyResponse;
            }
        } catch (LocalizedException $e) {
            return $this->makeErrorResponse('requires_escalation', [
                $this->messageFactory->create(['data' => [
                    'type' => 'error',
                    'code' => 'invalid_request',
                    'message' => $e->getMessage(),
                ]])
            ], 400);
        }

        return null;
    }

    /**
     * Convert ValidationResult to UCP-compliant error response
     *
     * @param ValidationResult $validationResult
     * @return ResultJson
     */
    public function validationResultToResponse(ValidationResult $validationResult): ResultJson
    {
        $messages = [];
        $errors = $validationResult->getErrors();

        foreach ($errors as $path => $content) {
            /** @var MessageInterface $message */
            $message = $this->messageFactory->create(['data' => [
                'type' => 'error',
                'code' => 'validation_error',
                'path' => $path === '' ? null : $path,
                'content' => $content,
                'severity' => 'requires_buyer_input'
            ]]);

            $messages[] = $message;
        }

        return $this->makeErrorResponse('requires_escalation', $messages, 400);
    }

    /**
     * Make error response
     *
     * @param string $status
     * @param array<MessageInterface> $messages
     * @param int $statusCode
     * @return ResultJson
     */
    public function makeErrorResponse(string $status, array $messages, int $statusCode = 400): ResultJson
    {
        return $this->makeJsonResponse([
            'status' => $status,
            'messages' => $messages
        ], $statusCode);
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
     * @return Http
     */
    public function getHttpRequest(): Http
    {
        /** @var Http $request */
        $request = $this->request;

        if (!$request instanceof Http) {
            throw new LocalizedException(__('Invalid request'));
        }

        return $request;
    }
}
