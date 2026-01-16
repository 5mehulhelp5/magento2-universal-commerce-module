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
 * Fulfillment Response Interface
 * Represents fulfillment data in checkout response
 */
interface FulfillmentResponseInterface
{
    public const AVAILABLE_METHODS = 'available_methods';
    public const METHODS = 'methods';

    /**
     * Get available methods
     *
     * @return FulfillmentAvailableMethodResponseInterface[]|null
     */
    public function getAvailableMethods(): ?array;

    /**
     * Set available methods
     *
     * @param FulfillmentAvailableMethodResponseInterface[]|null $availableMethods
     * @return $this
     */
    public function setAvailableMethods(?array $availableMethods): self;

    /**
     * Get methods
     *
     * @return FulfillmentMethodResponseInterface[]|null
     */
    public function getMethods(): ?array;

    /**
     * Set methods
     *
     * @param FulfillmentMethodResponseInterface[]|null $methods
     * @return $this
     */
    public function setMethods(?array $methods): self;
}
