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
use Magebit\UcpSpec\MutableApi\Schemas\UcpDiscoveryProfileInterface;

class Index implements HttpGetActionInterface
{
    /**
     * @param JsonFactory $jsonFactory
     * @param UcpDiscoveryProfileInterface $discoveryProfile
     */
    public function __construct(
        private readonly JsonFactory $jsonFactory,
        private readonly UcpDiscoveryProfileInterface $discoveryProfile,
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
        $result->setJsonData((string) json_encode($this->discoveryProfile));
        return $result;
    }
}
