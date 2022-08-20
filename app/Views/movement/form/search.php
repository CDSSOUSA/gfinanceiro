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
            //dd($erro);
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
                <?php echo form_open('/movement/result', ['class' => '']) ?>
                <?= csrf_field() ?>
                <div class="card-body col-md-6">
                    <div class="form-group">
                        <label>Rubrica :: </label>

                        <select class="form-control" name="id_rubric">
                            <option value="">Selecione ...</option>
                            <?php
                            foreach ($rubrics as $item) : ?>
                                <option value="<?= $item['id']; ?>" <?= set_select('id_rubric', $item['id'], false) ?>><?= mb_strtoupper($item['description']); ?></option>
                            <?php endforeach; ?>
                        </select>
                        <?php
                        if ($erro !== []) : ?>
                            <span class="badge badge-<?= $erro['alert']; ?>"><?= $erro['msg']; ?></span>
                        <?php endif; ?>

                    </div>

                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Buscar</button>
                    
                </div>
                <?php form_close();
                session()->remove('erro');

                ?>
            </div>
            <!-- /.card -->

        </div>
        <!--/.col (left) -->

    </div>
</div>


<?= $this->endSection(); ?>