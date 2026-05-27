<?php
/** @var CreateUserDto $user */

/** @var array $errors */

use Database\DTOs\CreateUserDto;

?>

<form id="userCreationForm"
      class="bank-form"
      hx-target="this"
      hx-swap="outerHTML"
      hx-post="/admin/users"
>
    <h2>Skapa en ny användare</h2>
    <?= csrf_field() ?>
    <label for="cardNumber" class="bank-form__label">Kortnummer
        <input type="text" name="cardNumber" value="<?= e($user->cardNumber) ?>" required>
        <?php if (isset($errors['cardNumber'])): ?>
            <p class="error-text"><?= e($errors['cardNumber']) ?></p>
        <?php endif ?>
    </label>

    <label for="pinCode" class="bank-form__label">Pinkod
        <input type="text" name="pinCode" value="" required>
        <?php if (isset($errors['pinCode'])): ?>
            <p class="error-text"><?= e($errors['pinCode']) ?></p>
        <?php endif ?>
    </label>

    <label for="name" class="bank-form__label">Namn
        <input type="text" name="name" value="<?= e($user->name) ?>" required>
        <?php if (isset($errors['name'])): ?>
            <p class="error-text"><?= e($errors['name']) ?></p>
        <?php endif ?>
    </label>

    <label for="role" class="bank-form__label">Roll
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
