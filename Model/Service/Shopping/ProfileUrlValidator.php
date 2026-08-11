<?php

/**
 * This file is part of the Magebit_UniversalCommerce package.
 *
 * @copyright Copyright (c) 2026 Magebit, Ltd. (https://magebit.com/)
 * @author    Magebit <info@magebit.com>
 * @license   MIT
 */

declare(strict_types=1);

namespace Magebit\UniversalCommerce\Model\Service\Shopping;

use InvalidArgumentException;

/**
 * Guards server-side fetches of caller-supplied profile URLs against SSRF.
 */
class ProfileUrlValidator
{
    public const ALLOWED_SCHEMES = ['https'];
    public const ALLOWED_PORTS = [443];

    /**
     * Ranges filter_var's reserved/private flags miss, as CIDR.
     */
    private const EXTRA_BLOCKED_RANGES = [
        '100.64.0.0/10',    // RFC 6598 carrier-grade NAT
        '192.0.0.0/24',     // RFC 6890 IETF protocol assignments
        '192.31.196.0/24',  // AS112-v4
        '192.52.193.0/24',  // AMT
        '198.18.0.0/15',    // RFC 2544 benchmarking
    ];

    /**
     * Resolve the host and confirm every address it maps to is publicly routable.
     *
     * Returns the resolved addresses so the caller can pin them for the request
     * itself, which is what closes the DNS-rebinding window between check and fetch.
     *
     * @param string $url
     * @return string[]
     * @throws InvalidArgumentException
     */
    public function assertFetchable(string $url): array
    {
        $parts = parse_url($url);

        if ($parts === false || !isset($parts['scheme'], $parts['host'])) {
            throw new InvalidArgumentException('Profile URL is not a valid absolute URL.');
        }

        if (!in_array(strtolower($parts['scheme']), self::ALLOWED_SCHEMES, true)) {
            throw new InvalidArgumentException('Profile URL scheme is not allowed.');
        }

        if (isset($parts['user']) || isset($parts['pass'])) {
            throw new InvalidArgumentException('Profile URL must not carry credentials.');
        }

        if (isset($parts['port']) && !in_array($parts['port'], self::ALLOWED_PORTS, true)) {
            throw new InvalidArgumentException('Profile URL port is not allowed.');
        }

        $addresses = $this->resolve($parts['host']);

        if ($addresses === []) {
            throw new InvalidArgumentException('Profile URL host does not resolve.');
        }

        foreach ($addresses as $address) {
            if (!$this->isPubliclyRoutable($address)) {
                throw new InvalidArgumentException('Profile URL resolves to a non-public address.');
            }
        }

        return $addresses;
    }

    /**
     * @param string $host
     * @return string[]
     */
    private function resolve(string $host): array
    {
        $literal = trim($host, '[]');

        if (filter_var($literal, FILTER_VALIDATE_IP) !== false) {
            return [$literal];
        }

        // An unresolvable host is an expected outcome here, not an error worth emitting.
        // phpcs:ignore Generic.PHP.NoSilencedErrors.Discouraged
        $records = @dns_get_record($host, DNS_A | DNS_AAAA);

        if ($records === false) {
            return [];
        }

        $addresses = [];

        foreach ($records as $record) {
            $addresses[] = $record['ip'] ?? $record['ipv6'] ?? null;
        }

        return array_values(array_filter($addresses, 'is_string'));
    }

    /**
     * @param string $address
     * @return bool
     */
    private function isPubliclyRoutable(string $address): bool
    {
        // ::ffff:127.0.0.1 would otherwise pass the IPv6 checks and reach loopback.
        if (preg_match('/^::ffff:(\d+\.\d+\.\d+\.\d+)$/i', $address, $m)) {
            $address = $m[1];
        }

        $public = filter_var(
            $address,
            FILTER_VALIDATE_IP,
            FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE
        );

        if ($public === false) {
            return false;
        }

        foreach (self::EXTRA_BLOCKED_RANGES as $range) {
            if ($this->inCidr($address, $range)) {
                return false;
            }
        }

        return true;
    }

    /**
     * @param string $address
     * @param string $cidr
     * @return bool
     */
    private function inCidr(string $address, string $cidr): bool
    {
        [$subnet, $bits] = explode('/', $cidr);

        $ip = ip2long($address);
        $net = ip2long($subnet);

        if ($ip === false || $net === false) {
            return false;
        }

        $mask = -1 << (32 - (int) $bits);

        return ($ip & $mask) === ($net & $mask);
    }
}
