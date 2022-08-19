<?php
use App\Controllers\Rubrica\Rubrica;

?>
<?= $this->extend('layouts/default'); ?>
<?= $this->section('content');
$rubrica = new Rubrica();

?>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <?php
            //dd(session('success'));
            if (session('success')) {
                $msgs['message'] = session('success')['msgs']['message'];
                $msgs['alert'] = 'success';
                $msgs['status'] = '<i class="icon fas fa-check"></i> Parabéns!';
            }
            session()->remove('success');
            if ($msgs['alert']) : ?>
                <div class="alert alert-<?= $msgs['alert'] ?> alert-dismissible alert-close">
                    <button type="button" class="close" data-bs-dismiss="alert" aria-hidden="true">×</button>
                    <h5><?= $msgs['status']; ?></h5>
                    <?= $msgs['message']; ?>
                </div>
            <?php endif; ?>
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">:: Todas as movimentações <?php echo nbsp(4);
                                                                        echo anchor('/movement/add', '<i class="nav-icon fas fa-file"></i>' . nbsp(3) . 'Nova', ['class' => 'btn btn-dark text-right']); ?></h3>
                </div>
                <div class="card-body p-2 text-center table-responsive">
                    <?php
                        $year2 = [];
                    for ($year = 2020; $year <= date('Y'); $year++) : 
                        if ($result !== null) : 
                            foreach ($result as $item) :
                                if ($year == date('Y', strtotime($item['date_mov']))) :
                                    $year2[] = $year; 
                                    break;
                                endif;
                            endforeach;
                        endif;
                        endfor;
                        //dd($year2);
                        
                        foreach($year2 as $yearNew):
                        ?>
                        
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr class="bg-black">
                                    <th colspan="6">Dados :: Ano <?= $yearNew ?></th>
                                </tr>
                            </thead>
                            <thead>
                                <tr>
                                    <th style="width: 20px">Data</th>
                                    <th class="text-left">Descrição</th>
                                    <th class="text-left">Origem</th>
                                    <th class="text-right">Receita</th>
                                    <th class="text-right">Despesa</th>
                                    <th class="text-center">Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $count = 1;
                                $totReceita = 0;
                                $totDespesa = 0;
                                $balancePrevious = 0;

                                    foreach ($result as $item) :
                                        if ($yearNew == date('Y', strtotime($item['date_mov']))) :
                                            if ($item['type_mov'] === 'R') {
                                                $totReceita += $item['value_mov'];
                                            } else {

                                                $totDespesa += $item['value_mov'];
                                            }
                                ?>
                                            <tr>
                                                <td><?= date('d/m/Y', strtotime($item['date_mov'])); ?></td>
                                                <td class="text-left"><?= $rubrica->getById($item['id_rubric'])['description']; ?></td>
                                                <td class="text-left"><?= $account->find($item['origem'])['bank']; ?></td>
                                                <td class="text-right text-green"><?= $item['type_mov'] === 'R' ? convertCoin($item['value_mov']) : '--'; ?></td>
                                                <td class="text-right text-danger"><?= $item['type_mov'] === 'D' ? convertCoin($item['value_mov']) : '--'; ?></td>
                                                <td class="text-center text-danger"><?= anchor('/movement/edit/' . $item['id'], '<i class="nav-icon fas fa-pen"></i>' . nbsp(3) . 'Editar', ['class' => 'btn btn-dark']); ?></td>
                                            </tr>
                                            <!-- Modal -->

                                <?php endif;
                                    endforeach;
                                //endif; ?>
                            </tbody>
                            <tfoot>
                                <tr class="text-bold">
                                    <th colspan="3">Totais :: </th>
                                    <td class="text-right text-green"><?= convertCoin($totReceita); ?></td>
                                    <td class="text-right text-danger"><?= convertCoin($totDespesa); ?></td>

                                </tr>

                                <?php
                                session()->remove('date'); ?>
                            </tfoot>
                        </table>
                        <br>

                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>