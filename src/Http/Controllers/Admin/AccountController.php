<?php

namespace Http\Controllers\Admin;

use Database\Interfaces\AccountRepository;
use Models\Account;

class AccountController
{
    public function __construct(
        private AccountRepository $accountRepository
    )
    {
    }

    public function index()
    {
        view('admin/accounts/index', [], null);
    }

    public function table()
    {
        $page = $_GET['page'] ?? 1;
        $accounts = $this->accountRepository->getAllPaginated($page, 3);

        $columns = [
            [
                'key' => 'type',
                'label' => 'Transaktionstyp',
                'formatter' => function (Account $account) {
                    return $account->getSwedishType();
                }
            ],
            [
                'key' => 'fromAccountId',
                'label' => 'Från',
                'formatter' => function (Account $account) {
                    return $account->fromAccountId ?? "-";
                }
            ],
            [
                'key' => 'toAccountId',
                'label' => "Till",
                'formatter' => function (Account $account) {
                    return $account->toAccountId ?? "-";
                }
            ],
            [
                'key' => 'createdAt',
                'label' => 'Datum'
            ],
            [
                'key' => 'amount',
                'label' => 'Belopp',
                'formatter' => function (Account $account) {
                    return $account->amount;
                }
            ]
        ];
    }
}