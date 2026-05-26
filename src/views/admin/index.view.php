<?php
?>

<h1>Admin</h1>
<div id="tabs"
     hx-get="/admin/users"
     hx-trigger="load"
     hx-target="#tabs"
     hx-swap="innerHTML"
     hx-boost="true"
></div>