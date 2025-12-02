<?php
$title = 'Proses Menu';
include APPPATH . 'Views/admin/partials/head.php';
?>

<style>
    html,
    body {
        margin: 0;
        padding: 0;
        max-width: 100%;
        overflow-x: hidden;
    }

    .order-card {
        max-width: 1200px;
        margin: 28px auto;
        background: #fff;
        border-radius: 14px;
        box-shadow: 0 12px 30px rgba(10, 25, 40, 0.06);
        padding: 20px;
        box-sizing: border-box;
    }

    .order-card h1 {
        margin: 0 0 12px;
        color: #0b2130;
        font-size: 1.25rem;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 10px;
    }

    thead th {
        text-align: left;
        padding: 10px;
        border-bottom: 1px solid #eee;
        font-weight: 700;
        color: #0b2130;
    }

    tbody td {
        padding: 10px;
        border-bottom: 1px solid #f4f3f4;
        color: #0b2130;
        vertical-align: middle;
    }

    .badge {
        display: inline-block;
        padding: 4px 10px;
        border-radius: 999px;
        font-size: .8rem;
        font-weight: 600;
        background: #fff;
        border: 1px solid #e5e7eb;
    }

    .badge.wait {
        background: #fff7e5;
        border-color: #facc15;
        color: #92400e;
    }

    .badge.proc {
        background: #e0f2fe;
        border-color: #38bdf8;
        color: #0369a1;
    }

    .badge.done {
        background: #dcfce7;
        border-color: #22c55e;
        color: #166534;
    }

    .badge.cancel {
        background: #fee2e2;
        border-color: #f87171;
        color: #991b1b;
    }

    .btn-small {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 6px 10px;
        border-radius: 10px;
        border: 1px solid #e5e7eb;
        background: #fff;
        color: #111;
        text-decoration: none;
        font-size: .9rem;
        font-weight: 600;
    }

    .btn-small.primary {
        background: #ff4766;
        color: #fff;
        border-color: transparent;
        box-shadow: 0 8px 20px rgba(224, 63, 93, .12);
    }

    .alert {
        padding: 10px 12px;
        border-radius: 10px;
        margin-bottom: 10px;
        font-weight: 600;
    }

    .alert-success {
        background: #ecfdf3;
        border: 1px solid #bbf7d0;
        color: #166534;
    }

    .alert-error {
        background: #fef2f2;
        border: 1px solid #fecaca;
        color: #991b1b;
    }
</style>

<div class="order-card">
    <h1>Proses Menu / Pesanan</h1>

    <?php if (session('success')): ?>
        <div class="alert alert-success"><?= esc(session('success')); ?></div>
    <?php endif; ?>
    <?php if (session('error')): ?>
        <div class="alert alert-error"><?= esc(session('error')); ?></div>
    <?php endif; ?>

    <table>
        <thead>
            <tr>
                <th>Kode</th>
                <th>Tanggal</th>
                <th>Pemesan</th>
                <th>Total</th>
                <th>Status</th>
                <th>Aksi</th>
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
                ?>

                <?php foreach ($orders as $o): ?>
                    <?php
                    $st     = $o['status'] ?? 'pending';
                    $label  = $statusLabelMap[$st]  ?? ucfirst($st);
                    $clsKey = $statusClassMap[$st]  ?? 'wait';
                    ?>
                    <tr>
                        <td>#<?= esc($o['code']); ?></td>
                        <td><?= esc(date('d M Y H:i', strtotime($o['created_at']))); ?></td>
                        <td><?= esc($o['customer_name'] ?? '-'); ?></td>
                        <td>Rp <?= number_format((int)$o['total_amount'], 0, ',', '.'); ?></td>
                        <td>
                            <span class="badge <?= esc($clsKey); ?>">
                                <?= esc($label); ?>
                            </span>
                        </td>
                        <td style="white-space:nowrap">
                            <a href="<?= base_url('admin/orders/' . $o['id']); ?>" class="btn-small primary">
                                Lihat Detail
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>

            <?php else: ?>
                <tr>
                    <td colspan="6" style="text-align:center;color:#6b7280;padding:16px;">
                        Belum ada pesanan.
                    </td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

</body>

</html>