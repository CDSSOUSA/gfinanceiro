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

            <?php
            endif; ?>
            <!-- general form elements -->
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">:: <?= $title_page; ?></h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <?php echo form_open('/movement/create', ['class' => '', 'id' => 'form']) ?>
                <?= csrf_field() ?>
                <div class="card-body col-md-6">
                    <div class="form-group">
                        <label for="">Tipo :: </label><br>

                        <div class="icheck-success icheck-inline">
                            <input name="type_mov" type="radio" id="receita" value="R" <?php echo set_radio('type_mov', 'R', false); ?> />
                            <label for="receita">RECEITA</label>
                        </div>
                        <div class="icheck-danger icheck-inline">
                            <input name="type_mov" type="radio" id="despesa" value="D" <?php echo set_radio('type_mov', 'D', false); ?> />
                            <label for="despesa">DESPESA</label>
                        </div>
                        <br>
                        <span class="invalid-feedback"><?= array_key_exists("type_mov", $erro) === true ? $erro['type_mov'] : ''; ?></span>
                    </div>
                    <div class="form-group">
                        <label>Rubrica :: </label>
                        <div class="input-group">
                            <select class="form-control" name="id_rubric">
                                <option value="">Selecione ...</option>
                                <?php
                                foreach ($rubrics as $item) : ?>
                                    <option value="<?= $item['id']; ?>" <?= set_select('id_rubric', $item['id'], false) ?>><?= mb_strtoupper($item['description']); ?></option>
                                <?php endforeach; ?>
                            </select>
                            <?= anchor('/rubrica/add', '...', ['class' => 'btn btn btn-outline-secondary']); ?>
                        </div>

                        <span class="invalid-feedback"><?= array_key_exists("id_rubric", $erro) === true ? $erro['id_rubric'] : '';
                                                            ?></span>
                    </div>
                    <div class="form-group">
                        <label>Data :: </label>
                        <div class="input-group">
                            <input type="text" id="datepicker" name="date_mov" class="form-control date" value="<?= set_value('date_mov',date('d/m/Y'),true); ?>">
                            <div class="input-group-append">
                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                            </div>
                        </div>

                        <span class="invalid-feedback"><?= array_key_exists("date_mov", $erro) === true ? $erro['date_mov'] : ''; ?></span>
                    </div>

                    <div class="form-group">
                        <label for="exampleInputEmail1">Valor (R$) :: </label>
                        <input type="text" name="value_mov" class="form-control moeda" id="exampleInputEmail1" placeholder="Ex.: 0,00" value="<?= old('value_mov') ?>">

                        <span class="invalid-feedback"><?= array_key_exists("value_mov", $erro) === true ? $erro['value_mov'] : ''; ?></span>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Origem :: </label>
                        <select class="form-control" name="origin">
                            <option value="">Selecione ...</option>
                            <?php
                            foreach ($bank as $nameBank) : ?>
                                <option value="<?= ($nameBank['id']); ?>" <?= set_select('origin', ($nameBank['id']), false) ?>><?= ($nameBank['bank']); ?> - <?= ($nameBank['numeric_account']); ?> </option>
                            <?php endforeach; ?>
                        </select>
                        <span class="invalid-feedback"><?= array_key_exists("origin", $erro) === true ? $erro['origin'] : ''; ?></span>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Observação :: </label>
                        <input type="text" name="observation" class="form-control" id="exampleInputEmail1" placeholder="Ref.: " value="<?= old('observation') ?>">

                        <span class="invalid-feedback"><?= array_key_exists("observation", $erro) === true ? $erro['observation'] : ''; ?></span>
                    </div>

                    <?= form_hidden('status', 'A'); ?>
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                    <?=buttomGroup();?>
                </div>
                <?php form_close(); ?>
            </div>
            <!-- /.card -->

        </div>
        <!--/.col (left) -->

    </div>
</div>

<?= $this->endSection(); ?>