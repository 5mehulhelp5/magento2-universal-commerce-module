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

use Magebit\UniversalCommerce\Api\Data\Spec\PaymentInstrumentInterface;

/**
 * Payment Response Interface
 * Represents payment data in the checkout response
 */
interface PaymentResponseInterface
{
    public const HANDLERS = 'handlers';
    public const INSTRUMENTS = 'instruments';
    public const SELECTED_INSTRUMENT_ID = 'selected_instrument_id';

    /**
     * Get handlers
     *
     * @return PaymentHandlerResponseInterface[]
     */
    public function getHandlers(): array;

    /**
     * Set handlers
     *
     * @param PaymentHandlerResponseInterface[] $handlers
     * @return $this
     */
    public function setHandlers(array $handlers): self;

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
