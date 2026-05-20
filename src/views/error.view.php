<?php
/** @var int $code */

use Core\Response;

?>

<?php if($code === Response::NOT_FOUND): ?>
<h2>Kunde inte hitta den sidan.</h2>
<?php elseif ($code === Response::FORBIDDEN): ?>
<h2>Du har inte tillgång till den här sidan</h2>
<?php else: ?>
<h2>Något gick fel.</h2>
<?php endif ?>

