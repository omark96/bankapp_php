<?php

namespace Http\Forms\Transactions;

use Core\Exceptions\ValidationException;

class TransferForm extends BaseTransactionForm
{
    public function validate(): void
    {
        $this->validateAccountNumber();
        $this->validateAmount();
    }
}