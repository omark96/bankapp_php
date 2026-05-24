<?php

namespace Http\Forms;

use Core\Exceptions\ValidationException;

class DepositForm
{
    protected $errors = [];

    public function __construct(private array $attributes)
    {
    }

    public function validate()
    {
        $this->validateAmount();

        if (!empty($this->errors)) {
            $this->throw();
        }
    }

    private function validateAmount()
    {
        $amount = $this->attributes['amount'];
        $amount = trim($amount);
        if ($amount <= 0) {
            $this->errors['amount'] = "Du måste sätta in mer än 0 kr.";
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