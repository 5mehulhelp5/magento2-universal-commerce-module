<?php

/**
 * This file is part of the Magebit_UniversalCommerce package.
 *
 * @copyright Copyright (c) 2026 Magebit, Ltd. (https://magebit.com/)
 * @author    Magebit <info@magebit.com>
 * @license   MIT
 */

declare(strict_types=1);

namespace Magebit\UniversalCommerce\Model\Data\Spec\Schemas\Shopping;

use Magebit\UcpSpec\MutableApi\Schemas\Shopping\CheckoutCreateRequestInterface;
use Magebit\UcpSpec\MutableApi\Schemas\Shopping\Types\BuyerInterface;
use Magebit\UcpSpec\MutableApi\Schemas\Shopping\Types\BuyerInterfaceFactory;
use Magebit\UcpSpec\MutableApi\Schemas\Shopping\Types\LineItemCreateRequestInterface;
use Magebit\UcpSpec\MutableApi\Schemas\Shopping\Types\LineItemCreateRequestInterfaceFactory;
use Magebit\UcpSpec\MutableApi\Schemas\Shopping\PaymentCreateRequestInterface;
use Magebit\UcpSpec\MutableApi\Schemas\Shopping\PaymentCreateRequestInterfaceFactory;
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
     * @param PaymentCreateRequestInterfaceFactory $paymentFactory
     * @param array<mixed> $data
     */
    public function __construct(
        private readonly BuyerInterfaceFactory $buyerFactory,
        private readonly LineItemCreateRequestInterfaceFactory $lineItemFactory,
        private readonly PaymentCreateRequestInterfaceFactory $paymentFactory,
        array $data = []
    ) {
        parent::__construct($data);
    }

    /**
     * @inheritDoc
     */
    public function getBuyer(): ?BuyerInterface
    {
        return $this->getDataInstance(self::KEY_BUYER, BuyerInterface::class, $this->buyerFactory->create(...));
    }

    /**
     * @inheritDoc
     */
    public function setBuyer(?BuyerInterface $buyer): CheckoutCreateRequestInterface
    {
        return $this->setData(self::KEY_BUYER, $buyer);
    }

    /**
     * @inheritDoc
     */
    public function getCurrency(): string
    {
        return $this->getDataString(self::KEY_CURRENCY);
    }

    /**
     * @inheritDoc
     */
    public function setCurrency(string $currency): CheckoutCreateRequestInterface
    {
        return $this->setData(self::KEY_CURRENCY, $currency);
    }

    /**
     * @inheritDoc
     */
    public function getLineItems(): array
    {
        return $this->getDataInstanceArray(
            self::KEY_LINE_ITEMS,
            LineItemCreateRequestInterface::class,
            $this->lineItemFactory->create(...)
        );
    }

    /**
     * @inheritDoc
     */
    public function setLineItems(array $lineItems): CheckoutCreateRequestInterface
    {
        return $this->setData(self::KEY_LINE_ITEMS, $lineItems);
    }

    /**
     * @inheritDoc
     */
    public function getPayment(): PaymentCreateRequestInterface
    {
        return $this->getDataInstance(self::KEY_PAYMENT, PaymentCreateRequestInterface::class, $this->paymentFactory->create(...));
    }

    /**
     * @inheritDoc
     */
    public function setPayment(PaymentCreateRequestInterface $payment): CheckoutCreateRequestInterface
    {
        return $this->setData(self::KEY_PAYMENT, $payment);
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
