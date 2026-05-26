<?php

use Core\Auth;
use Core\Session;

?>
<h1>Välkommen till min bankapp</h1>

<p><?= e(Auth::user()->name) ?? 'Gäst' ?></p>
<p><?= Auth::check() ? 'Inloggad' : 'Inte inloggad' ?></p>
<p><?= Auth::isAdmin() ? 'Är admin' : 'Är inte admin' ?></p>




