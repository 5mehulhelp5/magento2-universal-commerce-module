<?php

/**
 * This file is part of the Magebit_UniversalCommerce package.
 *
 * @copyright Copyright (c) 2026 Magebit, Ltd. (https://magebit.com/)
 * @author    Magebit <info@magebit.com>
 * @license   MIT
 */

declare(strict_types=1);

namespace Magebit\UniversalCommerce\Test\Unit\Model\Discovery;

use Magebit\UniversalCommerce\Api\Discovery\CapabilityInterface;
use Magebit\UniversalCommerce\Model\Discovery\UcpDiscoveryProfile;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\MockObject\MockObject;

class UcpDiscoveryProfileTest extends TestCase
{
    /**
     * @var UcpDiscoveryProfile
     */
    private UcpDiscoveryProfile $ucpDiscoveryProfile;

    /**
     * @var MockObject
     */
    private MockObject $mockCapability;

    /**
     * Set up test environment
     *
     * @return void
     */
    protected function setUp(): void
    {
        $this->mockCapability = $this->createMock(CapabilityInterface::class);
    }

    /**
     * Test getVersion returns correct version
     *
     * @return void
     */
    public function testGetVersionReturnsCorrectVersion(): void
    {
        $this->ucpDiscoveryProfile = new UcpDiscoveryProfile();

        $version = $this->ucpDiscoveryProfile->getVersion();

        $this->assertEquals(UcpDiscoveryProfile::UCP_VERSION, $version);
        $this->assertEquals('2026-01-11', $version);
    }

    /**
     * Test getCapabilities returns empty array when no capabilities provided
     *
     * @return void
     */
    public function testGetCapabilitiesReturnsEmptyArrayWhenNoCapabilities(): void
    {
        $this->ucpDiscoveryProfile = new UcpDiscoveryProfile([]);

        $capabilities = $this->ucpDiscoveryProfile->getCapabilities();

        $this->assertIsArray($capabilities);
        $this->assertEmpty($capabilities);
    }

    /**
     * Test getCapabilities returns formatted capabilities
     *
     * @return void
     */
    public function testGetCapabilitiesReturnsFormattedCapabilities(): void
    {
        $this->mockCapability
            ->method('getName')
            ->willReturn('dev.ucp.shopping.checkout');

        $this->mockCapability
            ->method('getVersion')
            ->willReturn('2026-01-11');

        $this->mockCapability
            ->method('getSpec')
            ->willReturn('https://ucp.dev/specs/checkout');

        $this->mockCapability->expects($this->once())
            ->method('getSpec')
            ->willReturn('https://ucp.dev/specs/checkout');

        $this->mockCapability->expects($this->once())
            ->method('getSchema')
            ->willReturn('https://ucp.dev/schemas/shopping/checkout.json');

        // @phpstan-ignore argument.type
        $this->ucpDiscoveryProfile = new UcpDiscoveryProfile([$this->mockCapability]);

        $capabilities = $this->ucpDiscoveryProfile->getCapabilities();

        $this->assertIsArray($capabilities);
        $this->assertCount(1, $capabilities);
        $this->assertArrayHasKey('name', $capabilities[0]);
        $this->assertArrayHasKey('version', $capabilities[0]);
        $this->assertArrayHasKey('spec', $capabilities[0]);
        $this->assertArrayHasKey('schema', $capabilities[0]);
        $this->assertEquals('dev.ucp.shopping.checkout', $capabilities[0]['name']);
        $this->assertEquals('2026-01-11', $capabilities[0]['version']);
        $this->assertEquals('https://ucp.dev/specs/checkout', $capabilities[0]['spec']);
        $this->assertEquals('https://ucp.dev/schemas/shopping/checkout.json', $capabilities[0]['schema']);
    }

    /**
     * Test getCapabilities with multiple capabilities
     *
     * @return void
     */
    public function testGetCapabilitiesWithMultipleCapabilities(): void
    {
        $mockCapability1 = $this->createMock(CapabilityInterface::class);
        $mockCapability1->method('getName')->willReturn('capability.one');
        $mockCapability1->method('getVersion')->willReturn('1.0.0');
        $mockCapability1->method('getSpec')->willReturn('https://example.com/spec1');
        $mockCapability1->method('getSchema')->willReturn('https://example.com/schema1.json');

        $mockCapability2 = $this->createMock(CapabilityInterface::class);
        $mockCapability2->method('getName')->willReturn('capability.two');
        $mockCapability2->method('getVersion')->willReturn('2.0.0');
        $mockCapability2->method('getSpec')->willReturn('https://example.com/spec2');
        $mockCapability2->method('getSchema')->willReturn('https://example.com/schema2.json');

        $this->ucpDiscoveryProfile = new UcpDiscoveryProfile([
            $mockCapability1,
            $mockCapability2
        ]);

        $capabilities = $this->ucpDiscoveryProfile->getCapabilities();

        $this->assertCount(2, $capabilities);
        $this->assertEquals('capability.one', $capabilities[0]['name']);
        $this->assertEquals('capability.two', $capabilities[1]['name']);
    }

    /**
     * Test jsonSerialize returns correct structure
     *
     * @return void
     */
    public function testJsonSerializeReturnsCorrectStructure(): void
    {
        $this->ucpDiscoveryProfile = new UcpDiscoveryProfile([]);

        $result = $this->ucpDiscoveryProfile->jsonSerialize();

        $this->assertIsArray($result);
        $this->assertArrayHasKey('ucp', $result);
        $this->assertArrayHasKey('payment', $result);
        $this->assertArrayHasKey('version', $result['ucp']);
        $this->assertArrayHasKey('capabilities', $result['ucp']);
        $this->assertArrayHasKey('handlers', $result['payment']);
    }

    /**
     * Test jsonSerialize with capabilities
     *
     * @return void
     */
    public function testJsonSerializeWithCapabilities(): void
    {
        $this->mockCapability->method('getName')->willReturn('dev.ucp.shopping.checkout');
        $this->mockCapability->method('getVersion')->willReturn('2026-01-11');
        $this->mockCapability->method('getSpec')->willReturn('https://ucp.dev/specs/checkout');
        $this->mockCapability->method('getSchema')->willReturn('https://ucp.dev/schemas/shopping/checkout.json');

        // @phpstan-ignore argument.type
        $this->ucpDiscoveryProfile = new UcpDiscoveryProfile([$this->mockCapability]);

        $result = $this->ucpDiscoveryProfile->jsonSerialize();
        $this->assertEquals('2026-01-11', $result['ucp']['version']);
        $this->assertCount(1, $result['ucp']['capabilities']);
        $this->assertEquals('dev.ucp.shopping.checkout', $result['ucp']['capabilities'][0]['name']);
        $this->assertIsArray($result['payment']['handlers']);
        $this->assertEmpty($result['payment']['handlers']);
    }

    /**
     * Test jsonSerialize can be JSON encoded
     *
     * @return void
     */
    public function testJsonSerializeCanBeJsonEncoded(): void
    {
        $this->mockCapability->method('getName')->willReturn('test.capability');
        $this->mockCapability->method('getVersion')->willReturn('1.0.0');
        $this->mockCapability->method('getSpec')->willReturn('https://test.com/spec');
        $this->mockCapability->method('getSchema')->willReturn('https://test.com/schema.json');

        // @phpstan-ignore argument.type
        $this->ucpDiscoveryProfile = new UcpDiscoveryProfile([$this->mockCapability]);

        $json = json_encode($this->ucpDiscoveryProfile);

        $this->assertIsString($json);
        $this->assertNotFalse($json);

        $decoded = json_decode($json, true);
        $this->assertIsArray($decoded);
        $this->assertArrayHasKey('ucp', $decoded);
        $this->assertArrayHasKey('payment', $decoded);
    }

    /**
     * Test UcpDiscoveryProfile implements JsonSerializable
     *
     * @return void
     */
    public function testImplementsJsonSerializable(): void
    {
        $this->ucpDiscoveryProfile = new UcpDiscoveryProfile([]);

        $this->assertInstanceOf(\JsonSerializable::class, $this->ucpDiscoveryProfile);
    }

    /**
     * Test version constant is accessible
     *
     * @return void
     */
    public function testVersionConstantIsAccessible(): void
    {
        $this->assertIsString(UcpDiscoveryProfile::UCP_VERSION);
        $this->assertNotEmpty(UcpDiscoveryProfile::UCP_VERSION);
    }
}
