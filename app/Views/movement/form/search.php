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
                <?= form_hidden('typeSearch',$type) ?>
                <?= form_hidden('field',$name) ?>
                <div class="card-body col-md-6">
                   <?=fieldSearch( $data ,  $erro);?>
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                <?=buttomGroup('Buscar',);?>
                    
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