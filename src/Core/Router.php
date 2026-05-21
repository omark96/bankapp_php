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
        $regex = preg_replace("#\{\w+}#", "([^\/]+)", $trimmedUri);
        $regex = "#^" . $regex . "$#i";
        $this->routes[] = [
            'regex' => $regex,
            'controller' => $controller,
            'method' => $method,
            'action' => $action,
            'middleware' => null
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

    public function route(string $uri, string $method)
    {
        foreach ($this->routes as $route) {
            $regex = $route['regex'];
            $trimmedUri = trim($uri, '/');
            if ($route['method'] === strtoupper($method) &&
                preg_match($regex, $trimmedUri, $matches)
            ) {
                array_shift($matches);

                $controller = App::resolve($route['controller']);
                $action = $route['action'];
                return $controller->$action(...$matches);
            }
        }
        abort(Response::NOT_FOUND);
    }
}