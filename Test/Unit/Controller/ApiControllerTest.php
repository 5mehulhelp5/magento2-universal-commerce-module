<?php

/**
 * This file is part of the Magebit_UniversalCommerce package.
 *
 * @copyright Copyright (c) 2026 Magebit, Ltd. (https://magebit.com/)
 * @author    Magebit <info@magebit.com>
 * @license   MIT
 */

declare(strict_types=1);

namespace Magebit\UniversalCommerce\Test\Unit\Controller;

use Magebit\UcpSpec\Api\Shopping\Types\MessageErrorInterface;
use Magebit\UcpSpec\Api\Shopping\Types\MessageErrorInterfaceFactory;
use Magebit\UcpSpec\Data\Shopping\Types\MessageError;
use Magebit\UniversalCommerce\Controller\ApiController;
use Magebit\UniversalCommerce\Model\Config;
use Magebit\UniversalCommerce\Model\IdempotencyHandler;
use Magebit\UniversalCommerce\Model\RequestClassBuilder;
use Magebit\UniversalCommerce\Model\Validation\RequestValidator;
use Magento\Framework\App\Request\Http;
use Magento\Framework\Controller\Result\Json as ResultJson;
use Magento\Framework\Controller\Result\JsonFactory;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;

class ApiControllerTest extends TestCase
{
    private const UUID = '3f2504e0-4f89-11d3-9a0c-0305e82c3301';

    /**
     * The spec marks Request-Id required, so a request without one is a transport-tier failure.
     *
     * @return void
     */
    public function testMissingRequestIdIsRejected(): void
    {
        $result = $this->controller(null)->errorBoundary(fn (): ResultJson => $this->fail('reached the handler'));

        $this->assertSame(400, $result->getHttpResponseCode());
        $this->assertSame('invalid_request', $this->firstMessage($result)->getCode());
    }

    /**
     * @return void
     */
    public function testNonUuidRequestIdIsRejected(): void
    {
        $result = $this->controller('not-a-uuid')->errorBoundary(fn (): ResultJson => $this->fail('reached'));

        $this->assertSame(400, $result->getHttpResponseCode());
    }

    /**
     * @return void
     */
    public function testValidRequestIdReachesTheHandler(): void
    {
        $expected = $this->createMock(ResultJson::class);

        $this->assertSame($expected, $this->controller(self::UUID)->errorBoundary(fn (): ResultJson => $expected));
    }

    /**
     * A merchant that has switched the requirement off must still be able to serve clients.
     *
     * @return void
     */
    public function testMissingRequestIdIsAllowedWhenNotRequired(): void
    {
        $expected = $this->createMock(ResultJson::class);
        $controller = $this->controller(null, required: false);

        $this->assertSame($expected, $controller->errorBoundary(fn (): ResultJson => $expected));
    }

    /**
     * Every error the boundary produces has to carry the four fields the spec requires.
     *
     * @return void
     */
    public function testBoundaryErrorsCarryTypeContentAndSeverity(): void
    {
        $message = $this->firstMessage(
            $this->controller(null)->errorBoundary(fn (): ResultJson => $this->fail('reached'))
        );

        $this->assertSame(MessageErrorInterface::TYPE_ERROR, $message->getType());
        $this->assertNotSame('', $message->getContent());
        $this->assertSame(MessageErrorInterface::SEVERITY_RECOVERABLE, $message->getSeverity());
    }

    /**
     * @param ResultJson $result Response produced by the boundary
     * @return MessageErrorInterface
     */
    private function firstMessage(ResultJson $result): MessageErrorInterface
    {
        $data = $result->getData();
        $this->assertIsArray($data);
        $this->assertArrayHasKey('messages', $data);

        return $data['messages'][0];
    }

    /**
     * @param string|null $requestId Value of the trace header, or null when absent
     * @param bool $required Whether the merchant requires the header
     * @return ApiController
     */
    private function controller(?string $requestId, bool $required = true): ApiController
    {
        $request = $this->createMock(Http::class);
        $request->method('getHeader')->willReturn($requestId ?? false);

        $config = $this->createMock(Config::class);
        $config->method('isRequestIdRequired')->willReturn($required);

        $messageFactory = $this->createMock(MessageErrorInterfaceFactory::class);
        $messageFactory->method('create')->willReturnCallback(static fn (): MessageError => new MessageError());

        $jsonFactory = $this->createMock(JsonFactory::class);
        $jsonFactory->method('create')->willReturnCallback(fn (): ResultJson => $this->resultJson());

        return new class (
            $jsonFactory,
            $request,
            $this->createMock(RequestValidator::class),
            $this->createMock(RequestClassBuilder::class),
            $config,
            $messageFactory,
            $this->createMock(IdempotencyHandler::class),
            $this->createMock(LoggerInterface::class)
        ) extends ApiController {
            /**
             * @return ResultJson
             */
            public function execute(): ResultJson
            {
                return $this->makeJsonResponse([]);
            }
        };
    }

    /**
     * @return ResultJson A stub that records the payload and status it is handed
     */
    private function resultJson(): ResultJson
    {
        $state = ['data' => null, 'code' => 200];

        $json = $this->getMockBuilder(ResultJson::class)
            ->disableOriginalConstructor()
            ->onlyMethods(['setData', 'setHttpResponseCode', 'setHeader'])
            ->addMethods(['getData', 'getHttpResponseCode'])
            ->getMock();

        $json->method('setData')->willReturnCallback(
            function ($data) use (&$state, $json) {
                $state['data'] = $data;

                return $json;
            }
        );
        $json->method('getData')->willReturnCallback(function () use (&$state) {
            return $state['data'];
        });
        $json->method('setHttpResponseCode')->willReturnCallback(
            function ($code) use (&$state, $json) {
                $state['code'] = (int)$code;

                return $json;
            }
        );
        $json->method('getHttpResponseCode')->willReturnCallback(function () use (&$state): int {
            return $state['code'];
        });
        $json->method('setHeader')->willReturn($json);

        return $json;
    }
}
