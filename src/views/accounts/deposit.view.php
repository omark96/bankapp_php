<?php
/** @var int $accountId */
?>

<form hx-post="/accounts/<?= e($accountId) ?>/deposit" hx-target="this" hx-swap="outerHTML">
    <input type="text" name="amount">
    <button type="submit">Sätt in</button>
</form>
