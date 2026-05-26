<?php
/** @var User $user */

use Models\User;

?>
<tr id="user-row-<?= e($user->id) ?>">
    <td class="paginated-table__cell">
        <?= csrf_field() ?>
        <input type="hidden" name="_method" value="PATCH">
        <input type="hidden" name="id" value="<?= e($user->id) ?>">
        <?= e($user->id) ?>
    </td>
    <td class="paginated-table__cell">

        <input type="text" name="cardNumber" value="<?= e($user->cardNumber) ?>">
    </td>
    <td class="paginated-table__cell">
        <input type="text" name="name" value="<?= e($user->name) ?>">
    </td>
    <td class="paginated-table__cell">
        <select type="text" name="role">
            <option value="user" <?= $user->role === 'user' ? 'selected' : '' ?>>user</option>
            <option value="admin" <?= $user->role === 'admin' ? 'selected' : '' ?>>admin</option>
        </select>
    </td>
    <td class="paginated-table__cell">
        <?= e($user->createdAt->format("Y-m-d")) ?>
    </td>
    <td class="paginated-table__cell">
        <button
                hx-post="/admin/users/<?= e($user->id) ?>"
                hx-include="closest tr"
                hx-target="#userTable"
                hx-swap="innerHTML"
        >
            Save
        </button>
        <button
                hx-get="/admin/users/table"
                hx-target="#userTable"
                hx-swap="innerHTML"
        >
            Cancel
        </button>
    </td>
</tr>