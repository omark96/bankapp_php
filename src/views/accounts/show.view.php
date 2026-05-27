<?php
/** @var PaginatedArray $transactions */

/** @var Account $account */

/** @var array $columns */

use Core\Types\PaginatedArray;
use Models\Account;

?>

<div class="account-actions" hx-target="this" hx-swap="outerHTML">
    <h3 class="account-actions__title">Vad vill du göra?</h3>
    <button class="btn"
            hx-get="/accounts/<?= e($account->id) ?>/withdraw">
        Ta ut
    </button>

    <button class="btn"
            hx-get="/accounts/<?= e($account->id) ?>/deposit">
        Sätta in
    </button>

    <button class="btn"
            hx-get="/accounts/<?= e($account->id) ?>/transfer">
        Överföra
    </button>
</div>

<?php
component('paginatedTable', [
        'columns' => $columns,
        'paginator' => $transactions
]); ?>

