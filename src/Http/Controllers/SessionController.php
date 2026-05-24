<?php

namespace Http\Controllers;

use Core\Auth;
use Core\Session;
use Database\Interfaces\UserRepository;
use Http\Forms\LoginForm;

class SessionController
{
    public function __construct(private UserRepository $userRepository)
    {
    }

    public function create()
    {
        view('session/create',
            [
                'errors' => Session::get('errors')
            ],
            'auth');
    }

    public function store()
    {
        $cardNumber = $_POST['cardNumber'];
        $pinCode = $_POST['pinCode'];

        $loginForm = new LoginForm(compact('cardNumber', 'pinCode'));
        $loginForm->validate();

        $user = $this->userRepository->getByCardNumber($cardNumber);
        $successfulLogin = Auth::login($user, $pinCode);
        if (!$successfulLogin) {
            $loginForm
                ->error('cardNumber', 'Kunde inte hitta någon användare med de här inloggningsuppgifterna')
                ->throw();
        }
        redirect('/');
    }

    public function destroy()
    {
        Auth::logout();
        redirect('/');
    }
}