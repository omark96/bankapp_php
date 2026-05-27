<?php

namespace Http\Controllers\Admin;

use Database\Interfaces\AccountRepository;
use Models\Account;

readonly class AccountController
{
    public function __construct(
        private AccountRepository $accountRepository
    )
    {
    }

    public function index(): void
    {
        view('admin/accounts/index', [], null);
    }

    public function table(): void
    {
        $page = $_GET['page'] ?? 1;
        $accounts = $this->accountRepository->getAllPaginated($page, 3);

        $columns = [
            [
                'key' => 'id',
                'label' => 'Id',
                'formatter' => function (Account $account) {
                    return $account->id;
                }
            ],
            [
                'key' => 'userId',
                'label' => 'Användar-id',
                'formatter' => function (Account $account) {
                    return $account->userId;
                }
            ],
            [
                'key' => 'accountType',
                'label' => "Kontotyp",
                'formatter' => function (Account $account) {
                    return $account->getSwedishType();
                }
            ],
            [
                'key' => 'balance',
                'label' => "Saldo",
                'formatter' => function (Account $account) {
                    return $account->balance;
                }
            ],
            [
                'key' => 'createdAt',
                'label' => 'Skapad'
            ]
        ];

        view('admin/accounts/table',
            [
                'columns' => $columns,
                'paginator' => $accounts,
                'baseUrl' => 'admin/accounts/table'
            ],
            null
        );
    }
}