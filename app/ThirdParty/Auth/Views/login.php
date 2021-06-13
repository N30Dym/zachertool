<h1 class="text-center">Zachertool Log-In</h1>

<div class="text-center">
    <form method="POST" action="<?= base_url('login'); ?>" accept-charset="UTF-8">
        <p>
            <label><?= lang('Auth.username') ?></label><br />
            <input required type="text" name="username" value="<?= old('username') ?>" />
        </p>
        <p>
            <label><?= lang('Auth.password') ?></label><br />
            <input required minlength="5" type="password" name="password" value="" />
        </p>
        <p>
            <?= csrf_field() ?>
            <button type="submit"><?= lang('Auth.login') ?></button>
        </p>

    </form>
</div>