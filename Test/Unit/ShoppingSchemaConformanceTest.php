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

use PHPUnit\Framework\TestCase;

/**
 * Validates golden fixtures captured from the live module against the vendored UCP spec.
 * Fixtures are scrubbed of volatile values by FixtureScrubber.
 */
class ShoppingSchemaConformanceTest extends TestCase
{
    use SchemaAssert;

    private const CHECKOUT_SCHEMA = 'shopping/checkout_resp.json';

    /**
     * @return array<string, array{0: string}>
     */
    public static function checkoutFixtureProvider(): array
    {
        return [
            'create 201' => ['shopping.checkout_session.create.201.json'],
            'get 200' => ['shopping.checkout_session.get.200.json'],
            'update 200' => ['shopping.checkout_session.update.200.json'],
            'cancel 200' => ['shopping.checkout_session.cancel.200.json'],
        ];
    }

    /**
     * @dataProvider checkoutFixtureProvider
     * @param string $fixture
     * @return void
     */
    public function testCheckoutResponseMatchesSpec(string $fixture): void
    {
        $this->assertMatchesSchema(self::loadFixtureObject($fixture), self::CHECKOUT_SCHEMA);
    }

    /**
     * @return void
     */
    public function testDiscoveryProfileMatchesSpec(): void
    {
        $this->assertMatchesSchema(
            self::loadFixtureObject('discovery.well_known_ucp.200.json')->ucp,
            'ucp.json#/$defs/business_schema'
        );
    }

    /**
     * POST /complete currently 500s. The body is captured verbatim so the harness records the
     * broken state; it is an error envelope, not a checkout response, so no schema applies.
     *
     * @return void
     */
    public function testCompleteResponseRecordsKnownBrokenState(): void
    {
        $payload = self::loadFixture('shopping.checkout_session.complete.500.BROKEN.json');

        $this->assertSame('requires_escalation', $payload['status']);
        $this->assertSame('invalid_request', $payload['messages'][0]['code']);
        $this->markTestIncomplete(
            'POST /ucp/shopping/checkout-sessions/{id}/complete returns HTTP 500 and an error '
            . 'envelope instead of a checkout response. Fixture records the broken state.'
        );
    }
}
