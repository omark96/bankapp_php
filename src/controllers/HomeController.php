<?php

namespace controllers;

class HomeController
{
    public function index()
    {
        view('index');
    }

    public function error($code)
    {
        view('error', [
            'code' => $code
        ]);
    }
}