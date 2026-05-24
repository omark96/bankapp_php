<?php

namespace Http\Controllers;

use Core\Auth;
use Database\DTOs\CreateTransactionDTO;
use Database\Interfaces\AccountRepository;
use Database\Interfaces\TransactionRepository;
use Http\Forms\DepositForm;
use Models\Transaction;

readonly class AccountController
{
    public function __construct(
        private AccountRepository     $accountRepository,
        private TransactionRepository $transactionRepository
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
        $page = $_GET['page'] ?? 1;
        $transactions = $this->transactionRepository->getAllByAccountIdPaginated($accountId, $page, 3);
        authorize($account->userId == Auth::user()->id);

        $columns = [
            [
                'key' => 'type',
                'label' => 'Transaktionstyp',
                'formatter' => function (Transaction $transaction) {
                    return $transaction->getSwedishType();
                }
            ],
            [
                'key' => 'fromAccountId',
                'label' => 'Från',
                'formatter' => function (Transaction $transaction) {
                    return $transaction->fromAccountId ?? "-";
                }
            ],
            [
                'key' => 'toAccountId',
                'label' => "Till",
                'formatter' => function (Transaction $transaction) {
                    return $transaction->toAccountId ?? "-";
                }
            ],
            [
                'key' => 'createdAt',
                'label' => 'Datum'
            ],
            [
                'key' => 'amount',
                'label' => 'Summa',
                'formatter' => function (Transaction $transaction) {
                    return match ($transaction->type) {
                        "deposit" => $transaction->amount,
                        default => "-" . $transaction->amount
                    };
                }
            ]
        ];
        view('accounts/show', [
            'account' => $account,
            'columns' => $columns,
            'transactions' => $transactions
        ]);
    }


}