<?php

/**
 * This file is part of the Magebit_UniversalCommerce package.
 *
 * @copyright Copyright (c) 2026 Magebit, Ltd. (https://magebit.com/)
 * @author    Magebit <info@magebit.com>
 * @license   MIT
 */
declare(strict_types=1);

namespace Magebit\UniversalCommerce\Exception;

use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Phrase;

class UcpException extends LocalizedException
{
    public function __construct(
        Phrase $phrase,
        public readonly string $type = 'error',
        public readonly string $typeCode = 'requires_escalation',
        public readonly int $statusCode = 500
    ) {
        parent::__construct($phrase);
    }

    /**
     * Get status code
     *
     * @return int
     */
    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    /**
     * Get type code
     *
     * @return string
     */
    public function getTypeCode(): string
    {
        return $this->typeCode;
    }

    /**
     * Get type
     *
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }
}
