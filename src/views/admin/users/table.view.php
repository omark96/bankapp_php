<?php
/** @var array $columns */

/** @var PaginatedArray $paginator */

/** @var string $baseUrl */

use Core\Types\PaginatedArray;

$rows = $paginator->items;

?>
<div hx-target="this"
     id="userTable"
>
    <form hx-post="/admin/users/table"
          hx-trigger="change"
          hx-swap="innerHTML"
          class="filterForm"
          id="usersFilterForm"
    >
        <?= csrf_field() ?>
    </form>
    <div class="paginated-table">
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
                <tr id="user-row-<?= e($user->id) ?>"
                    class="paginated-table__row"
                    hx-target="this"
                    hx-swap="outerHTML"
                >
                    <?php foreach ($columns as $column): ?>
                        <td class="paginated-table__cell">
                            <?php
                            if (isset($column['formatter'])) {
                                echo e($column['formatter']($user));
                            } else {
                                $value = $user->{$column['key']};
                                if ($value instanceof DateTimeImmutable) {
                                    $value = $value->format("Y-m-d");
                                }
                                echo e((string)$value);
                            }
                            ?>
                        </td>
                    <?php endforeach; ?>
                    <td class="paginated-table__cell">
                        <button
                                hx-get="/admin/users/<?= e($user->id) ?>/edit"
                        >
                            Redigera
                        </button>
                        <button>
                            Ta bort
                        </button>
                    </td>
                </tr>
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
</div>