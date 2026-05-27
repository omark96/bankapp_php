<?php

namespace Http\Forms\Transactions;

use Core\Exceptions\ValidationException;

class WithdrawForm extends BaseTransactionForm
{

    public function validate(): void
    {
        $this->validateAmount();
    }
}