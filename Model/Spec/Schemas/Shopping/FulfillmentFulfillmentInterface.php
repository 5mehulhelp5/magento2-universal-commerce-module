<?php

/**
 * @author Magebit <info@magebit.com>
 * @copyright Copyright (c) Magebit, Ltd. (https://magebit.com)
 * @license https://magebit.com/code-license
 */

declare(strict_types=1);

namespace Magebit\UcpSpec\MutableApi\Schemas\Shopping;

use Magebit\UcpSpec\MutableApi\Schemas\Shopping\Types\FulfillmentMethodResponseInterface;
use Magebit\UcpSpec\MutableApi\Schemas\Shopping\Types\FulfillmentAvailableMethodResponseInterface;

/**
 * Fulfillment details container.
 * This interface matches FulfillmentResponseInterface structure but is in the Shopping namespace.
 */
interface FulfillmentFulfillmentInterface
{
    public const KEY_METHODS = 'methods';
    public const KEY_AVAILABLE_METHODS = 'available_methods';

    /**
     * Fulfillment methods for cart items.
     *
     * @return FulfillmentMethodResponseInterface[]|null
     */
    public function getMethods(): array|null;

    /**
     * Inventory availability hints.
     *
     * @return FulfillmentAvailableMethodResponseInterface[]|null
     */
    public function getAvailableMethods(): array|null;

    /**
     * Fulfillment methods for cart items.
     *
     * @param FulfillmentMethodResponseInterface[]|null $methods
     * @return self
     */
    public function setMethods(?array $methods): self;

    /**
     * Inventory availability hints.
     *
     * @param FulfillmentAvailableMethodResponseInterface[]|null $availableMethods
     * @return self
     */
    public function setAvailableMethods(?array $availableMethods): self;
}
