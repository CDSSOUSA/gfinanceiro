<?= $this->extend('layouts/default'); ?>
<?= $this->section('content');
//dd($erro);
?>
<div class="container-fluid">
    <div class="row">
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
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">:: Todas as rubrica <?php echo nbsp(4); echo anchor('/rubrica/add', '<i class="nav-icon fas fa-file"></i>'.nbsp(3).'Nova conta', ['class'=>'btn btn-dark text-right']);?></h3>
                </div>

                <div class="card-body p-0">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th style="width: 10px">#</th>
                                <th>Descrição</th>
                                <th>Status</th>
                                <th class="show992" style="width: auto">Ações</th>
                                <th class="show576" style="width: 40px;">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $count = 1;
                            foreach ($rubricas as $item) : ?>
                                <tr>
                                    <td><?= $count++; ?></td>
                                    <td><?= $item['description']; ?></td>
                                    <td><?= convertStatus($item['status']); ?></td>
                                    <td class="show992">
                                        <div class="btn-group">
                                            
                                            <?=anchor('/rubrica/edit/'.$item['id'],'<i class="nav-icon fas fa-pen"></i>'.nbsp(3).'Editar',['class'=>'btn btn-dark']);?>
                                            
                                            <a class="link-modal btn btn-dark" href="#" data-bs-toggle="modal" data-numeroconta ="<?=$item['description'];?>" data-idconta ="<?=$item['id'];?>" data-bs-target="#modal-danger" onclick="showModal()"><i class="nav-icon fas fa-trash"></i><?= nbsp(3); ?>Excluir</a>
                                        </div>
                                    </td>
                                    <td class="show576">
                                        <div class="dropdown dropstart text-end">
                                            <button type="button" class="btn btn-warning dropdown-toggle" data-bs-toggle="dropdown">
                                                <i class="nav-icon fas fa-ellipsis-h"></i>
                                            </button>
                                            <ul class="dropdown-menu">
                                                <li> <?=anchor('/rubrica/edit/'.$item['id'],'<i class="nav-icon fas fa-pen"></i>'.nbsp(3).'Editar',['class'=>'dropdown-item']);?></li>
                                                <div class="dropdown-divider"></div>
                                                <li><a class="dropdown-item link-modal" href="#" data-bs-toggle="modal" data-numeroconta ="<?=$item['description'];?>" data-idconta ="<?=$item['id'];?>" data-bs-target="#modal-danger" onclick="showModal()"><i class="nav-icon fas fa-trash"></i><?= nbsp(3); ?>Excluir</a></li>
                                            </ul>

                                        </div>
                                    </td>
                                </tr>
                                <!-- Modal -->

                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade " id="modal-danger" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content bg-danger">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">:: Excluir rubrica</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <?= form_open('/rubrica/delete'); ?>
            <div class="modal-body">

                <input type="hidden" name="_method" value="delete"/>
                <input type="hidden" name="idConta" id="conta" value="">
                Deseja excluir a rubrica :: <span class="badge bg-primary" id="contaNumero"></span>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-light" data-bs-dismiss="modal">Fechar</button>
                <button type="submit" class="btn btn-outline-light">Confirmar</button>
            </div>
            </form>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>

