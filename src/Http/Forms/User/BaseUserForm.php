<?php

namespace Http\Forms\User;

abstract class BaseUserForm
{
    protected $errors = [];

    abstract function validate();

    public function __construct(private array $attributes)
    {
    }

    public function errors()
    {
        return $this->errors;
    }

    public function failed()
    {
        return !empty($this->errors);
    }

    protected function validateRole()
    {
        if (!isset($this->attributes['role'])) {
            $this->errors['role'] = 'Måste fyllas i';
            return;
        }
        $role = $this->attributes['role'];
        $role = trim($role);
        if ($role !== 'admin' && $role !== 'user') {
            $this->errors['role'] = 'Kan inte lägga till den rollen';
        }
    }

    protected function validateName()
    {
        if (!isset($this->attributes['name'])) {
            $this->errors['name'] = 'Måste fyllas i';
            return;
        }
        $name = $this->attributes['name'];
        $name = trim($name);

        if (strlen($name) < 1) {
            $this->errors['name'] = 'För kort namn';
        }
    }

    protected function validatePinCode()
    {
        if (!isset($this->attributes['pinCode'])) {
            $this->errors['pinCode'] = 'Måste fyllas i';
            return;
        }
        $pinCode = $this->attributes['pinCode'];
        $pinCode = trim($pinCode);
        if (strlen($pinCode) != 4) {
            $this->errors['pinCode'] = "Pinkoden måste vara exakt 4 siffror långt.";
        }
        if (!is_numeric($pinCode)) {
            $this->errors['pinCode'] = "Pinkoden kan enbart innehålla siffror.";
        }
    }

    protected function validateCardNumber()
    {
        if (!isset($this->attributes['cardNumber'])) {
            $this->errors['cardNumber'] = 'Måste fyllas i';
            return;
        }
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

    public function error($field, $message)
    {
        $this->errors[$field] = $message;

        return $this;
    }
}