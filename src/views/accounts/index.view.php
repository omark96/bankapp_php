<?php /** @var array $accounts */ ?>

<?php foreach ($accounts as $account) : ?>
    <?php component('accountCard', [
        'account' => $account
    ]);
    ?>
<?php endforeach; ?>

