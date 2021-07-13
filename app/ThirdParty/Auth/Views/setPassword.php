<?= $this->extend($config->viewLayout) ?>
<?= $this->section('main') ?>

<h1>Setze das Admin Passwort beim ersten Benutzen der Seite</h1>

<?= view('Auth\Views\_notifications') ?>

<form method="POST" action="<?= base_url('setPassword'); ?>" accept-charset="UTF-8">
	<?= csrf_field() ?>
    <p>
        <label>Passwort für den Benutzer "admin" setzen:</label><br />
        <input required type="password" name="password" value="" />
    </p>
    <p>
        <label>Passwort wiederholen:</label><br />
        <input required type="password" name="password_confirm" value="" />
    </p>
    <p>
        <button type="submit">Passwort setzen</button>
    </p>    
</form>

<?= $this->endSection() ?>