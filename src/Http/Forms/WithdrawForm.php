<?php

namespace Http\Forms;

use Core\Exceptions\ValidationException;

class WithdrawForm
{
    protected $errors = [];

    public function __construct(private array $attributes)
    {
    }

    public function validate()
    {
        $this->validatePinCode();
        $this->validateCardNumber();

        if (!empty($this->errors)) {
            $this->throw();
        }
    }

    private function validatePinCode()
    {
        $pinCode = $this->attributes['pinCode'];
        $pinCode = trim($pinCode);
        if (strlen($pinCode) != 4) {
            $this->errors['pinCode'] = "Pinkoden måste vara exakt 4 siffror långt.";
        }
        if (!is_numeric($pinCode)) {
            $this->errors['pinCode'] = "Pinkoden kan enbart innehålla siffror.";
        }
    }

    private function validateCardNumber()
    {
        $cardNumber = $this->attributes['cardNumber'];
        $cardNumber = trim($cardNumber);
        $cardNumber = str_replace(' ', '', $cardNumber);
        if (strlen($cardNumber) != 4) {
            $this->errors['cardNumber'] = "Kortnummret måste vara exakt 4 siffror långt.";
        }
        if (!is_numeric($cardNumber)) {
            $this->errors['cardNumber'] = "Kortnummret kan enbart innehålla siffror.";
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