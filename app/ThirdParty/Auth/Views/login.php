<div class="row" style="min-height: 70vh"> 
    
    <div class="col-md-4"></div>
    <div class="col-lg-4 text-center mt-5">
    <img src="<?= base_url() ?>/public/bilder/Idaflieg Logo_komplett.svg" alt="" height="120">
    <h1 class="m-4">Zachertool Login</h1>
    
    <?= view('Auth\Views\_notifications') ?>
    
    <form method="POST" action="<?= base_url('login'); ?>" accept-charset="UTF-8">
        <div class="form-floating">
            <input required type="text" id="floatingInput" class="form-control" name="username" value="<?= old('username') ?>" />
            <label for="floatingInput"><?= lang('Auth.username') ?></label>
        </div>
        <div class="form-floating">         
            <input required minlength="5" id="floatingPassword" class="form-control" type="password" name="password" value="" />
            <label for="floatingPassword"><?= lang('Auth.password') ?></label>
        </div>
        <p class="mt-3">
            <?= csrf_field() ?>
            <button class="w-100 btn btn-lg btn-primary" type="submit"><?= lang('Auth.login') ?></button>
        </p>

    </form>
    </div>
    <div class="col-md-4"></div>
</div>