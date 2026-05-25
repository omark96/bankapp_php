<?php
/** @var PaginatedArray $transactions */


/** @var array $columns */

use Core\Types\PaginatedArray;

?>

<div class="tab-list">
    <button hx-get="/admin/users" class="tab-list__tab">
        Användare
    </button>
    <button hx-get="/admin/accounts" class="tab-list__tab">
        Konton
    </button>
    <button hx-get="/admin/transactions" class="tab-list__tab selected">
        Transaktioner
    </button>
</div>

<div id="tab-content" class="tab-content">
    <div id="transactionTable"
         hx-get="/admin/transactions/table"
         hx-trigger="load"
         hx-target="this"
         hx-swap="innerHTML">
    </div>

</div>
