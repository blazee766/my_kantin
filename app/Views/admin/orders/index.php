<?php
$title = 'Proses Menu';
include APPPATH . 'Views/admin/partials/head.php';
?>

<style>
    .badge-wait {
        background-color: #f6c23e;
        color: #fff;
    }

    .badge-proc {
        background-color: #4e73df;
        color: #fff;
    }

    .badge-done {
        background-color: #1cc88a;
        color: #fff;
    }

    .badge-cancel {
        background-color: #e74a3b;
        color: #fff;
    }

    .badge-pay-unpaid {
        background-color: #f6c23e;
        color: #fff;
        border-radius: 999px;
        padding: 4px 10px;
        font-size: 0.8rem;
        font-weight: 600;
    }

    .badge-pay-paid {
        background-color: #1cc88a;
        color: #fff;
        border-radius: 999px;
        padding: 4px 10px;
        font-size: 0.8rem;
        font-weight: 600;
    }

    .badge-pay-failed {
        background-color: #e74a3b;
        color: #fff;
        border-radius: 999px;
        padding: 4px 10px;
        font-size: 0.8rem;
        font-weight: 600;
    }
</style>

<h1 class="h3 mb-4 text-gray-800">Proses Menu / Pesanan</h1>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Daftar Pesanan</h6>
    </div>
    <div class="card-body">

        <?php if (session('success')): ?>
            <div class="alert alert-success" role="alert">
                <?= esc(session('success')); ?>
            </div>
        <?php endif; ?>
        <?php if (session('error')): ?>
            <div class="alert alert-danger" role="alert">
                <?= esc(session('error')); ?>
            </div>
        <?php endif; ?>

        <div class="table-responsive">
            <table class="table table-bordered" width="100%" cellspacing="0">
                <thead class="thead-light">
                    <tr>
                        <th>Kode</th>
                        <th>Tanggal</th>
                        <th>Pemesan</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Pembayaran</th>
                        <th style="width: 140px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($orders)): ?>
                        <?php
                        $statusLabelMap = [
                            'pending'    => 'Menunggu',
                            'menunggu'   => 'Menunggu',
                            'processing' => 'Diproses',
                            'diproses'   => 'Diproses',
                            'completed'  => 'Selesai',
                            'selesai'    => 'Selesai',
                            'canceled'   => 'Batal',
                            'batal'      => 'Batal',
                        ];

                        $statusClassMap = [
                            'pending'    => 'badge-wait',
                            'menunggu'   => 'badge-wait',
                            'processing' => 'badge-proc',
                            'diproses'   => 'badge-proc',
                            'completed'  => 'badge-done',
                            'selesai'    => 'badge-done',
                            'canceled'   => 'badge-cancel',
                            'batal'      => 'badge-cancel',
                        ];

                        $payLabelMap = [
                            'unpaid' => 'Belum bayar',
                            'paid'   => 'Lunas',
                            'failed' => 'Gagal / Kadaluarsa',
                        ];

                        $payClassMap = [
                            'unpaid' => 'badge-pay-unpaid',
                            'paid'   => 'badge-pay-paid',
                            'failed' => 'badge-pay-failed',
                        ];
                        ?>

                        <?php foreach ($orders as $o): ?>
                            <?php
                            $st     = $o['status'] ?? 'pending';
                            $label  = $statusLabelMap[$st]  ?? ucfirst($st);
                            $clsKey = $statusClassMap[$st] ?? 'badge-wait';

                            $payStatus = $o['payment_status'] ?? 'unpaid';
                            $payLabel  = $payLabelMap[$payStatus] ?? 'Belum dibayar';
                            $payClass  = $payClassMap[$payStatus] ?? 'badge-pay-unpaid';
                            ?>
                            <tr>
                                <td>#<?= esc($o['code']); ?></td>
                                <td><?= esc(date('d M Y H:i', strtotime($o['created_at']))); ?></td>
                                <td><?= esc($o['customer_name'] ?? '-'); ?></td>
                                <td>Rp <?= number_format((int)$o['total_amount'], 0, ',', '.'); ?></td>
                                <td>
                                    <span class="badge badge-pill <?= esc($clsKey); ?>">
                                        <?= esc($label); ?>
                                    </span>
                                </td>
                                <td>
                                    <span class="<?= esc($payClass); ?>">
                                        <?= esc($payLabel); ?>
                                    </span>
                                </td>
                                <td>
                                    <a href="<?= base_url('admin/orders/' . $o['id']); ?>"
                                        class="btn btn-sm btn-primary">
                                        Lihat Detail
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>

                    <?php else: ?>
                        <tr>
                            <td colspan="7" class="text-center text-muted py-4">
                                Belum ada pesanan.
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>

            </table>
        </div>

    </div>
</div>
<?php include APPPATH . 'Views/admin/partials/foot.php'; ?>