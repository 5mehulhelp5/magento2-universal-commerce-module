<?php

/**
 * This file is part of the Magebit_UniversalCommerce package.
 *
 * @copyright Copyright (c) 2026 Magebit, Ltd. (https://magebit.com/)
 * @author    Magebit <info@magebit.com>
 * @license   MIT
 */

declare(strict_types=1);

namespace Magebit\UniversalCommerce\Controller\Discovery;

use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\Controller\Result\JsonFactory;
use Magento\Framework\Controller\ResultInterface;
use Magebit\UniversalCommerce\Api\Discovery\UcpDiscoveryProfileInterface;

class Index implements HttpGetActionInterface
{
    /**
     * @param JsonFactory $jsonFactory
     * @param UcpDiscoveryProfileInterface $ucpDiscoveryProfile
     */
    public function __construct(
        private readonly JsonFactory $jsonFactory,
        private readonly UcpDiscoveryProfileInterface $ucpDiscoveryProfile,
    ) {
    }

    /**
     * Execute action to return UCP discovery profile
     *
     * @return ResultInterface
     */
    public function execute(): ResultInterface
    {
        $result = $this->jsonFactory->create();
        return $result->setData($this->ucpDiscoveryProfile->jsonSerialize());
    }
}
