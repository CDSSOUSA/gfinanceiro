<?= $this->extend('layouts/default_account'); ?>
<?= $this->section('content'); ?>
<div class="register-box">
    <div class="card card-outline card-primary">
        <div class="card-header text-center">
            <a href="../../index2.html" class="h1"><b>Admin</b>LTE</a>
        </div>
        <div class="card-body">
            <p class="login-box-msg">Register a new membership</p>
            <?= form_open('/login'); ?>
            <?= csrf_field() ?>
            <div class="input-group mb-3">
                <input type="email" class="form-control" placeholder="Email">
                <div class="input-group-append">
                    <div class="input-group-text">
                        <span class="fas fa-envelope"></span>
                    </div>
                </div>
            </div>
            <div class="input-group mb-3">
                <input type="text" name="login" class="form-control" placeholder="Login" autofocus="true" value="<?= set_value('login'); ?>">
                <div class="input-group-append">
                    <div class="input-group-text">
                        <span class="fas fa-user"></span>
                    </div>
                </div>
                <span class="invalid-feedback"><?= $erro !== [] ? $erro->getError('login') : ''; ?></span>
            </div>
            <div class="input-group mb-3">
                <input type="password" name="passwrd" class="form-control" placeholder="Password" value="<?= set_value('passwrd'); ?>">
                <div class="input-group-append">
                    <div class="input-group-text">
                        <span class="fas fa-lock"></span>
                    </div>
                </div>
                <span class="invalid-feedback"><?= $erro !== [] ? $erro->getError('passwrd') : ''; ?></span>
            </div>
            <div class="input-group mb-3">
                <input type="password" class="form-control" placeholder="Retype password">
                <div class="input-group-append">
                    <div class="input-group-text">
                        <span class="fas fa-lock"></span>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-8">
                    <div class="icheck-primary">
                        <input type="checkbox" id="agreeTerms" name="terms" value="agree">
                        <label for="agreeTerms">
                            I agree to the <a href="#">terms</a>
                        </label>
                    </div>
                </div>

                <div class="col-4">
                    <button type="submit" class="btn btn-primary btn-block">Register</button>
                </div>

            </div>
            <?= form_close();
            session()->remove('erroLogin');
            session()->remove('erro'); ?>
            
            <?= anchor('/', 'Já possuo uma conta', ['class' => 'text-center']); ?>

        </div>

    </div>
</div>
<?= $this->endSection(); ?>
<!-- jQuery -->