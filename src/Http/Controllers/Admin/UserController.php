<?php

namespace Http\Controllers\Admin;

use Database\Interfaces\UserRepository;
use Models\User;

class UserController
{
    public function __construct(
        private UserRepository $userRepository
    )
    {
    }

    public function index()
    {
        view('admin/users/index', [], null);
    }

    public function table()
    {
        $page = $_GET['page'] ?? 1;
        $users = $this->userRepository->getAllPaginated($page, 3);

        $columns = [
            [
                'key' => 'id',
                'label' => 'Id',
                'formatter' => function (User $user) {
                    return $user->id;
                }
            ],
            [
                'key' => 'cardNumber',
                'label' => 'Kortnummer',
                'formatter' => function (User $user) {
                    return $user->cardNumber;
                }
            ],
            [
                'key' => 'name',
                'label' => "Kontotyp",
                'formatter' => function (User $user) {
                    return $user->name;
                }
            ],
            [
                'key' => 'role',
                'label' => "Roll",
                'formatter' => function (User $user) {
                    return $user->role;
                }
            ],
            [
                'key' => 'createdAt',
                'label' => 'Skapad'
            ]
        ];

        view('admin/users/table',
            [
                'columns' => $columns,
                'paginator' => $users,
                'baseUrl' => 'admin/users/table'
            ],
            null
        );
    }
}