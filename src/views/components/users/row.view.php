<?php
/** @var array $columns */

/** @var User $user */

use Models\User;

?>
<tbody id="user-block-<?= e($user->id) ?>"
       hx-target="this"
       hx-swap="outerHTML"
>
<tr class="paginated-table__row"
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
        <?php if (!$user->deleted): ?>
            <button class="btn paginated-table__button"
                    hx-get="/admin/users/<?= e($user->id) ?>/edit"
            >
                Redigera
            </button>
            <button class="btn paginated-table__button--warning"
                    hx-post="/admin/users/<?= e($user->id) ?>/destroy"
                    hx-confirm="Are you sure you want to delete this user?"
                    hx-vals='{"_method": "DELETE", "csrf_token": "<?= e(csrf_token()) ?>"}'
            >
                Ta bort
            </button>
        <?php endif ?>
    </td>
</tr>
</tbody>
