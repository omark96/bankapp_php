<?php
/** @var int $accountId */
/** @var array $errors */
?>

<form hx-post="/accounts/<?= e($accountId) ?>/withdraw">
    <?= csrf_field() ?>
    <label for="amount"> Att ta ut:</label>
    <input type="number" step="0.01" name="amount">
    <?php if (isset($errors['amount'])): ?>
        <p><?= e($errors['amount']) ?></p>
    <?php endif ?>
    <button type="submit">Ta ut</button>
    <a href="/accounts/<?= e($accountId) ?>">Avbryt</a>
</form>
