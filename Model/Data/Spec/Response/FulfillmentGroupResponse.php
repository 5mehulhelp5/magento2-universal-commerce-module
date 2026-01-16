<?php

/**
 * This file is part of the Magebit_UniversalCommerce package.
 *
 * @copyright Copyright (c) 2026 Magebit, Ltd. (https://magebit.com/)
 * @author    Magebit <info@magebit.com>
 * @license   MIT
 */

declare(strict_types=1);

namespace Magebit\UniversalCommerce\Model\Data\Spec\Response;

use Magebit\UniversalCommerce\Api\Data\Spec\Response\FulfillmentGroupResponseInterface;
use Magebit\UniversalCommerce\Api\Data\Spec\Response\FulfillmentOptionResponseInterface;
use Magebit\UniversalCommerce\Api\Data\Spec\Response\FulfillmentOptionResponseInterfaceFactory;
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
        return $this->getDataString(self::ID);
    }

    /**
     * @inheritDoc
     */
    public function setId(string $id): FulfillmentGroupResponseInterface
    {
        return $this->setData(self::ID, $id);
    }

    /**
     * @inheritDoc
     */
    public function getLineItemIds(): array
    {
        return $this->getData(self::LINE_ITEM_IDS) ?? [];
    }

    /**
     * @inheritDoc
     */
    public function setLineItemIds(array $lineItemIds): FulfillmentGroupResponseInterface
    {
        return $this->setData(self::LINE_ITEM_IDS, $lineItemIds);
    }

    /**
     * @inheritDoc
     */
    public function getOptions(): ?array
    {
        $options = $this->getData(self::OPTIONS);
        if ($options === null) {
            return null;
        }

        return $this->getDataInstanceArray(
            self::OPTIONS,
            FulfillmentOptionResponseInterface::class,
            $this->optionFactory->create(...)
        );
    }

    /**
     * @inheritDoc
     */
    public function setOptions(?array $options): FulfillmentGroupResponseInterface
    {
        return $this->setData(self::OPTIONS, $options);
    }

    /**
     * @inheritDoc
     */
    public function getSelectedOptionId(): ?string
    {
        return $this->getDataStringOrNull(self::SELECTED_OPTION_ID);
    }

    /**
     * @inheritDoc
     */
    public function setSelectedOptionId(?string $selectedOptionId): FulfillmentGroupResponseInterface
    {
        return $this->setData(self::SELECTED_OPTION_ID, $selectedOptionId);
    }
}
