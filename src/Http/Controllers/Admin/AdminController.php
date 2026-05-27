<?php

namespace Http\Controllers\Admin;

readonly class AdminController
{
    public function index(): void
    {
        view('/admin/index');
    }
}