<?php

namespace Http\Controllers\Transactions;

use Core\Auth;
use Database\DTOs\CreateTransactionDto;
use Database\Interfaces\AccountRepository;
use Database\Interfaces\TransactionRepository;
use Http\Controllers\AccountController;
use Http\Forms\DepositForm;

readonly class DepositController
{
    public function __construct(
        private AccountRepository     $accountRepository,
        private TransactionRepository $transactionRepository
    )
    {
    }

    public function create(int $accountId): void
    {
        view('accounts/deposit',
            [
                'accountId' => $accountId
            ],
            null);
    }

    public function store(int $accountId): void
    {
        $amount = $_POST['amount'];
        $depositForm = new DepositForm(compact('amount'));
        $depositForm->validate();

        $account = $this->accountRepository->getById($accountId);

        authorize($account->userId === Auth::user()->id);

        $transaction = new CreateTransactionDto(
            null,
            $accountId,
            "deposit",
            $amount
        );

        $success = $this->transactionRepository->insert($transaction);

        if (!$success) {
            $depositForm
                ->error('amount', 'Kunde inte sätta in pengarna, var god försök igen senare.')
                ->throw();
        }

        redirect("/accounts/$accountId");
    }
}