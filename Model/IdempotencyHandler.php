<?php

/**
 * This file is part of the Magebit_UniversalCommerce package.
 *
 * @copyright Copyright (c) 2026 Magebit, Ltd. (https://magebit.com/)
 * @author    Magebit <info@magebit.com>
 * @license   MIT
 */

declare(strict_types=1);

namespace Magebit\UniversalCommerce\Model;

use Magento\Framework\App\Request\Http;
use Magebit\UniversalCommerce\Api\IdempotencyKeyRepositoryInterface;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Controller\Result\JsonFactory;
use Magento\Framework\Controller\Result\Json as ResultJson;
use Magebit\UniversalCommerce\Api\Data\IdempotencyKeyInterface;
use Magebit\UniversalCommerce\Api\Data\IdempotencyKeyInterfaceFactory;
use Magebit\UniversalCommerce\Model\Data\DataTransferObject;

class IdempotencyHandler
{
    public function __construct(
        protected readonly IdempotencyKeyRepositoryInterface $idempotencyRepository,
        protected readonly IdempotencyKeyInterfaceFactory $idempotencyKeyFactory,
        protected readonly JsonFactory $resultJsonFactory
    ) {
    }

    /**
     * @param Http $request
     * @return ResultJson|null
     */
    public function handle(Http $request): ?ResultJson
    {
        $idempotencyKey = $request->getHeader('Idempotency-Key');

        if (!$idempotencyKey) {
            return null;
        }

        try {
            $idempotency = $this->idempotencyRepository->getByKey((string) $idempotencyKey);

            if ($idempotency->getRequestHash() === $this->hashRequest($request)) {
                $resultJson = $this->resultJsonFactory->create();
                $resultJson->setJsonData($idempotency->getResponseBody() ?? '');
                $resultJson->setHttpResponseCode($idempotency->getResponseStatus() ?? 200);
                return $resultJson;
            }
        } catch (NoSuchEntityException $e) {
            return null;
        }

        return null;
    }

    /**
     * @param Http $request
     * @param DataTransferObject $response
     * @param int $status
     * @return IdempotencyKeyInterface|null
     */
    public function storeResponse(Http $request, DataTransferObject $response, int $status): ?IdempotencyKeyInterface
    {
        $idempotencyKey = $request->getHeader('Idempotency-Key');

        if (!$idempotencyKey) {
            return null;
        }

        $responseBody = json_encode($response->toArray());

        /** @var IdempotencyKeyInterface $idempotency */
        $idempotency = $this->idempotencyKeyFactory->create();
        $idempotency->setKey((string) $idempotencyKey);
        $idempotency->setRequestHash($this->hashRequest($request));
        $idempotency->setResponseBody($responseBody);
        $idempotency->setResponseStatus($status);

        $this->idempotencyRepository->save($idempotency);

        return $idempotency;
    }

    /**
     * @param Http $request
     * @return string
     */
    protected function hashRequest(Http $request): string
    {
        return hash('sha256', (string) json_encode([
            'method' => $request->getMethod(),
            'path' => $request->getPathInfo(),
            'query' => $request->getQuery(),
            'body' => $request->getContent(),
        ]));
    }
}
