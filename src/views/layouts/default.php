<?php /** @var string $slot */

use Core\Auth; ?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="/css/style.css">
    <script src="https://cdn.jsdelivr.net/npm/htmx.org@2.0.10/dist/htmx.min.js"
            integrity="sha384-H5SrcfygHmAuTDZphMHqBJLc3FhssKjG7w/CeCpFReSfwBWDTKpkzPP8c+cLsK+V"
            crossorigin="anonymous"></script>
    <title>Bankapp</title>
</head>
<body>
<header class="header">
    <a href="/"><h2>Olles Bank</h2></a>
    <nav class="navbar">
        <ul class="navbar__links">
            <?php if (Auth::check()): ?>
                <li><a href="/accounts" class="navbar__link">Konton</a></li>
            <?php endif ?>
            <?php if (Auth::isAdmin()): ?>
                <li><a href="/admin" class="navbar__link">Admin</a></li>
            <?php endif ?>
        </ul>
        <?php if (Auth::check()): ?>
            <form action="/session" method="POST">
                <?= csrf_field() ?>
                <input type="hidden" name="_method" value="DELETE">
                <button type="submit" class="navbar__link">
                    Logga ut
                </button>
            </form>
        <?php else : ?>
            <a href="/session/create" class="navbar__link">Logga in</a>
        <?php endif ?>
    </nav>
</header>
<main>
    <?= $slot ?>
</main>
<footer class="footer">
    <p>Copyright eller något sånt liksom</p>
</footer>
</body>
</html>