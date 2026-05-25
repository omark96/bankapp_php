<?php

namespace Http\Controllers\Transactions;

use Core\Auth;
use Database\DTOs\CreateTransactionDto;
use Database\Interfaces\AccountRepository;
use Database\Interfaces\TransactionRepository;
use Http\Forms\WithdrawForm;

class WithdrawController
{
    public function __construct(
        private AccountRepository     $accountRepository,
        private TransactionRepository $transactionRepository
    )
    {
    }

    public function create(int $accountId)
    {
        view('accounts/withdraw',
            [
                'accountId' => $accountId
            ],
            null);
    }

    public function store(int $accountId)
    {
        $amount = $_POST['amount'];
        $withdrawForm = new WithdrawForm(compact('amount'));
        $withdrawForm->validate();

        $account = $this->accountRepository->getById($accountId);

        if ($amount > $account->balance) {
            $withdrawForm
                ->error('amount', 'Kan inte ta ut mer än du har på kontot')
                ->throw();
        }

        authorize($account->userId === Auth::user()->id);

        $transaction = new CreateTransactionDto(
            $accountId,
            null,
            "withdraw",
            $amount
        );

        $success = $this->transactionRepository->insert($transaction);

        if (!$success) {
            $withdrawForm
                ->error('amount', 'Kunde inte ta ut pengarna, var god försök igen senare.')
                ->throw();
        }

        redirect("/accounts/$accountId");

    }
}