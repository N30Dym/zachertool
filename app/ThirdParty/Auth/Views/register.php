<?= $this->extend($config->viewLayout) ?>
<?= $this->section('main') ?>

<h1><?= lang('Auth.registration') ?></h1>

<?= view('Auth\Views\_notifications') ?>

<form method="POST" action="<?= route_to(base_url('register')); ?>" accept-charset="UTF-8"
	onsubmit="registerButton.disabled = true; return true;">
	<?= csrf_field() ?>
	<p>
	    <label><?= lang('Auth.name') ?> (optional)</label><br />
	    <input minlength="3" type="text" name="name" value="<?= old('name') ?>" />
	</p>
	<p>
	    <label><?= lang('Auth.username') ?></label><br /> <!-- ursprünglich 'Auth.email' -->
	    <input required type="text" name="username" value="<?= old('username') ?>" /> <!-- username war ursprünglich email und type war email -->
	</p>
	<p>
	    <label><?= lang('Auth.password') ?></label><br />
	    <input required minlength="5" type="password" name="password" value="" />
	</p>
	<p>
	    <label><?= lang('Auth.passwordAgain') ?></label><br />
	    <input required minlength="5" type="password" name="password_confirm" value="" />
	</p>
        <p>
	    <label><?= lang('Auth.memberStatus') ?></label><br />
	    <select class="form-select" name="memberstatus" value="<?= old('memberstatus') ?>" />
                <option></option>
                <?php foreach($mitgliedsStatusArray as $mitgliedsStatus) : ?>
                    <option value="<?= $mitgliedsStatus['id'] ?>"><?= $mitgliedsStatus['statusBezeichnung'] ?></option>
                <?php endforeach ?>
            </select>
	</p>
	<p>
	    <button name="registerButton" type="submit"><?= lang('Auth.register') ?></button>
	</p>
	<!--<p>
		<a href="<?= base_url('login'); ?>" class="float-right"><?= lang('Auth.alreadyRegistered') ?></a>
	</p>-->
</form>

<?= $this->endSection() ?>