<?php
/** @var int $accountId */
/** @var array $errors */
?>

<form hx-post="/accounts/<?= e($accountId) ?>/transfer"
      class="bank-form"
>
    <?= csrf_field() ?>
    <label for="amount" class="bank-form__label"> Att överföra:
        <input type="number" step="0.01" name="amount">
        <?php if (isset($errors['amount'])): ?>
            <p><?= e($errors['amount']) ?></p>
        <?php endif ?>
    </label>
    <label for="toAccount" class="bank-form__label"> Till:
        <input type="number" name="toAccountId">
        <?php if (isset($errors['toAccountId'])): ?>
            <p><?= e($errors['toAccountId']) ?></p>
        <?php endif ?>
    </label>
    <div>
        <button type="submit">Överför</button>
        <a href="/accounts/<?= e($accountId) ?>">Avbryt</a>
    </div>
</form>
