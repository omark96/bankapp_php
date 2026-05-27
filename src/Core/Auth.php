<?php

namespace Core;

use Database\Interfaces\UserRepository;
use Models\User;

class Auth
{
    public static function login(User $user, string $pin): bool
    {
        if ($user->authenticate($pin)) {
            session_regenerate_id(true);
            Session::set('user', $user);
            return true;
        }
        return false;
    }

    public static function logout(): void
    {
        Session::destroy();
    }

    public static function user(): ?User
    {
        return Session::get('user');
    }

    public static function check(): bool
    {
        return static::user() != null;
    }

    public static function isAdmin(): bool
    {
        return static::user()?->role == 'admin' ?? false;
    }

    public static function isGuest(): bool
    {
        return !static::check();
    }
}