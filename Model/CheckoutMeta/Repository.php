<?php

/**
 * @author Magebit <info@magebit.com>
 * @copyright Copyright (c) Magebit, Ltd. (https://magebit.com)
 * @license https://magebit.com/code-license
 */

declare(strict_types=1);

namespace Magebit\UniversalCommerce\Model\CheckoutMeta;

use Magebit\UniversalCommerce\Api\Data\CheckoutMetaInterface;
use Magebit\UniversalCommerce\Api\CheckoutMetaRepositoryInterface;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use Psr\Log\LoggerInterface;

/**
 * Repository for Checkout Meta Model
 * Handles CRUD operations for checkout meta records
 */
class Repository implements CheckoutMetaRepositoryInterface
{
    /**
     * @param ResourceModel $resourceModel
     * @param ModelFactory $checkoutMetaFactory
     * @param LoggerInterface $logger
     */
    public function __construct(
        private readonly ResourceModel $resourceModel,
        private readonly ModelFactory $checkoutMetaFactory,
        private readonly LoggerInterface $logger
    ) {
    }

    /**
     * @inheritDoc
     */
    public function save(CheckoutMetaInterface $checkoutMeta): CheckoutMetaInterface
    {
        try {
            /** @var Model $checkoutMeta */
            $this->resourceModel->save($checkoutMeta);
        } catch (\Exception $exception) {
            $this->logger->error($exception->getMessage());
            throw new CouldNotSaveException(
                __('Could not save the checkout meta record: %1', $exception->getMessage()),
                $exception
            );
        }

        return $checkoutMeta;
    }

    /**
     * @inheritDoc
     */
    public function getById(int $entityId): CheckoutMetaInterface
    {
        $checkoutMeta = $this->checkoutMetaFactory->create();
        $this->resourceModel->load($checkoutMeta, $entityId);

        if (!$checkoutMeta->getEntityId()) {
            throw new NoSuchEntityException(
                __('Checkout meta record with ID "%1" does not exist.', $entityId)
            );
        }

        return $checkoutMeta;
    }

    /**
     * @inheritDoc
     */
    public function getByCheckoutId(string $checkoutId): CheckoutMetaInterface
    {
        $checkoutMeta = $this->checkoutMetaFactory->create();
        $this->resourceModel->load($checkoutMeta, $checkoutId, CheckoutMetaInterface::CHECKOUT_ID);

        if (!$checkoutMeta->getEntityId()) {
            throw new NoSuchEntityException(
                __('Checkout meta record with checkout ID "%1" does not exist.', $checkoutId)
            );
        }

        return $checkoutMeta;
    }

    /**
     * @inheritDoc
     */
    public function delete(CheckoutMetaInterface $checkoutMeta): bool
    {
        try {
            /** @var Model $checkoutMeta */
            $this->resourceModel->delete($checkoutMeta);
        } catch (\Exception $exception) {
            $this->logger->error($exception->getMessage());
            throw new CouldNotDeleteException(
                __('Could not delete the checkout meta record: %1', $exception->getMessage()),
                $exception
            );
        }

        return true;
    }

    /**
     * @inheritDoc
     */
    public function deleteById(int $entityId): bool
    {
        return $this->delete($this->getById($entityId));
    }
}
