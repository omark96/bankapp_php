<?php

namespace controllers;

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

    public function test(int $id)
    {
        view('example', [
            'text' => $id
        ]);
    }
}