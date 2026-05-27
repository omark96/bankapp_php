<?php

namespace Core;

class App
{
    protected static ServiceContainer $services;

    public static function setServices(ServiceContainer $services)
    {
        static::$services = $services;
    }

    public static function services(): ServiceContainer
    {
        return static::$services;
    }

    public static function resolve(string $key): mixed
    {
        return static::services()->resolve($key);
    }

    public static function bind(string $key, $resolver): void
    {
        static::services()->bind($key, $resolver);
    }
}