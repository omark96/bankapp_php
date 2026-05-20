<?php
?>

<form action="/session" method="POST">
    <div>
        <label for="cardNumber">Kortnummer</label>
        <input id="cardNumber"
               type="text"
               name="cardNumber"
               required>
    </div>
    <div>
        <label for="pinCode">PIN-kod</label>
        <input id="pinCode"
               type="password"
               name="pinCode"
               required>
    </div>
</form>
