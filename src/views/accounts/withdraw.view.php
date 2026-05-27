<?php
/** @var int $accountId */
/** @var array $errors */
?>

<form hx-post="/accounts/<?= e($accountId) ?>/withdraw"
      hx-swap="outerHTML"
      class="bank-form"
>
    <?= csrf_field() ?>
    <label for="amount" class="bank-form__label"> Att ta ut:
        <input type="number" step="0.01" name="amount">
        <?php if (isset($errors['amount'])): ?>
            <p class="error-text"><?= e($errors['amount']) ?></p>
        <?php endif ?>
    </label>
    <div>
        <button class="btn"
                type="submit">Ta ut
        </button>
        <a class="btn"
           href="/accounts/<?= e($accountId) ?>">Avbryt</a>
    </div>
</form>
