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

class IdempotencyHandler
{
    public function __construct(
        private readonly IdempotencyKeyRepositoryInterface $idempotencyRepository,
        private readonly JsonFactory $resultJsonFactory
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
                $resultJson->setData($idempotency->getResponseBody());
                $resultJson->setHttpResponseCode(201);
                return $resultJson;
            }
        } catch (NoSuchEntityException $e) {
            return null;
        }

        return null;
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
