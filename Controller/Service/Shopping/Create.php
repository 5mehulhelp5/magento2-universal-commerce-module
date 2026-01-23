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

use Magebit\UcpSpec\MutableApi\Schemas\Shopping\CheckoutCreateRequestInterface;
use Magebit\UcpSpec\MutableApi\Schemas\Shopping\CheckoutCreateRequestInterfaceFactory;
use Magebit\UniversalCommerce\Controller\ApiController;
use Magento\Framework\Controller\Result\Json as ResultJson;
use Magento\Framework\App\Request\Http;
use Magento\Framework\Controller\Result\JsonFactory;
use Magento\Framework\App\RequestInterface;
use Magebit\UniversalCommerce\Model\Validation\RequestValidator;
use Magebit\UniversalCommerce\Api\Service\Shopping\RestHandlerInterface;
use Magebit\UniversalCommerce\Model\Validation\ValidationResult;
use Magento\Framework\Api\DataObjectHelper;

class Create extends ApiController
{
    public function __construct(
        JsonFactory $resultJsonFactory,
        RequestInterface $request,
        RequestValidator $requestValidator,
        DataObjectHelper $dataObjectHelper,
        protected readonly CheckoutCreateRequestInterfaceFactory $checkoutCreateRequestFactory,
        protected readonly RestHandlerInterface $restHandler
    ) {
        parent::__construct($resultJsonFactory, $request, $requestValidator, $dataObjectHelper);
    }

    /**
     * @return ResultJson
     */
    public function execute(): ResultJson
    {
        $checkoutCreateRequest = $this->getAndValidateRequest(
            CheckoutCreateRequestInterface::class,
            $this->checkoutCreateRequestFactory->create(...)
        );

        if ($checkoutCreateRequest instanceof ValidationResult) {
            throw new \Exception('Invalid request');
        }

        $checkoutResponse = $this->restHandler->createCheckout($checkoutCreateRequest);
        return $this->makeJsonResponse($checkoutResponse);
    }
}
