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
 * Checkout Response Status Interface
 * Defines status constants for checkout responses
 */
interface CheckoutResponseStatusInterface
{
    public const STATUS_CANCELED = 'canceled';
    public const STATUS_COMPLETE_IN_PROGRESS = 'complete_in_progress';
    public const STATUS_COMPLETED = 'completed';
    public const STATUS_INCOMPLETE = 'incomplete';
    public const STATUS_READY_FOR_COMPLETE = 'ready_for_complete';
    public const STATUS_REQUIRES_ESCALATION = 'requires_escalation';
}
