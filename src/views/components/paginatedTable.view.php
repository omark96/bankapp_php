<?php
/** @var array $columns */

/** @var PaginatedArray $paginator */

use Core\Types\PaginatedArray;

$rows = $paginator->items;

?>

<div class="paginated-table">
    <table class="paginated-table__table">
        <thead class="paginated-table__head">
        <tr class="paginated-table__row paginated-table__row--header">
            <?php foreach ($columns as $column): ?>
                <th class="paginated-table__cell paginated-table__cell--header">
                    <?= e($column['label']) ?>
                </th>
            <?php endforeach; ?>
        </tr>
        </thead>
        <tbody class="paginated-table__body">
        <?php foreach ($rows as $row): ?>
            <tr class="paginated-table__row">
                <?php foreach ($columns as $column): ?>
                    <td class="paginated-table__cell">
                        <?php
                        if (isset($column['formatter'])) {
                            echo e($column['formatter']($row));
                        } else {
                            $value = $row->{$column['key']};
                            if ($value instanceof DateTimeImmutable) {
                                $value = $value->format("Y-m-d");
                            }
                            echo e((string)$value);
                        }
                        ?>
                    </td>
                <?php endforeach; ?>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
    <div class="paginated-table__paginator">
        <a href="<?= e($paginator->firstPage()) ?>" class="paginated-table__link-arrow">&laquo;</a>
        <a href="<?= e($paginator->previousPage()) ?>" class="paginated-table__link-arrow">&lt;</a>
        <p> <?= e($paginator->currentlyShowing()) ?></p>
        <a href="<?= e($paginator->nextPage()) ?>" class="paginated-table__link-arrow">&gt;</a>
        <a href="<?= e($paginator->lastPage()) ?>" class="paginated-table__link-arrow">&raquo;</a>
    </div>
</div>
