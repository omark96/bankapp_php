<?php /** @var array $accounts */ ?>
<div class="accounts-list">
    <?php foreach ($accounts as $account) : ?>
        <?php component('accountCard', [
            'account' => $account
        ]);
        ?>
    <?php endforeach; ?>
</div>
