<?php

/**
 * This file is part of the Magebit_UniversalCommerce package.
 *
 * @copyright Copyright (c) 2026 Magebit, Ltd. (https://magebit.com/)
 * @author    Magebit <info@magebit.com>
 * @license   MIT
 */

declare(strict_types=1);

namespace Magebit\UniversalCommerce\Controller;

use Magento\Framework\App\Action\Forward;
use Magento\Framework\App\ActionFactory;
use Magento\Framework\App\ActionInterface;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\App\RouterInterface;
use Magento\Framework\App\Request\Http;

class Router implements RouterInterface
{
    /**
     * @param ActionFactory $actionFactory
     */
    public function __construct(
        private readonly ActionFactory $actionFactory,
    ) {
    }

    /**
     * Match request to UCP discovery endpoint
     *
     * @param RequestInterface $request
     * @return ActionInterface|null
     */
    public function match(RequestInterface $request): ?ActionInterface
    {
        /** @var Http $request */
        $identifier = trim($request->getPathInfo(), '/');

        if ($identifier === '.well-known/ucp' && !$this->alreadyProcessed($request)) {
            $request->setModuleName('universal_commerce');
            $request->setControllerName('discovery');
            $request->setActionName('index');

            // @phpstan-ignore arguments.count
            return $this->actionFactory->create(Forward::class, ['request' => $request]);
        }

        return null;
    }

    /**
     * Check if request was already processed
     *
     * @param RequestInterface $request
     * @return bool
     */
    protected function alreadyProcessed(RequestInterface $request): bool
    {
        /** @var Http $request */
        return $request->getModuleName() === 'universal_commerce';
    }
}
