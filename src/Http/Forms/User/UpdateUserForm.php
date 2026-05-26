<?php

namespace Http\Forms\User;

use Http\Forms\User\BaseUserForm;

class UpdateUserForm extends BaseUserForm
{

    function validate()
    {
        $this->validateName();
        $this->validateCardNumber();
        $this->validateRole();
    }
}