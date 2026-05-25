<?php

namespace Http\Forms;

use Core\Exceptions\ValidationException;

class TransferForm
{
    protected $errors = [];

    public function __construct(private array $attributes)
    {
    }

    public function validate()
    {
        $this->validateAccountNumber();
        $this->validateAmount();
        if (!empty($this->errors)) {
            $this->throw();
        }
    }

    private function validateAccountNumber()
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

    private function validateAmount()
    {
        $amount = $this->attributes['amount'];
        $amount = trim($amount);
        if ($amount <= 0) {
            $this->errors['amount'] = "Du måste överföra mer än 0 kr.";
        }
        if (!is_numeric($amount)) {
            $this->errors['amount'] = "Måste innehålla enbart siffror.";
        }
    }

    public function errors()
    {
        return $this->errors;
    }

    public function throw()
    {
        ValidationException::throw($this->errors(), $this->attributes);
    }

    public function error($field, $message)
    {
        $this->errors[$field] = $message;

        return $this;
    }
}