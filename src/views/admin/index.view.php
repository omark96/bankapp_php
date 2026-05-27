<?php
?>

<div id="tabs"
     hx-get="/admin/users"
     hx-trigger="load, refreshTabs from:body"
     hx-target="#tabs"
     hx-swap="innerHTML"
></div>