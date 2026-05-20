<?php

namespace Core;

class ServiceContainer
{
    protected $bindings = [];

    public function bind(string $key, $resolver)
    {
        $this->bindings[$key] = $resolver;
    }

    public function resolve(string $key)
    {
        if (!array_key_exists($key, $this->bindings)){
            throw new \Exception(("No matching binding for {$key}"));
        }
        $resolver = $this->bindings[$key];

        return call_user_func($resolver);
    }

    public function __get($key)
    {
        if (!array_key_exists($key, $this->bindings)){
            throw new \Exception(("No matching binding for {$key}"));
        }
        $resolver = $this->bindings[$key];

        return call_user_func($resolver);
    }
}