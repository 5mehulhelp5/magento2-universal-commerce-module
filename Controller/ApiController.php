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
use Magento\Framework\App\Request\Http;

abstract class ApiController implements ActionInterface, CsrfAwareActionInterface
{
    /**
     * @param JsonFactory $resultJsonFactory
     * @param RequestInterface $request
     * @param RequestValidator $requestValidator
     * @param RequestClassBuilder $requestClassBuilder
     */
    public function __construct(
        protected readonly JsonFactory $resultJsonFactory,
        protected readonly RequestInterface $request,
        protected readonly RequestValidator $requestValidator,
        protected readonly RequestClassBuilder $requestClassBuilder
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
        /** @var Http $request */
        $request = $this->getRequest();
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
