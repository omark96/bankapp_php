<?php
/** @var UpdateUserDto $user */

/** @var array $errors */

use Database\DTOs\UpdateUserDto;

?>
<tbody id="user-block-<?= e($user->id) ?>">
<tr class="paginated-table__row">
    <td class="paginated-table__cell">
        <?= csrf_field() ?>
        <input type="hidden" name="_method" value="PATCH">
        <input type="hidden" name="id" value="<?= e($user->id) ?>">
        <?= e($user->id) ?>
    </td>
    <td class="paginated-table__cell">
        <label>
            <input type="text" name="cardNumber" value="<?= e($user->cardNumber) ?>">
        </label>
    </td>
    <td class="paginated-table__cell">
        <label>
            <input type="text" name="name" value="<?= e($user->name) ?>">
        </label>
    </td>
    <td class="paginated-table__cell">
        <label>
            <select name="role">
                <option value="user" <?= $user->role === 'user' ? 'selected' : '' ?>>user</option>
                <option value="admin" <?= $user->role === 'admin' ? 'selected' : '' ?>>admin</option>
            </select>
        </label>
    </td>
    <td class="paginated-table__cell">
        -
    </td>
    <td class="paginated-table__cell">
        -
    </td>
    <td class="paginated-table__cell">
        <button class="btn paginated-table__button"
                hx-post="/admin/users/<?= e($user->id) ?>"
                hx-include="closest tr"
                hx-target="#user-block-<?= e($user->id) ?>"
                hx-swap="outerHTML"
        >
            Save
        </button>
        <button class="btn paginated-table__button"
                hx-get="/admin/users/table"
                hx-target="#userTable"
                hx-swap="innerHTML"
        >
            Cancel
        </button>
    </td>
</tr>
<?php if (isset($errors)): ?>
    <?php foreach ($errors as $error): ?>
        <tr class="paginated-table__row ">
            <td colspan="6" class="paginated-table__cell--error">
                <?= e($error) ?>
            </td>
        </tr>
    <?php endforeach; ?>
<?php endif ?>
</tbody>
