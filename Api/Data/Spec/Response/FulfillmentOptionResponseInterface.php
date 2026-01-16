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
 * Fulfillment Option Response Interface
 * Represents a fulfillment option (shipping/pickup option)
 */
interface FulfillmentOptionResponseInterface
{
    public const CARRIER = 'carrier';
    public const DESCRIPTION = 'description';
    public const EARLIEST_FULFILLMENT_TIME = 'earliest_fulfillment_time';
    public const ID = 'id';
    public const LATEST_FULFILLMENT_TIME = 'latest_fulfillment_time';
    public const SUBTOTAL = 'subtotal';
    public const TAX = 'tax';
    public const TITLE = 'title';
    public const TOTAL = 'total';

    /**
     * Get carrier
     *
     * @return string|null
     */
    public function getCarrier(): ?string;

    /**
     * Set carrier
     *
     * @param string|null $carrier
     * @return $this
     */
    public function setCarrier(?string $carrier): self;

    /**
     * Get description
     *
     * @return string|null
     */
    public function getDescription(): ?string;

    /**
     * Set description
     *
     * @param string|null $description
     * @return $this
     */
    public function setDescription(?string $description): self;

    /**
     * Get earliest fulfillment time
     *
     * @return string|null
     */
    public function getEarliestFulfillmentTime(): ?string;

    /**
     * Set earliest fulfillment time
     *
     * @param string|null $earliestFulfillmentTime
     * @return $this
     */
    public function setEarliestFulfillmentTime(?string $earliestFulfillmentTime): self;

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
     * Get latest fulfillment time
     *
     * @return string|null
     */
    public function getLatestFulfillmentTime(): ?string;

    /**
     * Set latest fulfillment time
     *
     * @param string|null $latestFulfillmentTime
     * @return $this
     */
    public function setLatestFulfillmentTime(?string $latestFulfillmentTime): self;

    /**
     * Get subtotal
     *
     * @return float|null
     */
    public function getSubtotal(): ?float;

    /**
     * Set subtotal
     *
     * @param float|null $subtotal
     * @return $this
     */
    public function setSubtotal(?float $subtotal): self;

    /**
     * Get tax
     *
     * @return float|null
     */
    public function getTax(): ?float;

    /**
     * Set tax
     *
     * @param float|null $tax
     * @return $this
     */
    public function setTax(?float $tax): self;

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

    /**
     * Get total
     *
     * @return float
     */
    public function getTotal(): float;

    /**
     * Set total
     *
     * @param float $total
     * @return $this
     */
    public function setTotal(float $total): self;
}
