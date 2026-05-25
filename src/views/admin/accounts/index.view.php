<?php
?>

<div class="tab-list">
    <button hx-get="/admin/users" class="tab-list__tab">
        Användare
    </button>
    <button hx-get="/admin/accounts" class="tab-list__tab selected">
        Konton
    </button>
    <button hx-get="/admin/transactions" class="tab-list__tab">
        Transaktioner
    </button>
</div>

<div id="tab-content" class="tab-content">
    <div id="accountTable"
         hx-get="/admin/accounts/table"
         hx-trigger="load"
         hx-target="this"
         hx-swap="innerHTML">
    </div>
</div>
