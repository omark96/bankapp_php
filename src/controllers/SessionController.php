<?php

namespace controllers;

use Core\Database;
use Database\Interfaces\UserRepository;

class SessionController
{
    public function __construct(private UserRepository $userRepository)
    {
    }

    public function create()
    {
        view('session/create');
    }

    public function store()
    {
        $cardNumber = $_POST['cardNumber'];
        $user = $this->userRepository->getByCardNumber($cardNumber);
        dd($user);
    }
}