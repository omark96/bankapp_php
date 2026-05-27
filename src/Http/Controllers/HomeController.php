<?php

namespace Http\Controllers;

readonly class HomeController
{
    public function index(): void
    {
        view('index');
    }

    public function error(int $code): void
    {
        view('error', [
            'code' => $code
        ]);
    }
}