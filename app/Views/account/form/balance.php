<?= $this->extend('layouts/default'); ?>
<?= $this->section('content');
//dd($erro);
?>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">


            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">:: Saldo de todas as contas <?php echo nbsp(4);
                                                                        echo anchor('/account/add', '<i class="nav-icon fas fa-file"></i>' . nbsp(3) . 'Nova conta', ['class' => 'btn btn-dark text-right']); ?></h3>
                </div>

                <div class="card-body p-0">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th style="width: 10px">#</th>
                                <th>Número</th>
                                <th>Agência bancária</th>
                                <th class="text-left">Saldo</th>
                                <th>Status</th>

                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $count = 1;
                            $total = 0;
                            foreach ($accounts as $account) : ?>
                                <tr>
                                    <td><?= $count++; ?></td>
                                    <td><?= $account['numeric_account']; ?></td>
                                    <td><?= $account['bank']; ?></td>
                                    <td class="text-left <?= $account['balance'] > 0 ? 'text-green':'text-danger'?>"><?= convertCoin($account['balance']); ?></td>
                                    <td><?= convertStatus($account['status']); ?></td>

                                </tr>
                                <!-- Modal -->

                            <?php 
                            $total = $total + $account['balance'];
                        endforeach; ?>
                        </tbody>
                        <tfoot>
                            <tr class="text-bold">
                                <th colspan="3" class="text-right">Total :: </th>
                                <td class="text-left <?= $account['balance'] > 0 ? 'text-green':'text-danger'?>"><?= convertCoin($total); ?></td>                               

                            </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>