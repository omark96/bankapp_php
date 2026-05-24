<?php

use Models\Account;

/** @var Account $account */

$accountType = match ($account->accountType) {
    "checking" => "Privatkonto",
    "saving" => "Sparkapitalkonto"
};
?>

<div class="account-card">
    <h3 class="account-card__title"><?= $accountType ?></h3>
    <p class="account-card__balance"> <?= $account->balance ?></p>
    <a href="accounts/<?= $account->id ?>"> > </a>
</div>
