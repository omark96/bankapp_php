<?php

namespace Core;

use ReflectionClass;
use ReflectionNamedType;

class Router
{
    protected $routes = [];

    public function add(string $method, string $uri, string $controller, string $action)
    {
        $trimmedUri = trim($uri, '/');
        $this->routes[] = [
            'uri' => $trimmedUri,
            'controller' => $controller,
            'method' => $method,
            'action' => $action,
            'allowed' => []
        ];

        return $this;
    }

    public function get(string $uri, string $controller, string $action)
    {
        return $this->add('GET', $uri, $controller, $action);
    }

    public function post(string $uri, string $controller, string $action)
    {
        return $this->add('POST', $uri, $controller, $action);
    }

    public function delete(string $uri, string $controller, string $action)
    {
        return $this->add('DELETE', $uri, $controller, $action);
    }

    public function patch(string $uri, string $controller, string $action)
    {
        return $this->add('PATCH', $uri, $controller, $action);
    }

    public function put(string $uri, string $controller, string $action)
    {
        return $this->add('PUT', $uri, $controller, $action);
    }

    public function allowed(array $allowed)
    {
        $latest = array_key_last($this->routes);
        $this->routes[$latest]['allowed'] = $allowed;
        return $this;
    }

    public function route(string $uri, string $method)
    {
        foreach ($this->routes as $route) {
            $regex = preg_replace("#\{\w+}#", "([^\/]+)", $route['uri']);
            $regex = "#^" . $regex . "$#i";
            $trimmedUri = trim($uri, '/');
            if ($route['method'] === strtoupper($method) &&
                preg_match($regex, $trimmedUri, $matches)
            ) {
                $role = Auth::user()?->role ?? 'guest';
                if (!empty($route['allowed'])) {
                    authorize(in_array($role, $route['allowed']));
                }
                array_shift($matches);
                $controller = App::resolve($route['controller']);
                $action = $route['action'];
                return $controller->$action(...$matches);
            }
        }
        abort(Response::NOT_FOUND);
    }

    public function previousUrl()
    {
        return $_SERVER['HTTP_REFERER'];
    }
}