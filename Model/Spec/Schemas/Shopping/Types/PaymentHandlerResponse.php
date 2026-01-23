<?php

/**
 * This file is part of the Magebit_UniversalCommerce package.
 *
 * @copyright Copyright (c) 2026 Magebit, Ltd. (https://magebit.com/)
 * @author    Magebit <info@magebit.com>
 * @license   MIT
 */

declare(strict_types=1);

namespace Magebit\UniversalCommerce\Model\Spec\Schemas\Shopping\Types;

use Magebit\UniversalCommerce\Model\DataTransferObject;
use Magebit\UcpSpec\Api\Schemas\Shopping\Types\PaymentHandlerResponseInterface;

class PaymentHandlerResponse extends DataTransferObject implements PaymentHandlerResponseInterface
{
    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->getDataString(PaymentHandlerResponseInterface::KEY_ID);
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->getDataString(PaymentHandlerResponseInterface::KEY_NAME);
    }

    /**
     * @return string
     */
    public function getVersion(): string
    {
        return $this->getDataString(PaymentHandlerResponseInterface::KEY_VERSION);
    }

    /**
     * @return string
     */
    public function getSpec(): string
    {
        return $this->getDataString(PaymentHandlerResponseInterface::KEY_SPEC);
    }

    /**
     * @return string
     */
    public function getConfigSchema(): string
    {
        return $this->getDataString(PaymentHandlerResponseInterface::KEY_CONFIG_SCHEMA);
    }

    /**
     * @return array<string>
     */
    public function getInstrumentSchemas(): array
    {
        $value = $this->getDataArray(PaymentHandlerResponseInterface::KEY_INSTRUMENT_SCHEMAS);
        foreach ($value as $item) {
            if (!is_string($item)) {
                throw new \InvalidArgumentException(
                    sprintf('Item in %s is not a string', PaymentHandlerResponseInterface::KEY_INSTRUMENT_SCHEMAS)
                );
            }
        }
        return $value;
    }

    /**
     * @return array<mixed>
     */
    public function getConfig(): array
    {
        return $this->getDataArray(PaymentHandlerResponseInterface::KEY_CONFIG);
    }
}
