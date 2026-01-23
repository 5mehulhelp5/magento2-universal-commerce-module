<?php

/**
 * @author Magebit <info@magebit.com>
 * @copyright Copyright (c) Magebit, Ltd. (https://magebit.com)
 * @license https://magebit.com/code-license
 */
declare(strict_types=1);

namespace Magebit\UniversalCommerce\Model\Validation;

/**
 * Validation result container
 */
class ValidationResult
{
    /**
     * @param array<string, string> $errors Array of field path => error message
     */
    public function __construct(
        private readonly array $errors = []
    ) {
    }

    /**
     * Check if validation passed
     *
     * @return bool
     */
    public function isValid(): bool
    {
        return empty($this->errors);
    }

    /**
     * Get all validation errors
     *
     * @return array<string, string> Field path => error message
     */
    public function getErrors(): array
    {
        return $this->errors;
    }
}
