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
                     <h5 id="status" style="display:none"><?= $msgs['status']; ?></h5>
                <?php endif; ?>
                <!-- general form elements -->
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">:: <?= $title_page; ?></h3>
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->
                    <?php echo form_open('/rubrica/create', ['class' => '']) ?>
                    <?= csrf_field() ?>
                    <div class="card-body col-md-6">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Descrição :: </label>
                            <input type="text" name="description" class="form-control" id="exampleInputEmail1" placeholder="Ex.: ÁGUA" value="<?= old('description') ?>" autofocus>

                            <span class="badge badge-danger"><?= array_key_exists("description", $erro) === true ? $erro['description'] : ''; ?></span>
                        </div>
                        
                        <?= form_hidden('status', 'A'); ?>
                    </div>
                    <!-- /.card-body -->

                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Salvar</button>
                        <button type="button" class="btn btn-success toastsDefaultSuccess" onclick="chamarToastSucess()">
                            Launch Success Toast
                        </button>
                    </div>
                    <?php form_close(); ?>
                </div>
                <!-- /.card -->

            </div>
            <!--/.col (left) -->

    </div>
</div>


<?= $this->endSection(); ?>