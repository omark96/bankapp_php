<?php

namespace Http\Controllers\Transactions;

use Core\Auth;
use Database\DTOs\CreateTransactionDto;
use Database\Interfaces\AccountRepository;
use Database\Interfaces\TransactionRepository;
use Http\Forms\DepositForm;
use Http\Forms\TransferForm;

readonly class TransferController
{
    public function __construct(
        private AccountRepository     $accountRepository,
        private TransactionRepository $transactionRepository
    )
    {
    }

    public function create(int $accountId): void
    {
        view('accounts/transfer',
            [
                'accountId' => $accountId
            ],
            null);
    }

    public function store(int $accountId): void
    {
        $amount = $_POST['amount'];
        $toAccountId = $_POST['toAccountId'];


        $transferForm = new TransferForm(compact('amount', 'toAccountId', 'accountId'));
        $transferForm->validate();

        $account = $this->accountRepository->getById($accountId);

        if ($amount > $account->balance) {
            $transferForm
                ->error('amount', 'Kan inte överföra mer än du har på kontot')
                ->throw();
        }

        authorize($account->userId === Auth::user()->id);

        $transaction = new CreateTransactionDto(
            $accountId,
            $toAccountId,
            "transfer",
            $amount
        );

        $success = $this->transactionRepository->insert($transaction);
        if (!$success) {
            $transferForm
                ->error('amount', 'Kunde inte överföra pengar till det här kontot, var god försök igen senare.')
                ->throw();
        }

        redirect("/accounts/$accountId");
    }
}