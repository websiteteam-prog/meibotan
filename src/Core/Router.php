<?php
declare(strict_types=1);

namespace App\Core;

/**
 * Minimal router with named parameters ({slug}, {id:\d+}) and middleware.
 *
 * Middleware names: auth (customer), guest, admin, admin:<permission>.
 * All POST routes are CSRF-protected automatically unless 'nocsrf' is given.
 */
final class Router
{
    /** @var array<int, array{method:string, pattern:string, regex:string, handler:array, middleware:array}> */
    private array $routes = [];

    public function get(string $path, array $handler, array $middleware = []): self
    {
        return $this->add('GET', $path, $handler, $middleware);
    }

    public function post(string $path, array $handler, array $middleware = []): self
    {
        return $this->add('POST', $path, $handler, $middleware);
    }

    public function add(string $method, string $path, array $handler, array $middleware = []): self
    {
        $regex = preg_replace_callback('~\{(\w+)(?::([^}]+))?\}~', static function ($m) {
            $pattern = $m[2] ?? '[^/]+';
            return '(?P<' . $m[1] . '>' . $pattern . ')';
        }, $path);
        $this->routes[] = [
            'method' => $method,
            'pattern' => $path,
            'regex' => '~^' . $regex . '$~',
            'handler' => $handler,
            'middleware' => $middleware,
        ];
        return $this;
    }

    public function dispatch(string $method, string $path): void
    {
        if ($method === 'HEAD') {
            $method = 'GET';
        }
        $allowed = false;
        foreach ($this->routes as $route) {
            if (!preg_match($route['regex'], $path, $m)) {
                continue;
            }
            if ($route['method'] !== $method) {
                $allowed = true;
                continue;
            }
            $params = array_filter($m, 'is_string', ARRAY_FILTER_USE_KEY);
            $this->runMiddleware($route['middleware'], $method);
            [$class, $action] = $route['handler'];
            $controller = new $class();
            $controller->{$action}(...array_values($params));
            return;
        }
        if ($allowed) {
            abort(405, 'Method not allowed.');
        }
        abort(404);
    }

    private function runMiddleware(array $middleware, string $method): void
    {
        if ($method === 'POST' && !in_array('nocsrf', $middleware, true)) {
            Csrf::enforce();
        }
        foreach ($middleware as $mw) {
            if ($mw === 'auth') {
                Auth::requireCustomer();
            } elseif ($mw === 'guest') {
                if (Auth::check()) {
                    redirect('/account');
                }
            } elseif ($mw === 'admin') {
                AdminAuth::require();
            } elseif (str_starts_with($mw, 'admin:')) {
                AdminAuth::require(substr($mw, 6));
            }
        }
    }
}
