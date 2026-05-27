<?php

namespace Http\Controllers;

use Core\Auth;
use Database\DTOs\CreateTransactionDto;
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

    public function index(): void
    {
        $accounts = $this->accountRepository->getAllByUserId(Auth::user()->id);
        view('/accounts/index', [
            'accounts' => $accounts,
        ]);
    }

    public function show(int $accountId): void
    {
        $account = $this->accountRepository->getById($accountId);
        authorize($account->userId == Auth::user()->id);
        $page = $_GET['page'] ?? 1;
        $transactions = $this->transactionRepository->getAllByAccountIdPaginated($accountId, $page, 3);

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
                'formatter' => function (Transaction $transaction) use ($accountId) {
                    if ($transaction->type === 'deposit') {
                        return $transaction->amount;
                    }

                    if ($transaction->type === 'transfer') {
                        if ($transaction->toAccountId === $accountId) {
                            return $transaction->amount;
                        }
                        return "-" . $transaction->amount;
                    }

                    return "-" . $transaction->amount;
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