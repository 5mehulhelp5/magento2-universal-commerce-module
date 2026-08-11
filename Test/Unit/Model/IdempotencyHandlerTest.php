<?php

/**
 * This file is part of the Magebit_UniversalCommerce package.
 *
 * @copyright Copyright (c) 2026 Magebit, Ltd. (https://magebit.com/)
 * @author    Magebit <info@magebit.com>
 * @license   MIT
 */

declare(strict_types=1);

namespace Magebit\UniversalCommerce\Test\Unit\Model;

use Magebit\UcpSpec\Api\Shopping\Types\MessageInterfaceFactory;
use Magebit\UniversalCommerce\Api\Data\IdempotencyKeyInterface;
use Magebit\UniversalCommerce\Api\Data\IdempotencyKeyInterfaceFactory;
use Magebit\UniversalCommerce\Api\IdempotencyKeyRepositoryInterface;
use Magebit\UniversalCommerce\Model\IdempotencyHandler;
use Magento\Framework\App\Request\Http;
use Magento\Framework\Controller\Result\Json as ResultJson;
use Magento\Framework\Controller\Result\JsonFactory;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Stdlib\DateTime\DateTime;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class IdempotencyHandlerTest extends TestCase
{
    private const KEY = 'test-key';
    private const BODY = '{"line_items":[]}';

    /** @var IdempotencyKeyRepositoryInterface&MockObject */
    private IdempotencyKeyRepositoryInterface $repository;

    /** @var JsonFactory&MockObject */
    private JsonFactory $resultJsonFactory;

    /** @var IdempotencyHandler */
    private IdempotencyHandler $handler;

    /**
     * @return void
     */
    protected function setUp(): void
    {
        $this->repository = $this->createMock(IdempotencyKeyRepositoryInterface::class);
        $this->resultJsonFactory = $this->createMock(JsonFactory::class);

        $this->resultJsonFactory->method('create')->willReturnCallback(
            fn (): ResultJson => $this->createMock(ResultJson::class)
        );

        $dateTime = $this->createMock(DateTime::class);
        $dateTime->method('gmtDate')->willReturn('2026-01-01 00:00:00');

        $this->handler = new IdempotencyHandler(
            $this->repository,
            $this->createMock(IdempotencyKeyInterfaceFactory::class),
            $this->resultJsonFactory,
            $this->createMock(MessageInterfaceFactory::class),
            $dateTime
        );
    }

    /**
     * @return void
     */
    public function testUnclaimedKeyLetsTheCallerProceed(): void
    {
        $this->repository->method('claim')->willReturn(true);

        $this->assertNull($this->handler->handle($this->request('POST', self::KEY)));
    }

    /**
     * @return void
     */
    public function testSafeMethodIsNeverReplayed(): void
    {
        $this->repository->expects($this->never())->method('claim');
        $this->repository->expects($this->never())->method('getByKey');

        $this->assertNull($this->handler->handle($this->request('GET', self::KEY)));
    }

    /**
     * @return void
     */
    public function testMissingKeyLetsTheCallerProceed(): void
    {
        $this->repository->expects($this->never())->method('claim');

        $this->assertNull($this->handler->handle($this->request('POST', null)));
    }

    /**
     * @return void
     */
    public function testSameKeyAndBodyReplaysStoredResponse(): void
    {
        $this->repository->method('claim')->willReturn(false);
        $this->repository->method('getByKey')->willReturn(
            $this->storedKey($this->currentRequestHash(), 201)
        );

        $this->assertInstanceOf(ResultJson::class, $this->handler->handle($this->request('POST', self::KEY)));
    }

    /**
     * A different body under the same key must conflict, never replay the wrong response.
     *
     * @return void
     */
    public function testSameKeyDifferentBodyDoesNotReplay(): void
    {
        $stored = $this->storedKey('a-different-hash', 201);
        $stored->expects($this->never())->method('getResponseBody');

        $this->repository->method('claim')->willReturn(false);
        $this->repository->method('getByKey')->willReturn($stored);

        $this->assertInstanceOf(ResultJson::class, $this->handler->handle($this->request('POST', self::KEY)));
    }

    /**
     * A claim purged between the failed insert and the read must not block the caller.
     *
     * @return void
     */
    public function testVanishedClaimLetsTheCallerProceed(): void
    {
        $this->repository->method('claim')->willReturn(false);
        $this->repository->method('getByKey')->willThrowException(new NoSuchEntityException());

        $this->assertNull($this->handler->handle($this->request('POST', self::KEY)));
    }

    /**
     * @return void
     */
    public function testInFlightClaimIsNotExecutedTwice(): void
    {
        $this->repository->method('claim')->willReturn(false);
        $this->repository->method('getByKey')->willReturn(
            $this->storedKey($this->currentRequestHash(), null)
        );
        $this->repository->method('reclaimAbandoned')->willReturn(false);

        $this->assertInstanceOf(ResultJson::class, $this->handler->handle($this->request('POST', self::KEY)));
    }

    /**
     * @return void
     */
    public function testAbandonedClaimIsTakenOver(): void
    {
        $this->repository->method('claim')->willReturn(false);
        $this->repository->method('getByKey')->willReturn(
            $this->storedKey($this->currentRequestHash(), null)
        );
        $this->repository->method('reclaimAbandoned')->willReturn(true);

        $this->assertNull($this->handler->handle($this->request('POST', self::KEY)));
    }

    /**
     * @param string $requestHash
     * @param int|null $status
     * @return IdempotencyKeyInterface&MockObject
     */
    private function storedKey(string $requestHash, ?int $status): IdempotencyKeyInterface
    {
        $stored = $this->createMock(IdempotencyKeyInterface::class);
        $stored->method('getRequestHash')->willReturn($requestHash);
        $stored->method('getResponseStatus')->willReturn($status);
        $stored->method('getResponseBody')->willReturn('{"id":"abc"}');

        return $stored;
    }

    /**
     * @param string $method
     * @param string|null $key
     * @return Http&MockObject
     */
    private function request(string $method, ?string $key): Http
    {
        $request = $this->createMock(Http::class);
        $request->method('getMethod')->willReturn($method);
        $request->method('getHeader')->willReturn($key ?? false);
        $request->method('getContent')->willReturn(self::BODY);
        $request->method('getPathInfo')->willReturn('/ucp/shopping/checkout-sessions');

        return $request;
    }

    /**
     * Mirrors the handler's own hashing so a "same request" case really matches.
     *
     * @return string
     */
    private function currentRequestHash(): string
    {
        $reflection = new \ReflectionMethod(IdempotencyHandler::class, 'hashRequest');
        $reflection->setAccessible(true);

        return $reflection->invoke($this->handler, $this->request('POST', self::KEY));
    }
}
