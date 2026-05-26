<?php
/** @var int $accountId */
?>

<form method="POST" action="/accounts/<?= e($accountId) ?>/deposit">
    <?= csrf_field() ?>
    <label for="amount"> Att sätta in:</label>
    <input type="number" step="0.01" name="amount">
    <?php if (isset($errors['amount'])): ?>
        <p><?= $errors['amount'] ?></p>
    <?php endif ?>
    <button type="submit">Sätt in</button>
    <a href="/accounts/<?= e($accountId) ?>">Avbryt</a>
</form>
