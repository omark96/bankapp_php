<form action="/session" method="POST" class="loginForm">
    <div>
        <label for="cardNumber">Kortnummer</label>
        <input id="cardNumber"
               type="text"
               name="cardNumber"
               required>
        <?php if (isset($errors['cardNumber'])): ?>
            <p><?= $errors['cardNumber'] ?></p>
        <?php endif ?>
    </div>
    <div>
        <label for="pinCode">PIN-kod</label>
        <input id="pinCode"
               type="password"
               name="pinCode"
               required>
        <?php if (isset($errors['pinCode'])): ?>
            <p><?= $errors['pinCode'] ?></p>
        <?php endif ?>
    </div>
    <button type="submit">Log in</button>
</form>
