<?php

namespace Core;

use Closure;
use Exception;
use ReflectionClass;

class ServiceContainer
{
    protected array $bindings = [];
    protected array $instances = [];

    public function bind(string $key, Closure|string $resolver = null, bool $shared = false): void
    {
        $this->bindings[$key] = [
            'resolver' => $resolver ?? $key,
            'shared' => $shared
        ];
    }

    public function singleton(string $key, Closure|string $resolver = null): void
    {
        $this->bind($key, $resolver, true);
    }


    public function resolve($key): mixed
    {
        if (array_key_exists($key, $this->instances)) {
            return $this->instances[$key];
        }

        if (!array_key_exists($key, $this->bindings)) {
            throw new Exception("No matching binding for $key");
        }

        $binding = $this->bindings[$key];
        if ($binding['resolver'] instanceof Closure) {
            $instance = $binding['resolver']($this);
        } else {
            $reflector = new ReflectionClass($binding['resolver']);
            $constructor = $reflector->getConstructor();
            if ($constructor === null) {
                $instance = new $binding['resolver'];
            } else {
                $parameters = $constructor->getParameters();
                $dependencies = [];
                foreach ($parameters as $parameter) {
                    $dependencies[] = $this->resolve($parameter->getType()->getName());
                }
                $instance = new $binding['resolver'](...$dependencies);
            }

        }

        if ($binding['shared']) {
            $this->instances[$key] = $instance;
        }

        return $instance;
    }

    private function lastBinding()
    {
        return $this->bindings[array_key_last($this->bindings)];
    }
}