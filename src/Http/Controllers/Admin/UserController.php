<?php

namespace Http\Controllers\Admin;

use Core\Auth;
use Database\DTOs\CreateUserDto;
use Database\DTOs\UpdateUserDto;
use Database\DTOs\UserFilterDto;
use Database\Interfaces\UserRepository;
use Http\Forms\User\CreateUserForm;
use Http\Forms\User\UpdateUserForm;
use Models\User;

readonly class UserController
{
    public function __construct(
        private UserRepository $userRepository
    )
    {
    }

    public function index(): void
    {
        view('admin/users/index', [], null);
    }

    public function edit(int $id): void
    {
        $user = $this->userRepository->getById($id);
        view('admin/users/edit',
            [
                'user' => $user
            ],
            null);
    }

    public function update(int $id): void
    {
        $cardNumber = $_POST['cardNumber'];
        $role = $_POST['role'];
        $name = $_POST['name'];

        $updateForm = new UpdateUserForm(compact('cardNumber', 'role', 'name'));
        $updateForm->validate();

        $userDto = new UpdateUserDto($id, $name, $role, $cardNumber);

        if ($id === Auth::user()->id && $role !== Auth::user()->role) {
            $updateForm->error('role', 'Kan inte ändra rollen på det kontot du är inloggad på.');
        }

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

    public function destroy(int $id): void
    {
        $this->userRepository->delete($id);

        header('HX-Trigger: refreshTabs');
    }

    public function create(): void
    {
        $userDto = new CreateUserDto();
        view('admin/users/create',
            [
                'user' => $userDto,
                'errors' => []
            ],
            null
        );
    }

    public function store(): void
    {
        $name = $_POST['name'];
        $role = $_POST['role'];
        $cardNumber = $_POST['cardNumber'];
        $pinCode = $_POST['pinCode'];

        $createForm = new CreateUserForm(compact('cardNumber', 'pinCode', 'role', 'name'));
        $createForm->validate();

        $userDto = new CreateUserDto($name, $role, $cardNumber, $pinCode);

        if ($createForm->failed()) {
            view('admin/users/create',
                [
                    'user' => $userDto,
                    'errors' => $createForm->errors()
                ],
                null
            );
            exit();
        }

        $user = $this->userRepository->insert($userDto);
        if (!$user) {
            $createForm->error('cardNumber', 'Kunde inte skapa en användare');
            view('admin/users/create',
                [
                    'user' => $userDto,
                    'errors' => $createForm->errors()
                ],
                null
            );
            exit();

        }

        header('HX-Trigger: refreshTabs');
    }

    public function table(): void
    {
        $cardNumber = null;
        $name = null;
        $role = null;

        if ($_SERVER['REQUEST_METHOD'] === "POST") {
            $cardNumber = strlen($_POST['cardNumber']) > 0 ? $_POST['cardNumber'] : null;
            $name = strlen($_POST['name']) > 0 ? $_POST['name'] : null;
            $role = strlen($_POST['role']) > 0 ? $_POST['role'] : null;
        }

        $filter = new UserFilterDto(
            $cardNumber,
            $name,
            $role
        );

        $page = $_GET['page'] ?? 1;
        $users = $this->userRepository->getAllPaginated($filter, $page, 20);

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

    private function columns(): array
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
                'label' => "Namn",
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