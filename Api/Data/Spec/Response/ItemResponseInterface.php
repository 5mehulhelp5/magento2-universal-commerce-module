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
 * Item Response Interface
 * Represents an item in the checkout response
 */
interface ItemResponseInterface
{
    public const ID = 'id';
    public const IMAGE_URL = 'image_url';
    public const PRICE = 'price';
    public const TITLE = 'title';

    /**
     * Get ID
     *
     * @return string
     */
    public function getId(): string;

    /**
     * Set ID
     *
     * @param string $id
     * @return $this
     */
    public function setId(string $id): self;

    /**
     * Get image URL
     *
     * @return string|null
     */
    public function getImageUrl(): ?string;

    /**
     * Set image URL
     *
     * @param string|null $imageUrl
     * @return $this
     */
    public function setImageUrl(?string $imageUrl): self;

    /**
     * Get price
     *
     * @return float
     */
    public function getPrice(): float;

    /**
     * Set price
     *
     * @param float $price
     * @return $this
     */
    public function setPrice(float $price): self;

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle(): string;

    /**
     * Set title
     *
     * @param string $title
     * @return $this
     */
    public function setTitle(string $title): self;
}
