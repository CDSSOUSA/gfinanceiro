<?php

use App\Controllers\Rubrica\Rubrica;
use CodeIgniter\HTTP\URI;

?>
<?= $this->extend('layouts/default'); ?>
<?= $this->section('content');
$rubrica = new Rubrica();
$uri = new URI(current_url(true));
$month = $uri->getSegment(5);
$year = $uri->getSegment(6);
$day = $uri->getSegment(7);
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

                <div class="card-body p-2 text-center">

                    <div class="font-size-10">
                        <?php
                        $j = 1;
                        if ($year === getenv('YEAR_START')) {
                            $j = 6;
                        } else {
                            echo anchor('movement/resume/12/' . ($year - 1), '<i class="fa fa-chevron-left"></i>', ['class' => 'btn btn-dark page-item']);
                        }
                        $month = 0;
                        for ($i = $j; ($i <= 12); $i++) :
                            $buttonStyle = 'btn btn-dark';
                        ?>
                            <?php if (session('date') === convertToMonthExtens($i) . '/' . $year) :
                                $month = $i;
                                $buttonStyle = 'btn btn-success';
                            endif ?>
                            <?php

                            echo anchor('/movement/resume/' . $i . '/' . $year, '<span>' . convertToMonthExtens($i) . '</span><br>
                            ' . ($year) . '', ['class' => $buttonStyle . ' font-size-12']);

                            ?>

                            <?php if ($i >= date('m') && $year >= date('Y')) {
                                break;
                            } ?>


                        <?php endfor; ?>
                        <?php if ($year < date('Y')) :
                            echo anchor('movement/resume/1/' . ($year + 1), ' <i class="fa fa-chevron-right"></i>', ['class' => 'btn btn-dark']);
                        endif;
                        ?>
                    </div>
                </div>

                <div class="card-body p-2 text-center">

                    <div class="font-size-10">

                        <?php   
                      $dayOut = defineDayEnd($month,$year);

                      $m = 1;
                      if ($year == getenv('YEAR_START') && $month == getenv('MONTH_START')) {
                          $m = 30;
                      } 

                        for ($days = $m; $days <= $dayOut; $days++) {
                            $buttonStyle = 'btn btn-dark';
                            if (session('date') . '/' . $day === convertToMonthExtens($month) . '/' . $year .'/' . $days) :
                                $buttonStyle = 'btn btn-success';
                            endif;
                            echo anchor('/movement/resume/' . $month  . '/' . $year.'/'.$days, '<span>' . ($days) . '</span>', ['class' => $buttonStyle . ' font-size-12']);
                            if ($days >= date('d') && $month >= date('m') && $year >= date('Y')) {
                                break;
                            }

                        } ?>

                     
                    </div>
                </div>
                <div class="card-body p-2 text-center">
                    <table class="table table-striped table-hover">
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

                            if ($resume !== null) :
                                foreach ($resume as $item) :

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
                                        <td class="text-right text-green"><?= $item['type_mov'] === 'R' ? convertCoin($item['value_mov']) : ''; ?></td>
                                        <td class="text-right text-danger"><?= $item['type_mov'] === 'D' ? convertCoin($item['value_mov']) : ''; ?></td>
                                        <td class="text-center text-danger"><?= anchor('/movement/edit/' . $item['id'], '<i class="nav-icon fas fa-pen"></i>' . nbsp(3) . 'Editar', ['class' => 'btn btn-dark']); ?></td>
                                    </tr>
                                    <!-- Modal -->

                            <?php endforeach;
                            endif; ?>
                        </tbody>
                        <tfoot>
                            <tr class="text-bold">
                                <th colspan="3">Totais :: </th>
                                <td class="text-right text-green"><?= convertCoin($totReceita); ?></td>
                                <td class="text-right text-danger"><?= convertCoin($totDespesa); ?></td>

                            </tr>
                            <tr class="text-bold">
                                <th colspan="4">Saldo mês :: </th>
                                <?php
                                $balance = ($totReceita + $totDespesa);
                                $colorText = $balance >= 0 ? 'text-green' : 'text-danger'; ?>
                                <td class="text-right <?= $colorText; ?>"><?= convertCoin($balance) ?></td>

                            </tr>
                            <?php if ($balancePrevius) : ?>
                                <tr class="text-bold">
                                    <th colspan="4">Acumulado :: </th>
                                    <?php
                                    // dd($balancePrevius['value_mov']);
                                    $balancePre = ($balancePrevius['value_mov']);

                                    $colorText = $balancePre >= 0 ? 'text-green' : 'text-danger'; ?>
                                    <td class="text-right <?= $colorText; ?>"><?= convertCoin($balancePre) ?></td>

                                </tr>
                            <?php endif;
                            session()->remove('date'); 
                            ?>
                        </tfoot>
                    </table>

                </div>
            </div>
        </div>
    </div>
</div>
<script src="<?= base_url(); ?>/assets/plugins/chart.js/Chart.min.js"></script>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-6">
            <div class="card card-success">
                <div class="card-header">
                    <h3 class="card-title">Stacked Bar Chart</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                        <button type="button" class="btn btn-tool" data-card-widget="remove">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="chart">
                        <div class="chartjs-size-monitor">
                            <div class="chartjs-size-monitor-expand">
                                <div class=""></div>
                            </div>
                            <div class="chartjs-size-monitor-shrink">
                                <div class=""></div>
                            </div>
                        </div>
                        <canvas id="myChart" width="400" height="400"></canvas>
                    </div>
                </div>

            </div>

        </div>
    </div>
</div>
<script>
    // unica diferença é que você receberá o json dinamicamente
    // valor que chegará da requisição            
    let json = JSON.parse('{ "RECEITA": <?= $totReceita ?> , "DESPESA":<?= -$totDespesa; ?>}')

    // cria uma array para nomes e valore
    let nomes = [];
    let valores = [];

    // percorre o json
    for (let i in json) {
        // adiciona na array nomes a key do campo do json
        nomes.push(i);
        // adiciona na array de valore o value do campo do json
        valores.push(json[i]);
    }

    var ctx = document.getElementById('myChart').getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'bar',
        data: {
            //labels são cada uma das barrinhas. Basta adicionar a array abaixo:
            labels: nomes,
            datasets: [{
                label: '# of Votes',
                //data serve para adicionar o valor de cada barrinha. Basta adicionar a array abaixo:
                data: valores,
                backgroundColor: [
                    'rgba(75, 192, 192, 0.2)',
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(255, 206, 86, 0.2)',
                    'rgba(153, 102, 255, 0.2)',
                    'rgba(255, 159, 64, 0.2)'
                ],
                borderColor: [
                    'rgba(75, 192, 192, 1)',
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(153, 102, 255, 1)',
                    'rgba(255, 159, 64, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true
                    }
                }]
            },

        }
    });
</script>

<?= $this->endSection(); ?>