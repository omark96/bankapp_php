<?php
/** @var int $accountId */
?>

<form method="POST" action="/accounts/<?= e($accountId) ?>/transfer">
    <?= csrf_field() ?>
    <label for="amount"> Att överföra:</label>
    <input type="number" step="0.01" name="amount">
    <?php if (isset($errors['amount'])): ?>
        <p><?= e($errors['amount']) ?></p>
    <?php endif ?>
    <label for="toAccount"> Till:</label>
    <input type="number" name="toAccountId">
    <?php if (isset($errors['toAccountId'])): ?>
        <p><?= e($errors['toAccountId']) ?></p>
    <?php endif ?>
    <button type="submit">Överför</button>
    <a href="/accounts/<?= e($accountId) ?>">Avbryt</a>
</form>
