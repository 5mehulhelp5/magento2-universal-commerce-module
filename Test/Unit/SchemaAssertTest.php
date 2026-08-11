<?php

/**
 * This file is part of the Magebit_UniversalCommerce package.
 *
 * @copyright Copyright (c) 2026 Magebit, Ltd. (https://magebit.com/)
 * @author    Magebit <info@magebit.com>
 * @license   MIT
 */

declare(strict_types=1);

namespace Magebit\UniversalCommerce\Test\Unit;

use PHPUnit\Framework\AssertionFailedError;
use PHPUnit\Framework\SkippedTestError;
use PHPUnit\Framework\TestCase;

/**
 * Self-test for the schema harness, exercised against real vendored spec schemas.
 */
class SchemaAssertTest extends TestCase
{
    use SchemaAssert;

    private const TOTAL_SCHEMA = 'shopping/types/total_resp.json';

    public function testAcceptsPayloadMatchingSchema(): void
    {
        $this->assertMatchesSchema(
            ['type' => 'subtotal', 'amount' => 6400, 'display_text' => 'Subtotal'],
            self::TOTAL_SCHEMA
        );
    }

    public function testRejectsPayloadViolatingEnumAndReportsPointers(): void
    {
        try {
            $this->assertMatchesSchema(['type' => 'not_a_total_type', 'amount' => 100], self::TOTAL_SCHEMA);
        } catch (AssertionFailedError $error) {
            $message = $error->getMessage();
            $this->assertStringContainsString('[enum]', $message);
            $this->assertStringContainsString('data: #/type', $message);
            $this->assertStringContainsString('schema: #/properties/type/enum', $message);

            return;
        }

        $this->fail('Expected the enum violation to fail the assertion.');
    }

    public function testRejectsPayloadMissingRequiredProperty(): void
    {
        $this->expectException(AssertionFailedError::class);
        $this->expectExceptionMessageMatches('/\[required\]/');

        $this->assertMatchesSchema(['type' => 'subtotal'], self::TOTAL_SCHEMA);
    }

    public function testRejectsWrongScalarType(): void
    {
        $this->expectException(AssertionFailedError::class);
        $this->expectExceptionMessageMatches('/\[type\]/');

        $this->assertMatchesSchema(['type' => 'subtotal', 'amount' => '6400'], self::TOTAL_SCHEMA);
    }

    /**
     * Cross-file $ref resolution is the part most likely to silently no-op, so assert it really fires.
     */
    public function testResolvesRefsAcrossSchemaDirectory(): void
    {
        try {
            $this->assertMatchesSchema(
                self::minimalCheckout(['line_items' => [['id' => '1', 'item' => ['id' => 'SKU'], 'quantity' => 0]]]),
                'shopping/checkout_resp.json'
            );
        } catch (AssertionFailedError $error) {
            // types/line_item_resp.json only applies if the relative $ref was followed.
            $this->assertStringContainsString('schema: #/properties/quantity/minimum', $error->getMessage());

            return;
        }

        $this->fail('Expected the nested line item violation to fail the assertion.');
    }

    public function testSkipsWhenSchemaIsNotVendored(): void
    {
        $this->expectException(SkippedTestError::class);
        $this->expectExceptionMessageMatches('/is not vendored/');

        $this->assertMatchesSchema(['anything' => true], 'shopping/definitely_not_vendored.json');
    }

    /**
     * @param array<string, mixed> $overrides
     * @return array<string, mixed>
     */
    private static function minimalCheckout(array $overrides = []): array
    {
        return $overrides + [
            'ucp' => ['version' => '2026-01-23', 'payment_handlers' => (object) []],
            'id' => 'ucp_test_checkout_session_0001',
            'line_items' => [],
            'status' => 'incomplete',
            'currency' => 'USD',
            'totals' => [],
            'links' => [],
        ];
    }
}
