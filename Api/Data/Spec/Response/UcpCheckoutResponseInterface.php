<?php

/**
 * This file is part of the Magebit_UniversalCommerce package.
 *
 * @copyright Copyright (c) 2026 Magebit, Ltd. (https://magebit.com/)
 * @author    Magebit <info@magebit.com>
 * @license   MIT
 */

declare(strict_types=1);

namespace Magebit\UniversalCommerce\Api\Data\Spec\Response;

/**
 * UCP Checkout Response Interface
 * Represents UCP metadata in the checkout response
 */
interface UcpCheckoutResponseInterface
{
    public const CAPABILITIES = 'capabilities';
    public const VERSION = 'version';

    /**
     * Get capabilities
     *
     * @return CapabilityResponseInterface[]
     */
    public function getCapabilities(): array;

    /**
     * Set capabilities
     *
     * @param CapabilityResponseInterface[] $capabilities
     * @return $this
     */
    public function setCapabilities(array $capabilities): self;

    /**
     * Get version
     *
     * @return string
     */
    public function getVersion(): string;

    /**
     * Set version
     *
     * @param string $version
     * @return $this
     */
    public function setVersion(string $version): self;
}
