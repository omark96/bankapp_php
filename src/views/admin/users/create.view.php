<?php
/** @var CreateUserDto $user */

/** @var array $errors */

use Database\DTOs\CreateUserDto;

?>

<form id="userCreationForm"
      hx-target="this"
      hx-swap="outerHTML"
      hx-post="/admin/users"
>
    <h2>Skapa en ny användare</h2>
    <?= csrf_field() ?>
    <label for="cardNumber">Kortnummer
        <input type="text" name="cardNumber" value="<?= e($user->cardNumber) ?>" required>
        <?php if (isset($errors['cardNumber'])): ?>
            <p class="error-text"><?= e($errors['cardNumber']) ?></p>
        <?php endif ?>
    </label>

    <label for="pinCode">Pinkod
        <input type="text" name="pinCode" value="" required>
        <?php if (isset($errors['pinCode'])): ?>
            <p class="error-text"><?= e($errors['pinCode']) ?></p>
        <?php endif ?>
    </label>

    <label for="name">Namn
        <input type="text" name="name" value="<?= e($user->name) ?>" required>
        <?php if (isset($errors['name'])): ?>
            <p class="error-text"><?= e($errors['name']) ?></p>
        <?php endif ?>
    </label>

    <label for="role">Roll
        <select type="text" name="role" required>
            <option value="user" <?= $user->role === 'user' ? 'selected' : '' ?>>user</option>
            <option value="admin" <?= $user->role === 'admin' ? 'selected' : '' ?>>admin</option>
        </select>
        <?php if (isset($errors['role'])): ?>
            <p class="error-text"><?= e($errors['role']) ?></p>
        <?php endif ?>
    </label>

    <div>
        <button
                type="submit"
        >
            Save
        </button>
        <button
                hx-get="/admin/users"
                hx-target="#tabs"
                hx-swap="innerHTML"
        >
            Cancel
        </button>
    </div>

</form>
