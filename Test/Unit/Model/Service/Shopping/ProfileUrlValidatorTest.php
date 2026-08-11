<?php

/**
 * This file is part of the Magebit_UniversalCommerce package.
 *
 * @copyright Copyright (c) 2026 Magebit, Ltd. (https://magebit.com/)
 * @author    Magebit <info@magebit.com>
 * @license   MIT
 */

declare(strict_types=1);

namespace Magebit\UniversalCommerce\Test\Unit\Model\Service\Shopping;

use InvalidArgumentException;
use Magebit\UniversalCommerce\Model\Service\Shopping\ProfileUrlValidator;
use PHPUnit\Framework\TestCase;

class ProfileUrlValidatorTest extends TestCase
{
    /** @var ProfileUrlValidator */
    private ProfileUrlValidator $validator;

    /**
     * @return void
     */
    protected function setUp(): void
    {
        $this->validator = new ProfileUrlValidator();
    }

    /**
     * @param string $url
     * @return void
     * @dataProvider blockedUrlProvider
     */
    public function testRejectsUnsafeUrl(string $url): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->validator->assertFetchable($url);
    }

    /**
     * @return array<string, array{string}>
     */
    public static function blockedUrlProvider(): array
    {
        return [
            'loopback v4'          => ['https://127.0.0.1/profile.json'],
            'loopback by octet'    => ['https://127.99.1.2/profile.json'],
            'loopback v6'          => ['https://[::1]/profile.json'],
            'ipv4-mapped loopback' => ['https://[::ffff:127.0.0.1]/profile.json'],
            'link-local metadata'  => ['https://169.254.169.254/latest/meta-data/'],
            'rfc1918 ten'          => ['https://10.0.0.5/profile.json'],
            'rfc1918 172'          => ['https://172.16.4.4/profile.json'],
            'rfc1918 192'          => ['https://192.168.1.1/profile.json'],
            'unique local v6'      => ['https://[fd00::1]/profile.json'],
            'carrier grade nat'    => ['https://100.64.0.1/profile.json'],
            'benchmarking range'   => ['https://198.18.0.1/profile.json'],
            'protocol assignments' => ['https://192.0.0.1/profile.json'],
            'unspecified'          => ['https://0.0.0.0/profile.json'],
            'plain http'           => ['http://93.184.216.34/profile.json'],
            'file scheme'          => ['file:///etc/passwd'],
            'gopher scheme'        => ['gopher://93.184.216.34/'],
            'credentials in url'   => ['https://user:pass@93.184.216.34/profile.json'],
            'non standard port'    => ['https://93.184.216.34:8080/profile.json'],
            'internal port 6379'   => ['https://93.184.216.34:6379/'],
            'not a url'            => ['profile.json'],
            'scheme only'          => ['https://'],
        ];
    }

    /**
     * @return void
     */
    public function testAcceptsPublicAddressLiteral(): void
    {
        $this->assertSame(
            ['93.184.216.34'],
            $this->validator->assertFetchable('https://93.184.216.34/profile.json')
        );
    }

    /**
     * @return void
     */
    public function testAcceptsExplicitDefaultPort(): void
    {
        $this->assertSame(
            ['93.184.216.34'],
            $this->validator->assertFetchable('https://93.184.216.34:443/profile.json')
        );
    }

    /**
     * @return void
     */
    public function testAcceptsPublicIpv6Literal(): void
    {
        $this->assertSame(
            ['2606:2800:220:1:248:1893:25c8:1946'],
            $this->validator->assertFetchable('https://[2606:2800:220:1:248:1893:25c8:1946]/p.json')
        );
    }
}
