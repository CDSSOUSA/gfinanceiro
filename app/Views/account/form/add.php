<?= $this->extend('layouts/default'); ?>
<?= $this->section('content');
//dd($erro);
?>
<div class="container-fluid">
    <div class="row">
        <!-- left column -->
        <div class="col-md-12">

            <?php
            if (session('success')) {
                $msgs['message'] = 'Operação realizada com sucesso!';
                $msgs['alert'] = 'success';
                $msgs['status'] = '<i class="icon fas fa-check"></i> Parabéns!';
            }
            session()->remove('success');
            if ($msgs['alert']) : ?>
                <h5 id="message" style="display:none"><?= $msgs['message']; ?></h5>
                <h5 id="alert" style="display:none"><?= $msgs['alert']; ?></h5>
                <h5 id="status" style="display:none"><?= $msgs['status']; ?></h5>
            <?php endif; ?>
            <!-- general form elements -->
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">:: <?= $title_page; ?></h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <?php echo form_open('/account/create', ['class' => '']) ?>
                <?= csrf_field() ?>
                <div class="card-body col-md-6">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Número :: </label>
                        <input type="text" name="numeric_account" class="form-control number_account" id="exampleInputEmail1" placeholder="Ex.: 99999-9" value="<?= old('numeric_account') ?>" autofocus>

                        <span class="badge badge-danger"><?= array_key_exists("numeric_account", $erro) === true ? $erro['numeric_account'] : ''; ?></span>
                    </div>
                    <div class="form-group">
                        <label>Agência Bancária :: </label>
                        <select class="form-control" name="bank">
                            <option value="">Selecione ...</option>
                            <?php
                            foreach ($bank as $nameBank) : ?>
                                <option value="<?= mb_strtoupper($nameBank); ?>" <?= set_select('bank', mb_strtoupper($nameBank), false) ?>><?= mb_strtoupper($nameBank); ?></option>
                            <?php endforeach; ?>
                        </select>
                        <span class="badge badge-danger"><?= array_key_exists("bank", $erro) === true ? $erro['bank'] : ''; ?></span>
                    </div>
                    <?= form_hidden('status', 'A'); ?>
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Salvar</button>

                </div>
                <?php form_close(); ?>
            </div>
            <!-- /.card -->

        </div>
        <!--/.col (left) -->

    </div>
</div>


<?= $this->endSection(); ?>