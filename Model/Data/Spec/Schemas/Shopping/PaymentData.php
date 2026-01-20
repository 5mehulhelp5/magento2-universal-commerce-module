<?php

/**
 * @author Magebit <info@magebit.com>
 * @copyright Copyright (c) Magebit, Ltd. (https://magebit.com)
 * @license https://magebit.com/code-license
 */

declare(strict_types=1);

namespace Magebit\UniversalCommerce\Model\Data\Spec\Schemas\Shopping;

use Magebit\UcpSpec\MutableApi\Schemas\Shopping\PaymentDataInterface;
use Magebit\UcpSpec\MutableApi\Schemas\Shopping\Types\PaymentInstrumentInterface;
use Magebit\UcpSpec\MutableApi\Schemas\Shopping\Types\PaymentInstrumentInterfaceFactory;
use Magebit\UniversalCommerce\Api\Data\ValidatableDataInterface;
use Magebit\UniversalCommerce\Model\Data\DataTransferObject;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Payment Data Model
 */
class PaymentData extends DataTransferObject implements
    PaymentDataInterface,
    ValidatableDataInterface
{
    /**
     * @param PaymentInstrumentInterfaceFactory $paymentInstrumentFactory
     * @param array<mixed> $data
     */
    public function __construct(
        private readonly PaymentInstrumentInterfaceFactory $paymentInstrumentFactory,
        array $data = []
    ) {
        parent::__construct($data);
    }

    /**
     * @inheritDoc
     * @return PaymentInstrumentInterface
     */
    public function getPaymentData(): PaymentInstrumentInterface
    {
        /** @var PaymentInstrumentInterface|null $result */
        $result = $this->getDataInstance(
            self::KEY_PAYMENT_DATA,
            PaymentInstrumentInterface::class,
            $this->paymentInstrumentFactory->create(...)
        );

        if (!$result instanceof PaymentInstrumentInterface) {
            throw new \RuntimeException('Payment data must be an instance of PaymentInstrumentInterface');
        }

        return $result;
    }

    /**
     * @inheritDoc
     */
    public function setPaymentData(PaymentInstrumentInterface $paymentData): PaymentDataInterface
    {
        return $this->setData(self::KEY_PAYMENT_DATA, $paymentData);
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
                'payment_data' => new Assert\Required([
                    new Assert\Type('array'),
                    new Assert\NotBlank(['message' => 'Payment data is required']),
                ]),
            ],
            allowExtraFields: true
        ));
    }
}
