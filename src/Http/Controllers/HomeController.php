<?php

namespace Http\Controllers;

class HomeController
{
    public function index()
    {
        view('index');
    }

    public function error(int $code)
    {
        view('error', [
            'code' => $code
        ]);
    }
}