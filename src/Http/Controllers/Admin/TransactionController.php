<?php

namespace Http\Controllers\Admin;

use Database\DTOs\TransactionFilterDto;
use Database\Interfaces\TransactionRepository;
use Models\Transaction;

readonly class TransactionController
{
    public function __construct(
        private TransactionRepository $transactionRepository
    )
    {
    }

    public function index(): void
    {

        view('admin/transactions/index', [], null);
    }

    public function table(): void
    {
        $startDate = null;
        $endDate = null;
        $type = null;
        if ($_SERVER['REQUEST_METHOD'] === "POST") {
            $startDate = strlen($_POST['startDate']) > 0 ? $_POST['startDate'] : null;
            $endDate = strlen($_POST['endDate']) > 0 ? $_POST['endDate'] : null;
            $type = strlen($_POST['type']) > 0 ? $_POST['type'] : null;
            $filter = new TransactionFilterDto(
                $startDate,
                $endDate,
                $type
            );
        } else {
            $filter = new TransactionFilterDto();
        }
        $page = $_GET['page'] ?? 1;

        $transactions = $this->transactionRepository->getAllPaginated($filter, $page, 20);

        $columns = [
            [
                'key' => 'id',
                'label' => 'Id',
                'formatter' => function (Transaction $transaction) {
                    return $transaction->id;
                }
            ],
            [
                'key' => 'type',
                'label' => 'Transaktionstyp',
                'formatter' => function (Transaction $transaction) {
                    return $transaction->getSwedishType();
                }
            ],
            [
                'key' => 'fromAccountId',
                'label' => 'Från',
                'formatter' => function (Transaction $transaction) {
                    return $transaction->fromAccountId ?? "-";
                }
            ],
            [
                'key' => 'toAccountId',
                'label' => "Till",
                'formatter' => function (Transaction $transaction) {
                    return $transaction->toAccountId ?? "-";
                }
            ],
            [
                'key' => 'createdAt',
                'label' => 'Datum'
            ],
            [
                'key' => 'amount',
                'label' => 'Belopp',
                'formatter' => function (Transaction $transaction) {
                    return $transaction->amount;
                }
            ]
        ];

        view('admin/transactions/table',
            [
                'columns' => $columns,
                'paginator' => $transactions,
                'startDate' => $startDate,
                'endDate' => $endDate,
                'type' => $type,
                'baseUrl' => 'admin/transactions/table'
            ],
            null
        );
    }
}