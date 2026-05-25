<?php

namespace Http\Controllers\Admin;

class UserController
{
    public function index()
    {
        view('admin/users/index', [], null);
    }

    public function create()
    {

    }
}