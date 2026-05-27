<?php
/** @var int $accountId */
/** @var array $errors */
?>

<form hx-post="/accounts/<?= e($accountId) ?>/withdraw"
      class="bank-form"
>
    <?= csrf_field() ?>
    <label for="amount" class="bank-form__label"> Att ta ut:
        <input type="number" step="0.01" name="amount">
        <?php if (isset($errors['amount'])): ?>
            <p><?= e($errors['amount']) ?></p>
        <?php endif ?>
    </label>
    <div>
        <button type="submit">Ta ut</button>
        <a href="/accounts/<?= e($accountId) ?>">Avbryt</a>
    </div>
</form>
