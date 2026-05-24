<?php
/** @var PaginatedArray $transactions */

/** @var Account $account */

/** @var array $columns */

use Core\Types\PaginatedArray;
use Models\Account;


?>

<div class="account-actions">
    <h3 class="account-actions__">Vad vill du göra?</h3>
    <a href="">Ta ut</a>
    <a href="">Sätta in</a>
    <a href="">Överföra</a>
</div>

<?php component('paginatedTable', [
    'columns' => $columns,
    'paginator' => $transactions
]); ?>

