<?php

namespace Core;
class Session
{
    public static function set($key, $value): void
    {
        $_SESSION[$key] = $value;
    }

    public static function unset($key): void
    {
        unset($_SESSION[$key]);
    }

    public static function get($key, $default = null): mixed
    {
        if (isset($_SESSION['_flash'][$key])) {
            return $_SESSION['_flash'][$key];
        }

        return $_SESSION[$key] ?? $default;
    }

    public static function has($key): bool
    {
        return (isset($_SESSION[$key])
            || isset($_SESSION['_flash'][$key]));
    }

    public static function flash($key, $value): void
    {
        $_SESSION['_flash'][$key] = $value;
    }

    public static function unflash(): void
    {
        unset($_SESSION['_flash']);
    }

    public static function flush(): void
    {
        $_SESSION = [];
    }

    public static function destroy(): void
    {
        static::flush();
        session_destroy();

        $params = session_get_cookie_params();

        setcookie('PHPSESSID', '', time() - 3600, $params['path'], $params['domain'], $params['secure'], $params['httponly']);
    }
}