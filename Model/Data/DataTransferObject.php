<?php

/**
 * This file is part of the Magebit_UniversalCommerce package.
 *
 * @copyright Copyright (c) 2026 Magebit, Ltd. (https://magebit.com/)
 * @author    Magebit <info@magebit.com>
 * @license   MIT
 */

declare(strict_types=1);

namespace Magebit\UniversalCommerce\Model\Data;

use InvalidArgumentException;
use Magento\Framework\DataObject;

/**
 * Base Data Transfer Object
 * Provides helper methods for working with nested data structures
 */
abstract class DataTransferObject extends DataObject
{
    /**
     * @param string[] $keys
     * @return array<mixed>
     */
    public function toArray(array $keys = []): array
    {
        $data = [];

        foreach (parent::toArray($keys) as $key => $value) {
            if ($value instanceof DataObject) {
                $data[$key] = $value->toArray();
            } elseif (is_array($value)) {
                $data[$key] = array_map(function ($item) {
                    if ($item instanceof DataObject) {
                        return $item->toArray();
                    }

                    return $item;
                }, $value);
            } else {
                $data[$key] = $value;
            }
        }

        return $data;
    }

    /**
     * Get data instance
     *
     * @template T
     * @param string $key
     * @param class-string<T> $interface
     * @param callable(array<mixed>): T $factory
     * @return T|null
     */
    protected function getDataInstance(string $key, string $interface, callable $factory): mixed
    {
        $data = $this->getData($key);

        if ($data instanceof $interface) {
            return $data;
        }

        if (is_array($data)) {
            return $factory(['data' => $data]);
        }

        return null;
    }

    /**
     * Get array of data instances
     *
     * @template T
     * @param string $key
     * @param class-string<T> $interface
     * @param callable(array<mixed>): T $factory
     * @return T[]
     */
    protected function getDataInstanceArray(string $key, string $interface, callable $factory): array
    {
        /** @var array<mixed> $items */
        $items = $this->getData($key) ?? [];

        return array_map(function ($item) use ($factory, $interface) {
            if ($item instanceof $interface) {
                return $item;
            }

            /** @var array<mixed> $item */
            return $factory(['data' => $item]);
        }, $items);
    }

    /**
     * Get string data
     *
     * @param string $key
     * @return string
     * @throws InvalidArgumentException
     */
    protected function getDataString(string $key): string
    {
        $data = $this->getData($key);

        if (!is_string($data)) {
            throw new InvalidArgumentException(sprintf('Data for key %s is not a string', $key));
        }

        return $data;
    }

    /**
     * Get nullable string data
     *
     * @param string $key
     * @return string|null
     */
    protected function getDataStringOrNull(string $key): ?string
    {
        $data = $this->getData($key);
        return is_string($data) ? $data : null;
    }

    /**
     * Get integer data
     *
     * @param string $key
     * @return int
     */
    protected function getDataInt(string $key): int
    {
        // @phpstan-ignore cast.int
        return (int) $this->getData($key);
    }

    /**
     * Get nullable integer data
     *
     * @param string $key
     * @return int|null
     */
    protected function getDataIntOrNull(string $key): ?int
    {
        $data = $this->getData($key);
        return is_numeric($data) ? (int) $data : null;
    }

    /**
     * Get raw data array for validation
     *
     * @return array<string, mixed>
     */
    public function getRawData(): array
    {
        return $this->_data;
    }
}
