<?php

/**
 * This file is part of the Magebit_UniversalCommerce package.
 *
 * @copyright Copyright (c) 2026 Magebit, Ltd. (https://magebit.com/)
 * @author    Magebit <info@magebit.com>
 * @license   MIT
 */

declare(strict_types=1);

namespace Magebit\UniversalCommerce\Api\Discovery;

interface ServiceInterface
{
    /**
     * Get version
     *
     * @return string
     */
    public function getVersion(): string;

    /**
     * Get spec
     *
     * @return string
     */
    public function getSpec(): string;

    /**
     * Get schema
     *
     * @return string
     */
    public function getRestSchema(): string;

    /**
     * Get rest endpoint
     *
     * @return string
     */
    public function getRestEndpoint(): string;
}
