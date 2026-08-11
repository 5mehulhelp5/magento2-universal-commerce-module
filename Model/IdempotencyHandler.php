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

use Magebit\UcpSpec\MutableApi\Schemas\Shopping\Types\MessageInterface;
use Magebit\UcpSpec\MutableApi\Schemas\Shopping\Types\MessageInterfaceFactory;
use Magebit\UniversalCommerce\Api\Data\IdempotencyKeyInterface;
use Magebit\UniversalCommerce\Api\Data\IdempotencyKeyInterfaceFactory;
use Magebit\UniversalCommerce\Api\IdempotencyKeyRepositoryInterface;
use Magento\Framework\App\Request\Http;
use Magento\Framework\Controller\Result\Json as ResultJson;
use Magento\Framework\Controller\Result\JsonFactory;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Stdlib\DateTime\DateTime;

class IdempotencyHandler
{
    public const HEADER_NAME = 'Idempotency-Key';

    /**
     * Replaying a safe method would hide current state, so idempotency applies to unsafe methods only.
     */
    private const SAFE_METHODS = ['GET', 'HEAD', 'OPTIONS', 'TRACE'];

    /**
     * A claim older than this without a stored response is treated as abandoned by a crashed request.
     */
    private const ABANDONED_CLAIM_SECONDS = 60;

    /**
     * Advertised in Retry-After while another caller still owns the claim.
     */
    private const RETRY_AFTER_SECONDS = 1;

    /**
     * @param IdempotencyKeyRepositoryInterface $idempotencyRepository
     * @param IdempotencyKeyInterfaceFactory $idempotencyKeyFactory
     * @param JsonFactory $resultJsonFactory
     * @param MessageInterfaceFactory $messageFactory
     * @param DateTime $dateTime
     */
    public function __construct(
        protected readonly IdempotencyKeyRepositoryInterface $idempotencyRepository,
        protected readonly IdempotencyKeyInterfaceFactory $idempotencyKeyFactory,
        protected readonly JsonFactory $resultJsonFactory,
        protected readonly MessageInterfaceFactory $messageFactory,
        protected readonly DateTime $dateTime
    ) {
    }

    /**
     * Claim the key, or return the replay / conflict response the caller must send instead.
     *
     * @param Http $request
     * @return ResultJson|null Null means the caller owns the key and must execute the operation.
     */
    public function handle(Http $request): ?ResultJson
    {
        $key = $this->getKey($request);

        if ($key === null) {
            return null;
        }

        $requestHash = $this->hashRequest($request);

        if ($this->idempotencyRepository->claim($key, $requestHash)) {
            return null;
        }

        try {
            $idempotency = $this->idempotencyRepository->getByKey($key);
        } catch (NoSuchEntityException $exception) {
            // Purged between the failed claim and this read; nothing to replay.
            return null;
        }

        if ($idempotency->getRequestHash() !== $requestHash) {
            return $this->makeConflictResponse(
                'idempotency_key_reuse',
                'Idempotency-Key was already used for a different request.'
            );
        }

        if ($idempotency->getResponseStatus() === null) {
            return $this->handleInFlight($key, $requestHash);
        }

        return $this->makeReplayResponse($idempotency);
    }

    /**
     * @param Http $request
     * @param DataTransferObject $response
     * @param int $status
     * @return IdempotencyKeyInterface|null
     */
    public function storeResponse(Http $request, DataTransferObject $response, int $status): ?IdempotencyKeyInterface
    {
        $key = $this->getKey($request);

        if ($key === null) {
            return null;
        }

        try {
            $idempotency = $this->idempotencyRepository->getByKey($key);
        } catch (NoSuchEntityException $exception) {
            /** @var IdempotencyKeyInterface $idempotency */
            $idempotency = $this->idempotencyKeyFactory->create();
            $idempotency->setKey($key);
        }

        $idempotency->setRequestHash($this->hashRequest($request));
        $idempotency->setResponseBody((string) json_encode($response));
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

    /**
     * @param Http $request
     * @return string|null Null when idempotency does not apply to this request.
     */
    protected function getKey(Http $request): ?string
    {
        if (in_array(strtoupper($request->getMethod()), self::SAFE_METHODS, true)) {
            return null;
        }

        $key = $request->getHeader(self::HEADER_NAME);

        if (!is_string($key) || $key === '') {
            return null;
        }

        return $key;
    }

    /**
     * @param string $key
     * @param string $requestHash
     * @return ResultJson|null Null when the abandoned claim was taken over.
     */
    protected function handleInFlight(string $key, string $requestHash): ?ResultJson
    {
        $abandonedBefore = $this->dateTime->gmtDate(
            'Y-m-d H:i:s',
            $this->dateTime->gmtTimestamp() - self::ABANDONED_CLAIM_SECONDS
        );

        if ($this->idempotencyRepository->reclaimAbandoned($key, $requestHash, $abandonedBefore)) {
            return null;
        }

        $result = $this->makeConflictResponse(
            'idempotency_key_in_flight',
            'A request with this Idempotency-Key is still being processed.'
        );
        $result->setHeader('Retry-After', (string) self::RETRY_AFTER_SECONDS, true);

        return $result;
    }

    /**
     * @param IdempotencyKeyInterface $idempotency
     * @return ResultJson
     */
    protected function makeReplayResponse(IdempotencyKeyInterface $idempotency): ResultJson
    {
        $result = $this->resultJsonFactory->create();
        $result->setJsonData($idempotency->getResponseBody() ?? '');
        $result->setHttpResponseCode((int) $idempotency->getResponseStatus());

        return $result;
    }

    /**
     * @param string $code
     * @param string $message
     * @return ResultJson
     */
    protected function makeConflictResponse(string $code, string $message): ResultJson
    {
        /** @var MessageInterface $messageObject */
        $messageObject = $this->messageFactory->create(['data' => [
            'type' => 'error',
            'code' => $code,
            'message' => $message,
        ]]);

        $result = $this->resultJsonFactory->create();
        $result->setData([
            'status' => 'requires_escalation',
            'messages' => [$messageObject],
        ]);
        $result->setHttpResponseCode(409);

        return $result;
    }
}
