<?php
?>

<div class="tab-list">
    <button hx-get="/admin/users" class="tab-list__tab selected">
        Användare
    </button>
    <button hx-get="/admin/accounts" class="tab-list__tab">
        Konton
    </button>
    <button hx-get="/admin/transactions" class="tab-list__tab">
        Transaktioner
    </button>
</div>

<div id="tab-content" class="tab-content">
    <div id="userTable"
         hx-get="/admin/users/table"
         hx-trigger="load"
         hx-target="this"
         hx-swap="innerHTML">
    </div>
</div>
