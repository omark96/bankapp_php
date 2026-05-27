<?php
/** @var array $columns */

/** @var PaginatedArray $paginator */

/** @var string $baseUrl */

/** @var UserFilterDto $filter */

use Core\Types\PaginatedArray;
use Database\DTOs\UserFilterDto;

$rows = $paginator->items;

?>
<div class="paginated-table">
    <form id="table-csrf-form">
        <?= csrf_field() ?>
    </form>
    <table id="transactionsTable" class="paginated-table__table">
        <thead class="paginated-table__head">
        <tr class="paginated-table__row paginated-table__row--header">
            <?php foreach ($columns as $column): ?>
                <th class="paginated-table__cell paginated-table__cell--header">
                    <?= e($column['label']) ?>
                </th>
            <?php endforeach; ?>
            <th class="paginated-table__cell paginated-table__cell--header"></th>
        </tr>
        </thead>
        <tbody class="paginated-table__body">
        <?php foreach ($rows as $user): ?>
            <?php component('users/row', [
                    'user' => $user,
                    'columns' => $columns
            ]) ?>
        <?php endforeach; ?>
        </tbody>
    </table>

    <div class="paginated-table__paginator">
        <a hx-post="<?= e($paginator->firstPage($baseUrl)) ?>"
           hx-include="#accountsFilterForm"
           class="paginated-table__link-arrow">&laquo;</a>
        <a hx-post="<?= e($paginator->previousPage($baseUrl)) ?>"
           hx-include="#accountsFilterForm"
           class="paginated-table__link-arrow">&lt;</a>
        <p> <?= e($paginator->currentlyShowing()) ?></p>
        <a hx-post="<?= e($paginator->nextPage($baseUrl)) ?>"
           hx-include="#accountsFilterForm"
           class="paginated-table__link-arrow">&gt;</a>
        <a hx-post="<?= e($paginator->lastPage($baseUrl)) ?>"
           hx-include="#accountsFilterForm"
           class="paginated-table__link-arrow">&raquo;</a>
    </div>
</div>
