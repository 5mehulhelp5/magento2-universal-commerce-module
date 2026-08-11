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

use Magebit\UniversalCommerce\Test\Unit\Model\Stub\MapKeyedDto;
use Magebit\UniversalCommerce\Model\DataTransferObject;
use PHPUnit\Framework\TestCase;
use stdClass;

class DataTransferObjectTest extends TestCase
{
    /**
     * @return void
     */
    public function testEmptyMapKeyEncodesAsJsonObject(): void
    {
        $dto = new MapKeyedDto();
        $dto->setData('payment_handlers', []);

        $this->assertSame('{"payment_handlers":{}}', json_encode($dto));
    }

    /**
     * @return void
     */
    public function testPopulatedMapKeyIsUntouched(): void
    {
        $dto = new MapKeyedDto();
        $dto->setData('payment_handlers', ['dev.ucp.card' => [['version' => '1']]]);

        $this->assertSame(
            '{"payment_handlers":{"dev.ucp.card":[{"version":"1"}]}}',
            json_encode($dto)
        );
    }

    /**
     * @return void
     */
    public function testUndeclaredEmptyArrayStaysAnArray(): void
    {
        $dto = new MapKeyedDto();
        $dto->setData('line_items', []);

        $this->assertSame('{"line_items":[]}', json_encode($dto));
    }

    /**
     * @return void
     */
    public function testNullValuesAreOmitted(): void
    {
        $dto = new MapKeyedDto();
        $dto->setData('version', '2026-01-23');
        $dto->setData('expires_at', null);

        $this->assertSame('{"version":"2026-01-23"}', json_encode($dto));
    }

    /**
     * @return void
     */
    public function testMapKeyConversionSurvivesNesting(): void
    {
        $inner = new MapKeyedDto();
        $inner->setData('payment_handlers', []);

        $outer = new DataTransferObject();
        $outer->setData('ucp', $inner);

        $this->assertSame('{"ucp":{"payment_handlers":{}}}', json_encode($outer));
    }

    /**
     * @return void
     */
    public function testConvertedValueIsAnObjectNotAnArray(): void
    {
        $dto = new MapKeyedDto();
        $dto->setData('payment_handlers', []);

        $this->assertInstanceOf(stdClass::class, $dto->jsonSerialize()['payment_handlers']);
    }
}
