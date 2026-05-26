<?php

namespace Http\Controllers\Admin;

use Database\DTOs\UpdateUserDto;
use Database\Interfaces\UserRepository;
use Http\Forms\User\UpdateUserForm;
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

    public function edit(int $id)
    {
        $user = $this->userRepository->getById($id);
        view('admin/users/edit',
            [
                'user' => $user
            ],
            null);
    }

    public function update(int $id)
    {
        $cardNumber = $_POST['cardNumber'];
        $role = $_POST['role'];
        $name = $_POST['name'];

        $updateForm = new UpdateUserForm(compact('cardNumber', 'role', 'name'));
        $updateForm->validate();

        $userDto = new UpdateUserDto($id, $name, $role, $cardNumber);

        if ($updateForm->failed()) {
            view('admin/users/edit',
                [
                    'user' => $userDto,
                    'errors' => $updateForm->errors()
                ],
                null);
            exit();
        }


        $user = $this->userRepository->update($userDto);
        if (!$user) {
            $user = $this->userRepository->getById($id);
        }
        component('users/row',
            [
                'user' => $user,
                'columns' => $this->columns()
            ]
        );
        exit();
    }

    public function table()
    {
        $page = $_GET['page'] ?? 1;
        $users = $this->userRepository->getAllPaginated($page, 3);

        $columns = $this->columns();

        view('admin/users/table',
            [
                'paginator' => $users,
                'baseUrl' => 'admin/users/table',
                'columns' => $columns
            ],
            null
        );
    }

    private function columns()
    {
        return [
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
    }
}