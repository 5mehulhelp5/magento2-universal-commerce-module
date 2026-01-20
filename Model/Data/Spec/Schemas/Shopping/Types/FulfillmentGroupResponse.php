<?php

/**
 * This file is part of the Magebit_UniversalCommerce package.
 *
 * @copyright Copyright (c) 2026 Magebit, Ltd. (https://magebit.com/)
 * @author    Magebit <info@magebit.com>
 * @license   MIT
 */

declare(strict_types=1);

namespace Magebit\UniversalCommerce\Model\Data\Spec\Schemas\Shopping\Types;

use Magebit\UcpSpec\MutableApi\Schemas\Shopping\Types\FulfillmentGroupResponseInterface;
use Magebit\UcpSpec\MutableApi\Schemas\Shopping\Types\FulfillmentOptionResponseInterface;
use Magebit\UcpSpec\MutableApi\Schemas\Shopping\Types\FulfillmentOptionResponseInterfaceFactory;
use Magebit\UniversalCommerce\Model\Data\DataTransferObject;

/**
 * Fulfillment Group Response Model
 */
class FulfillmentGroupResponse extends DataTransferObject implements FulfillmentGroupResponseInterface
{
    /**
     * @param FulfillmentOptionResponseInterfaceFactory $optionFactory
     * @param array<mixed> $data
     */
    public function __construct(
        private readonly FulfillmentOptionResponseInterfaceFactory $optionFactory,
        array $data = []
    ) {
        parent::__construct($data);
    }

    /**
     * @inheritDoc
     */
    public function getId(): string
    {
        return $this->getDataString(self::KEY_ID);
    }

    /**
     * @inheritDoc
     */
    public function setId(string $id): FulfillmentGroupResponseInterface
    {
        return $this->setData(self::KEY_ID, $id);
    }

    /**
     * @inheritDoc
     */
    public function getLineItemIds(): array
    {
        return $this->getData(self::KEY_LINE_ITEM_IDS) ?? [];
    }

    /**
     * @inheritDoc
     */
    public function setLineItemIds(array $lineItemIds): FulfillmentGroupResponseInterface
    {
        return $this->setData(self::KEY_LINE_ITEM_IDS, $lineItemIds);
    }

    /**
     * @inheritDoc
     */
    public function getOptions(): ?array
    {
        $options = $this->getData(self::KEY_OPTIONS);
        if ($options === null) {
            return null;
        }

        return $this->getDataInstanceArray(
            self::KEY_OPTIONS,
            FulfillmentOptionResponseInterface::class,
            $this->optionFactory->create(...)
        );
    }

    /**
     * @inheritDoc
     */
    public function setOptions(?array $options): FulfillmentGroupResponseInterface
    {
        return $this->setData(self::KEY_OPTIONS, $options);
    }

    /**
     * @inheritDoc
     */
    public function getSelectedOptionId(): ?string
    {
        return $this->getDataStringOrNull(self::KEY_SELECTED_OPTION_ID);
    }

    /**
     * @inheritDoc
     */
    public function setSelectedOptionId(?string $selectedOptionId): FulfillmentGroupResponseInterface
    {
        return $this->setData(self::KEY_SELECTED_OPTION_ID, $selectedOptionId);
    }
}
