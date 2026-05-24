<?php

namespace Http\Controllers\Transactions;

use Core\Auth;
use Database\DTOs\CreateTransactionDTO;
use Database\Interfaces\AccountRepository;
use Database\Interfaces\TransactionRepository;
use Http\Forms\DepositForm;

class DepositController
{
    public function __construct(
        private AccountRepository     $accountRepository,
        private TransactionRepository $transactionRepository
    )
    {
    }

    public function create(int $accountId)
    {
        view('accounts/deposit',
            [
                'accountId' => $accountId
            ],
            null);
    }

    public function store(int $accountId)
    {
        dd($_POST);
        $amount = $_POST['amount'];
        $depositForm = new DepositForm(compact('amount'));
        $depositForm->validate();

        $account = $this->accountRepository->getById($accountId);

        authorize($account->userId === Auth::user());

        $transaction = new CreateTransactionDTO(
            $accountId,
            null,
            "deposit",
            $amount
        );

        $success = $this->transactionRepository->insert($transaction);

        if (!$success) {
            $depositForm
                ->error('amount', 'Kunde inte sätta in pengarna, var god försök igen senare.')
                ->throw();
        }
        redirect('/');
    }
}