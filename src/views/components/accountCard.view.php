<?php

use Models\Account;

/** @var Account $account */

$accountType = match ($account->accountType) {
    "checking" => "Privatkonto",
    "saving" => "Sparkapitalkonto"
};
?>
<a href="accounts/<?= e($account->id) ?>">
    <div class="account-card">
        <div>
            <h3 class="account-card__title"><?= e($accountType) ?></h3>
            <p class="account-card__balance"> Kontonummer: <?= e($account->id) ?></p>
            <p class="account-card__balance"> Saldo: <?= e($account->balance) ?></p>
        </div>
        <p class="account-card__arrow">&gt;</p>
    </div>
</a>