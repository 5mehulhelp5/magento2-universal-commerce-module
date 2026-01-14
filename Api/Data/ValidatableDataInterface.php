<?php

/**
 * This file is part of the Magebit_UniversalCommerce package.
 *
 * @copyright Copyright (c) 2026 Magebit, Ltd. (https://magebit.com/)
 * @author    Magebit <info@magebit.com>
 * @license   MIT
 */

declare(strict_types=1);

namespace Magebit\UniversalCommerce\Api\Data;

use Symfony\Component\Validator\Mapping\ClassMetadata;

/**
 * Interface for validatable data objects
 * Objects implementing this interface can define validation rules via Symfony Validator
 */
interface ValidatableDataInterface
{
    /**
     * Load validator metadata
     *
     * @param ClassMetadata $metadata
     * @return void
     */
    public static function loadValidatorMetadata(ClassMetadata $metadata): void;
}
