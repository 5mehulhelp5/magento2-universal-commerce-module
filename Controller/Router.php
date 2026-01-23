<?php

/**
 * @author Magebit <info@magebit.com>
 * @copyright Copyright (c) Magebit, Ltd. (https://magebit.com)
 * @license https://magebit.com/code-license
 */

declare(strict_types=1);

namespace Magebit\UniversalCommerce\Controller;

use Magento\Framework\App\Action\Forward;
use Magento\Framework\App\ActionFactory;
use Magento\Framework\App\ActionInterface;
use Magento\Framework\App\Request\Http;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\App\RouterInterface;

/**
 * Extensible Router for UCP Endpoints
 * Routes are configured via di.xml for flexibility
 */
class Router implements RouterInterface
{
    /**
     * @param ActionFactory $actionFactory
     * @param array<string, array{path: string, method: string, controller: string, action: string}> $routes
     */
    public function __construct(
        private readonly ActionFactory $actionFactory,
        private readonly array $routes = []
    ) {
    }

    /**
     * Match request to configured routes
     *
     * @param RequestInterface $request
     * @return ActionInterface|null
     */
    public function match(RequestInterface $request): ?ActionInterface
    {
        /** @var Http $request */
        if ($this->alreadyProcessed($request)) {
            return null;
        }

        $path = trim($request->getPathInfo(), '/');
        $method = $request->getMethod();

        // Iterate through configured routes
        foreach ($this->routes as $route) {
            // Validate route configuration
            if (!$this->isValidRoute($route)) {
                continue;
            }

            // Check if HTTP method matches
            if (!$this->matchMethod($route['method'], $method)) {
                continue;
            }

            // Check if path matches and extract parameters
            $params = $this->matchPath($route['path'], $path);
            if ($params === false) {
                continue;
            }

            // Route matched - set request attributes
            $request->setModuleName('ucp');
            $request->setControllerName($route['controller']);
            $request->setActionName($route['action']);

            // Set extracted parameters
            foreach ($params as $key => $value) {
                $request->setParam($key, $value);
            }

            // @phpstan-ignore arguments.count
            return $this->actionFactory->create(Forward::class, ['request' => $request]);
        }

        return null;
    }

    /**
     * Match path pattern against request path and extract parameters
     *
     * @param string $pattern
     * @param string $path
     * @return array<string, string>|false
     */
    private function matchPath(string $pattern, string $path): array|false
    {
        // Convert pattern to regex with named groups
        $regex = $this->patternToRegex($pattern);

        if (!preg_match($regex, $path, $matches)) {
            return false;
        }

        // Extract named parameters
        $params = [];
        foreach ($matches as $key => $value) {
            if (is_string($key)) {
                $params[$key] = $value;
            }
        }

        return $params;
    }

    /**
     * Convert path pattern to regex
     *
     * @param string $pattern
     * @return string
     */
    private function patternToRegex(string $pattern): string
    {
        // Escape special regex characters except {}
        $regex = preg_quote($pattern, '#');

        // Convert {param} to named capture groups
        // \\\{ and \\\} are the escaped { } after preg_quote
        $regex = preg_replace('/\\\{([a-zA-Z_][a-zA-Z0-9_]*)\\\}/', '(?P<$1>[^/]+)', $regex);

        return '#^' . $regex . '$#';
    }

    /**
     * Check if HTTP method matches
     *
     * @param string $routeMethod
     * @param string $requestMethod
     * @return bool
     */
    private function matchMethod(string $routeMethod, string $requestMethod): bool
    {
        // Wildcard matches any method
        if ($routeMethod === '*') {
            return true;
        }

        // Exact match (case-insensitive)
        return strcasecmp($routeMethod, $requestMethod) === 0;
    }

    /**
     * Validate route configuration
     *
     * @param mixed $route
     * @return bool
     */
    private function isValidRoute(mixed $route): bool
    {
        if (!is_array($route)) {
            return false;
        }

        $requiredKeys = ['path', 'method', 'controller', 'action'];
        foreach ($requiredKeys as $key) {
            if (!isset($route[$key]) || !is_string($route[$key])) {
                return false;
            }
        }

        return true;
    }

    /**
     * Check if request was already processed
     *
     * @param RequestInterface $request
     * @return bool
     */
    private function alreadyProcessed(RequestInterface $request): bool
    {
        /** @var Http $request */
        return $request->getModuleName() === 'ucp';
    }
}
