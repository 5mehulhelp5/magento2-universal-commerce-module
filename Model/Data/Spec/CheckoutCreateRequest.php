<?php

/**
 * This file is part of the Magebit_UniversalCommerce package.
 *
 * @copyright Copyright (c) 2026 Magebit, Ltd. (https://magebit.com/)
 * @author    Magebit <info@magebit.com>
 * @license   MIT
 */

declare(strict_types=1);

namespace Magebit\UniversalCommerce\Model\Data\Spec;

use Magebit\UniversalCommerce\Api\Data\Spec\CheckoutCreateRequestInterface;
use Magebit\UniversalCommerce\Api\Data\Spec\BuyerInterface;
use Magebit\UniversalCommerce\Api\Data\Spec\BuyerInterfaceFactory;
use Magebit\UniversalCommerce\Api\Data\Spec\LineItemCreateRequestInterface;
use Magebit\UniversalCommerce\Api\Data\Spec\LineItemCreateRequestInterfaceFactory;
use Magebit\UniversalCommerce\Api\Data\Spec\PaymentClassInterface;
use Magebit\UniversalCommerce\Api\Data\Spec\PaymentClassInterfaceFactory;
use Magebit\UniversalCommerce\Api\Data\ValidatableDataInterface;
use Magebit\UniversalCommerce\Model\Data\DataTransferObject;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Checkout Create Request Model
 */
class CheckoutCreateRequest extends DataTransferObject implements
    CheckoutCreateRequestInterface,
    ValidatableDataInterface
{
    /**
     * @param BuyerInterfaceFactory $buyerFactory
     * @param LineItemCreateRequestInterfaceFactory $lineItemFactory
     * @param PaymentClassInterfaceFactory $paymentFactory
     * @param array<mixed> $data
     */
    public function __construct(
        private readonly BuyerInterfaceFactory $buyerFactory,
        private readonly LineItemCreateRequestInterfaceFactory $lineItemFactory,
        private readonly PaymentClassInterfaceFactory $paymentFactory,
        array $data = []
    ) {
        parent::__construct($data);
    }

    /**
     * @inheritDoc
     */
    public function getBuyer(): ?BuyerInterface
    {
        return $this->getDataInstance(self::BUYER, BuyerInterface::class, $this->buyerFactory->create(...));
    }

    /**
     * @inheritDoc
     */
    public function setBuyer(?BuyerInterface $buyer): CheckoutCreateRequestInterface
    {
        return $this->setData(self::BUYER, $buyer);
    }

    /**
     * @inheritDoc
     */
    public function getCurrency(): string
    {
        return $this->getDataString(self::CURRENCY);
    }

    /**
     * @inheritDoc
     */
    public function setCurrency(string $currency): CheckoutCreateRequestInterface
    {
        return $this->setData(self::CURRENCY, $currency);
    }

    /**
     * @inheritDoc
     */
    public function getLineItems(): array
    {
        return $this->getDataInstanceArray(
            self::LINE_ITEMS,
            LineItemCreateRequestInterface::class,
            $this->lineItemFactory->create(...)
        );
    }

    /**
     * @inheritDoc
     */
    public function setLineItems(array $lineItems): CheckoutCreateRequestInterface
    {
        return $this->setData(self::LINE_ITEMS, $lineItems);
    }

    /**
     * @inheritDoc
     */
    public function getPayment(): PaymentClassInterface
    {
        return $this->getDataInstance(self::PAYMENT, PaymentClassInterface::class, $this->paymentFactory->create(...));
    }

    /**
     * @inheritDoc
     */
    public function setPayment(PaymentClassInterface $payment): CheckoutCreateRequestInterface
    {
        return $this->setData(self::PAYMENT, $payment);
    }

    /**
     * Load validator metadata for Symfony Validator
     *
     * @param ClassMetadata $metadata
     * @return void
     */
    public static function loadValidatorMetadata(ClassMetadata $metadata): void
    {
        // Validate the raw data array
        $metadata->addPropertyConstraint('_data', new Assert\Type('array'));

        $metadata->addPropertyConstraint('_data', new Assert\Collection(
            fields: [
                'buyer' => new Assert\Optional([
                    new Assert\Type('array'),
                ]),
                'currency' => new Assert\Required([
                    new Assert\Type('string'),
                    new Assert\NotBlank(['message' => 'Currency is required']),
                    new Assert\Length(['min' => 3, 'max' => 3, 'exactMessage' => 'Currency must be a 3-letter code']),
                ]),
                'line_items' => new Assert\Required([
                    new Assert\Type('array'),
                    new Assert\Count([
                        'min' => 1,
                        'minMessage' => 'At least one line item is required'
                    ]),
                    new Assert\All([
                        new Assert\Collection(
                            fields: [
                                'item' => new Assert\Required([
                                    new Assert\Type('array'),
                                    new Assert\Collection(
                                        fields: [
                                            'id' => new Assert\Required([
                                                new Assert\Type('string'),
                                                new Assert\NotBlank(['message' => 'Item ID is required']),
                                            ]),
                                        ],
                                        allowExtraFields: true
                                    ),
                                ]),
                                'quantity' => new Assert\Required([
                                    new Assert\Type('integer'),
                                    new Assert\GreaterThan(['value' => 0, 'message' => 'Quantity must be greater than 0']),
                                ]),
                            ],
                            allowExtraFields: true
                        ),
                    ]),
                ]),
                'payment' => new Assert\Required([
                    new Assert\Type('array'),
                    new Assert\Collection(
                        fields: [
                            'instruments' => new Assert\Optional([
                                new Assert\Type('array'),
                            ]),
                            'selected_instrument_id' => new Assert\Optional([
                                new Assert\Type('string'),
                            ]),
                        ],
                        allowExtraFields: true
                    ),
                ]),
            ],
            allowExtraFields: true
        ));
    }
}
