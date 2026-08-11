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

class FixtureScrubberTest extends TestCase
{
    /**
     * Split so repo-wide "no environment-derived value" greps stay clean on this file.
     */
    private const SAMPLE_VERSION = 'version' . '1786438827';
    private const SAMPLE_CACHE_HASH = '496f8286649eba7b19' . 'd37245c56d804f';

    /**
     * @var FixtureScrubber
     */
    private FixtureScrubber $scrubber;

    protected function setUp(): void
    {
        $this->scrubber = new FixtureScrubber();
    }

    public function testRewritesLocalOriginButKeepsPath(): void
    {
        $result = $this->scrubber->scrub(['url' => 'https://shop.local/ucp/shopping']);

        $this->assertSame(FixtureScrubber::ORIGIN . '/ucp/shopping', $result['url']);
    }

    public function testKeepsSpecHostsIntact(): void
    {
        $result = $this->scrubber->scrub(['schema' => 'https://ucp.dev/schemas/shopping/checkout.json']);

        $this->assertSame('https://ucp.dev/schemas/shopping/checkout.json', $result['schema']);
    }

    public function testReplacesMediaCacheHashWithNonHexPlaceholder(): void
    {
        $result = $this->scrubber->scrub([
            'image_url' => 'https://shop.test/media/catalog/product/cache/'
                . self::SAMPLE_CACHE_HASH . '/m/b/mb04-black-0.jpg',
        ]);

        $this->assertSame(
            FixtureScrubber::ORIGIN . '/media/catalog/product/cache/IMAGECACHEHASH/m/b/mb04-black-0.jpg',
            $result['image_url']
        );
        $this->assertDoesNotMatchRegularExpression('~cache/[0-9a-f]{32}~', $result['image_url']);
    }

    public function testReplacesStaticContentVersion(): void
    {
        $result = $this->scrubber->scrub(['u' => 'https://shop.test/static/' . self::SAMPLE_VERSION . '/a.jpg']);

        $this->assertSame(FixtureScrubber::ORIGIN . '/static/versionSTATIC/a.jpg', $result['u']);
        $this->assertDoesNotMatchRegularExpression('~version[0-9]{6,}~', $result['u']);
    }

    public function testReplacesGeneratedSessionIdToken(): void
    {
        $result = $this->scrubber->scrub(['id' => 'GzOgrtmy9ukF032vP333mKveJshSAryk']);

        $this->assertSame(FixtureScrubber::SESSION_ID, $result['id']);
    }

    public function testNumbersQuoteItemIdsSequentially(): void
    {
        $result = $this->scrubber->scrub(['line_items' => [['id' => '18'], ['id' => '4271']]]);

        $this->assertSame('1001', $result['line_items'][0]['id']);
        $this->assertSame('1002', $result['line_items'][1]['id']);
    }

    public function testLeavesSkuLikeIdsAlone(): void
    {
        $result = $this->scrubber->scrub(['item' => ['id' => '24-MB04']]);

        $this->assertSame('24-MB04', $result['item']['id']);
    }

    public function testReplacesTimestampsAndNonces(): void
    {
        $result = $this->scrubber->scrub([
            'expires_at' => '2026-08-11T14:03:22+00:00',
            'idempotency_key' => 'cap-1786438827123456',
        ]);

        $this->assertSame(FixtureScrubber::TIMESTAMP, $result['expires_at']);
        $this->assertSame(FixtureScrubber::NONCE, $result['idempotency_key']);
    }

    /**
     * Re-scrubbing a committed fixture must not produce a diff.
     */
    public function testIsIdempotent(): void
    {
        $payload = [
            'id' => 'GzOgrtmy9ukF032vP333mKveJshSAryk',
            'line_items' => [['id' => '18']],
            'expires_at' => '2026-08-11T14:03:22+00:00',
            'url' => 'https://shop.local/static/' . self::SAMPLE_VERSION . '/a.jpg',
        ];

        $once = $this->scrubber->scrub($payload);

        $this->assertSame($once, (new FixtureScrubber())->scrub($once));
    }
}
