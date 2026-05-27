<?php

namespace Http\Forms\Transactions;

use Core\Exceptions\ValidationException;

class DepositForm extends BaseTransactionForm
{
    public function validate(): void
    {
        $this->validateAmount();
    }
}