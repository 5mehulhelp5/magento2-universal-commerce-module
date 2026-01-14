<?php

/**
 * This file is part of the Magebit_UniversalCommerce package.
 *
 * @copyright Copyright (c) 2026 Magebit, Ltd. (https://magebit.com/)
 * @author    Magebit <info@magebit.com>
 * @license   MIT
 */

declare(strict_types=1);

namespace Magebit\UniversalCommerce\Api\Data\Spec;

/**
 * Item Create Request Interface
 * Represents an item in a create request
 */
interface ItemCreateRequestInterface
{
    public const ID = 'id';

    /**
     * Get item ID
     *
     * @return string
     */
    public function getId(): string;

    /**
     * Set item ID
     *
     * @param string $id
     * @return $this
     */
    public function setId(string $id): self;
}
