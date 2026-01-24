<?php

/**
 * @author Magebit <info@magebit.com>
 * @copyright Copyright (c) Magebit, Ltd. (https://magebit.com)
 * @license https://magebit.com/code-license
 */

declare(strict_types=1);

namespace Magebit\UniversalCommerce\Api;

use Magebit\UniversalCommerce\Api\Data\CheckoutMetaInterface;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;

/**
 * Repository Interface for Checkout Meta Model
 * Provides CRUD operations and retrieval methods for checkout meta records
 */
interface CheckoutMetaRepositoryInterface
{
    /**
     * Save checkout meta record
     *
     * @param CheckoutMetaInterface $checkoutMeta
     * @return CheckoutMetaInterface
     * @throws CouldNotSaveException
     */
    public function save(CheckoutMetaInterface $checkoutMeta): CheckoutMetaInterface;

    /**
     * Get checkout meta record by ID
     *
     * @param int $entityId
     * @return CheckoutMetaInterface
     * @throws NoSuchEntityException
     */
    public function getById(int $entityId): CheckoutMetaInterface;

    /**
     * Get checkout meta record by checkout ID
     *
     * @param string $checkoutId
     * @return CheckoutMetaInterface
     * @throws NoSuchEntityException
     */
    public function getByCheckoutId(string $checkoutId): CheckoutMetaInterface;

    /**
     * Delete checkout meta record
     *
     * @param CheckoutMetaInterface $checkoutMeta
     * @return bool
     * @throws CouldNotDeleteException
     */
    public function delete(CheckoutMetaInterface $checkoutMeta): bool;

    /**
     * Delete checkout meta record by ID
     *
     * @param int $entityId
     * @return bool
     * @throws CouldNotDeleteException
     * @throws NoSuchEntityException
     */
    public function deleteById(int $entityId): bool;
}
