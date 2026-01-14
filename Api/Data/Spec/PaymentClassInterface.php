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
 * Payment Class Interface
 * Represents payment information
 */
interface PaymentClassInterface
{
    public const INSTRUMENTS = 'instruments';
    public const SELECTED_INSTRUMENT_ID = 'selected_instrument_id';

    /**
     * Get instruments
     *
     * @return PaymentInstrumentInterface[]|null
     */
    public function getInstruments(): ?array;

    /**
     * Set instruments
     *
     * @param PaymentInstrumentInterface[]|null $instruments
     * @return $this
     */
    public function setInstruments(?array $instruments): self;

    /**
     * Get selected instrument ID
     *
     * @return string|null
     */
    public function getSelectedInstrumentId(): ?string;

    /**
     * Set selected instrument ID
     *
     * @param string|null $selectedInstrumentId
     * @return $this
     */
    public function setSelectedInstrumentId(?string $selectedInstrumentId): self;
}
