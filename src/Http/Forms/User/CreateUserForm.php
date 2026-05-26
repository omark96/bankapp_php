<?php

namespace Http\Forms\User;

use Http\Forms\User\BaseUserForm;

class CreateUserForm extends BaseUserForm
{

    function validate()
    {
        $this->validateName();
        $this->validateCardNumber();
        $this->validateRole();
        $this->validatePinCode();
    }
}