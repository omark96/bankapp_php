<?php

namespace Http\Controllers;

use Core\Auth;
use Database\Interfaces\AccountRepository;

readonly class AccountController
{
    public function __construct(
        private AccountRepository $accountRepository
    )
    {
    }

    public function index()
    {
        $accounts = $this->accountRepository->getAllByUserId(Auth::user()->id);
        view('/accounts/index', [
            'accounts' => $accounts,
        ]);
    }

    public function show(int $accountId)
    {
        $account = $this->accountRepository->getById($accountId);
        authorize($accountId == Auth::user()->id);
        dd($account);
    }
}