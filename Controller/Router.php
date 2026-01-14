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
     * Match request to UCP endpoints
     *
     * @param RequestInterface $request
     * @return ActionInterface|null
     */
    public function match(RequestInterface $request): ?ActionInterface
    {
        /** @var Http $request */
        $identifier = trim($request->getPathInfo(), '/');

        // Handle .well-known/ucp discovery endpoint
        if ($identifier === '.well-known/ucp' && !$this->alreadyProcessed($request)) {
            $request->setModuleName('ucp');
            $request->setControllerName('discovery');
            $request->setActionName('index');

            // @phpstan-ignore arguments.count
            return $this->actionFactory->create(Forward::class, ['request' => $request]);
        }

        // Handle /ucp/* endpoints dynamically
        if (str_starts_with($identifier, 'ucp/') && !$this->alreadyProcessed($request)) {
            $parts = explode('/', $identifier);
            array_shift($parts); // Remove 'ucp'

            if (empty($parts)) {
                return null;
            }

            // Convert hyphenated endpoint to controller path
            // e.g., 'checkout-sessions' -> 'checkout/sessions'
            $endpoint = array_shift($parts);
            $controllerPath = $this->convertHyphenatedToPath($endpoint);

            // Determine action and parameters
            $action = 'index';
            $params = [];

            if (!empty($parts)) {
                // First part after endpoint could be ID or action
                $firstPart = $parts[0];

                if (count($parts) === 1) {
                    // /ucp/checkout-sessions/abc123 -> ID
                    $params['id'] = $firstPart;
                } elseif (count($parts) >= 2) {
                    // /ucp/checkout-sessions/abc123/complete -> ID + action
                    $params['id'] = $firstPart;
                    $action = $parts[1];
                }
            }

            $request->setModuleName('ucp');
            $request->setControllerName($controllerPath);
            $request->setActionName($action);

            foreach ($params as $key => $value) {
                $request->setParam($key, $value);
            }

            // @phpstan-ignore arguments.count
            return $this->actionFactory->create(Forward::class, ['request' => $request]);
        }

        return null;
    }

    /**
     * Convert hyphenated endpoint to controller path
     * e.g., 'checkout-sessions' -> 'checkout_sessions'
     *
     * @param string $endpoint
     * @return string
     */
    protected function convertHyphenatedToPath(string $endpoint): string
    {
        return str_replace('-', '_', $endpoint);
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
        return $request->getModuleName() === 'ucp';
    }
}
