<?php

namespace Http\Forms\Transactions;

use Core\Exceptions\ValidationException;

abstract class BaseTransactionForm
{
    protected $errors = [];

    public function __construct(private array $attributes)
    {
    }

    abstract function validate();

    protected function validateAmount()
    {
        $amount = $this->attributes['amount'];
        $amount = trim($amount);
        if ($amount <= 0) {
            $this->errors['amount'] = "Beloppet måste vara mer än 0 kr.";
        }
        if (!is_numeric($amount)) {
            $this->errors['amount'] = "Måste innehålla enbart siffror.";
        }
    }

    protected function validateAccountNumber()
    {
        $toAccountId = $this->attributes['toAccountId'];
        $toAccountId = trim($toAccountId);
        $fromAccountId = $this->attributes['accountId'];
        $fromAccountId = trim($fromAccountId);

        if ($fromAccountId === $toAccountId) {
            $this->errors['toAccountId'] = "Kan inte överföra pengar till samma konto.";
        }

        if (!is_numeric($toAccountId)) {
            $this->errors['toAccountId'] = "Måste innehålla enbart siffror.";
        }
    }

    public function errors()
    {
        return $this->errors;
    }

    public function failed()
    {
        return !empty($this->errors);
    }

    public function error($field, $message)
    {
        $this->errors[$field] = $message;

        return $this;
    }

}