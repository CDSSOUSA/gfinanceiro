<?=$this->extend('layouts/default_account'); ?>
<?= $this->section('content'); ?>
<div class="login-box">
        <div class="card card-outline card-primary">
            <div class="card-header text-center">
                <a href="../../index2.html" class="h1"><b>Admin</b>LTE</a>
            </div>
            <div class="card-body">
                <p class="login-box-msg">Faça login para iniciar sua sessão</p>
                <div class="mb-3 text-center">
                    <span class="invalid-feedback"><?= $erroLogin !== [] ? $erroLogin['msg'] : ''; ?></span>                    
                </div>
               
                <?=form_open('/login');?>
                <?= csrf_field() ?>
                    <div class="input-group mb-3">
                        <input type="text" name="login" class="form-control" placeholder="Login" autofocus = "true" value="<?= set_value('login');?>">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-user"></span>
                            </div>
                        </div>
                        <span class="invalid-feedback"><?=  $erro !== [] ? $erro->getError('login') : ''; ?></span>
                    </div>
                    <div class="input-group mb-3">
                        <input type="password" name="passwrd" class="form-control" placeholder="Password" value="<?= set_value('passwrd');?>">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                        <span class="invalid-feedback"><?=  $erro !== [] ? $erro->getError('passwrd') : ''; ?></span>
                    </div>
                    <div class="row">
                        <div class="col-8">
                            <div class="icheck-primary">
                                <input type="checkbox" id="remember">
                                <label for="remember">
                                    Lembrar-me
                                </label>
                            </div>
                        </div>

                        <div class="col-4">
                            <button type="submit" class="btn btn-primary btn-block">Entrar</button>
                        </div>

                    </div>
                <?=form_close();
                session()->remove('erroLogin');
                session()->remove('erro');?>               

                <p class="mb-1">
                    <?=anchor('/user/forgot','Recuperar senha');?>
                    
                </p>
                <p class="mb-0">
                    <?=anchor('/user/add','Criar conta',['text-center']);?>
                    
                </p>
            </div>
        </div>
</div>

<?= $this->endSection(); ?>
   <!-- jQuery -->