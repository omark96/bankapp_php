<?php

namespace Http\Controllers;

use Database\Interfaces\AccountRepository;
use Database\Interfaces\UserRepository;

class UserController
{
    public function __construct(
        private UserRepository    $userRepository,
        private AccountRepository $accountRepository
    )
    {
    }
    
}