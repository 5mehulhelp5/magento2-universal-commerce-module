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
 * Link Interface
 * Represents a link in the checkout response
 */
interface LinkInterface
{
    public const TITLE = 'title';
    public const TYPE = 'type';
    public const URL = 'url';

    /**
     * Get title
     *
     * @return string|null
     */
    public function getTitle(): ?string;

    /**
     * Set title
     *
     * @param string|null $title
     * @return $this
     */
    public function setTitle(?string $title): self;

    /**
     * Get type
     *
     * @return string
     */
    public function getType(): string;

    /**
     * Set type
     *
     * @param string $type
     * @return $this
     */
    public function setType(string $type): self;

    /**
     * Get URL
     *
     * @return string
     */
    public function getUrl(): string;

    /**
     * Set URL
     *
     * @param string $url
     * @return $this
     */
    public function setUrl(string $url): self;
}
