<?php

/**
 * @author Magebit <info@magebit.com>
 * @copyright Copyright (c) Magebit, Ltd. (https://magebit.com)
 * @license https://magebit.com/code-license
 */

declare(strict_types=1);

namespace Magebit\UniversalCommerce\Model\Data\Spec\Schemas\Shopping;

use Magebit\UcpSpec\MutableApi\Schemas\Shopping\CheckoutUpdateRequestInterface;
use Magebit\UcpSpec\MutableApi\Schemas\Shopping\PaymentUpdateRequestInterface;
use Magebit\UcpSpec\MutableApi\Schemas\Shopping\PaymentUpdateRequestInterfaceFactory;
use Magebit\UcpSpec\MutableApi\Schemas\Shopping\Types\BuyerInterface;
use Magebit\UcpSpec\MutableApi\Schemas\Shopping\Types\BuyerInterfaceFactory;
use Magebit\UcpSpec\MutableApi\Schemas\Shopping\Types\LineItemUpdateRequestInterface;
use Magebit\UcpSpec\MutableApi\Schemas\Shopping\Types\LineItemUpdateRequestInterfaceFactory;
use Magebit\UniversalCommerce\Api\Data\ValidatableDataInterface;
use Magebit\UniversalCommerce\Model\Data\DataTransferObject;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Checkout Update Request Model
 */
class CheckoutUpdateRequest extends DataTransferObject implements
    CheckoutUpdateRequestInterface,
    ValidatableDataInterface
{
    /**
     * @param BuyerInterfaceFactory $buyerFactory
     * @param LineItemUpdateRequestInterfaceFactory $lineItemFactory
     * @param PaymentUpdateRequestInterfaceFactory $paymentFactory
     * @param array<mixed> $data
     */
    public function __construct(
        private readonly BuyerInterfaceFactory $buyerFactory,
        private readonly LineItemUpdateRequestInterfaceFactory $lineItemFactory,
        private readonly PaymentUpdateRequestInterfaceFactory $paymentFactory,
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
    public function setId(string $id): CheckoutUpdateRequestInterface
    {
        return $this->setData(self::KEY_ID, $id);
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
    public function setBuyer(?BuyerInterface $buyer): CheckoutUpdateRequestInterface
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
    public function setCurrency(string $currency): CheckoutUpdateRequestInterface
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
            LineItemUpdateRequestInterface::class,
            $this->lineItemFactory->create(...)
        );
    }

    /**
     * @inheritDoc
     */
    public function setLineItems(array $lineItems): CheckoutUpdateRequestInterface
    {
        return $this->setData(self::KEY_LINE_ITEMS, $lineItems);
    }

    /**
     * @inheritDoc
     */
    public function getPayment(): PaymentUpdateRequestInterface
    {
        return $this->getDataInstance(
            self::KEY_PAYMENT,
            PaymentUpdateRequestInterface::class,
            $this->paymentFactory->create(...)
        );
    }

    /**
     * @inheritDoc
     */
    public function setPayment(PaymentUpdateRequestInterface $payment): CheckoutUpdateRequestInterface
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
                'id' => new Assert\Required([
                    new Assert\Type('string'),
                    new Assert\NotBlank(['message' => 'Session ID is required']),
                ]),
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
                                'id' => new Assert\Optional([
                                    new Assert\Type('string'),
                                ]),
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
                                    new Assert\GreaterThan([
                                        'value' => 0,
                                        'message' => 'Quantity must be greater than 0'
                                    ]),
                                ]),
                                'parent_id' => new Assert\Optional([
                                    new Assert\Type('string'),
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
