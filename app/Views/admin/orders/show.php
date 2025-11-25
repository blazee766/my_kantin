<?php
$title = 'Detail Pesanan';
include APPPATH . 'Views/admin/partials/head.php';
?>

<style>
    .page-wrap {
        max-width: 1200px;
        margin: 24px auto 32px;
        padding: 0 4px;
    }

    .card {
        background: #fff;
        border-radius: 18px;
        box-shadow: 0 12px 30px rgba(10, 25, 40, .06);
        padding: 18px 20px;
        margin-bottom: 18px;
    }

    .card h2 {
        margin: 0 0 6px;
        color: #ff4766;
        font-size: 1.4rem;
    }

    .muted {
        color: #6b7280;
        font-size: .95rem;
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

    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 8px;
    }

    thead th,
    tbody td {
        padding: 10px 8px;
        border-bottom: 1px solid #f4f3f4;
        text-align: left;
    }

    .btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 8px 12px;
        border-radius: 12px;
        border: 1px solid #e5e7eb;
        background: #fff;
        color: #111;
        text-decoration: none;
        font-weight: 600;
        font-size: .9rem;
        cursor: pointer;
    }

    .btn-primary {
        background: #ff4766;
        color: #fff;
        border-color: transparent;
        box-shadow: 0 8px 20px rgba(224, 63, 93, .12);
    }

    .btn-danger {
        background: #ff4d4f;
        color: #fff;
        border-color: transparent;
    }

    .btn-ghost {
        background: #fff;
        border-color: #e5e7eb;
    }

    .btn+.btn {
        margin-left: 6px;
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

    @media(max-width:640px) {
        .card {
            padding: 14px 12px;
        }

        table {
            font-size: .9rem;
        }
    }
</style>

<div class="page-wrap">

    <?php if (session('success')): ?>
        <div class="alert alert-success"><?= esc(session('success')); ?></div>
    <?php endif; ?>
    <?php if (session('error')): ?>
        <div class="alert alert-error"><?= esc(session('error')); ?></div>
    <?php endif; ?>

    <?php
    $status = $order['status'] ?? 'pending';

    $labelMap = [
        'pending'    => 'Menunggu',
        'processing' => 'Diproses',
        'completed'  => 'Selesai',
        'canceled'   => 'Batal',
    ];

    $badgeMap = [
        'pending'    => 'badge wait',
        'processing' => 'badge proc',
        'completed'  => 'badge done',
        'canceled'   => 'badge cancel',
    ];

    $label      = $labelMap[$status] ?? ucfirst($status);
    $badgeClass = $badgeMap[$status] ?? 'badge';
    ?>
    Status:
    <span class="<?= esc($badgeClass); ?>"><?= esc($label); ?></span>

    <div class="card">
        <h2>Detail Pesanan #<?= esc($order['code']); ?></h2>
        <p class="muted">
            Tanggal: <?= esc(date('d M Y H:i', strtotime($order['created_at']))); ?><br>
            Total: <strong>Rp <?= number_format((int)$order['total_amount'], 0, ',', '.'); ?></strong><br>
            Pemesan: <?= esc($order['customer_name'] ?? '-'); ?><br>
            Lokasi: <?= esc(($order['building'] ?? '-') . ' ' . ($order['room'] ?? '')); ?><br>
            Status:
            <span class="badge <?= $badgeClass; ?>"><?= $label; ?></span>
        </p>

        <form action="<?= base_url('admin/orders/' . $order['id'] . '/status'); ?>" method="post" style="margin-top:12px;">
            <?= csrf_field(); ?>

            <button type="submit" name="status" value="pending" class="btn status-btn">
                Menunggu
            </button>

            <button type="submit" name="status" value="processing" class="btn status-btn">
                Diproses
            </button>

            <button type="submit" name="status" value="completed" class="btn status-btn">
                Selesai
            </button>

            <button type="submit" name="status" value="canceled" class="btn status-btn btn-danger">
                Batal
            </button>
        </form>


    </div>

    <div class="card">
        <h2 style="margin-bottom:8px;">Item</h2>

        <table>
            <thead>
                <tr>
                    <th>Menu</th>
                    <th>Qty</th>
                    <th>Harga</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($items as $it): ?>
                    <tr>
                        <td><?= esc($it['name']); ?></td>
                        <td><?= (int)$it['qty']; ?></td>
                        <td>Rp <?= number_format((int)$it['price'], 0, ',', '.'); ?></td>
                        <td>Rp <?= number_format((int)$it['subtotal'], 0, ',', '.'); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <div style="margin-top:14px;">
            <a href="<?= base_url('admin/orders'); ?>" class="btn btn-ghost">Kembali</a>
        </div>
    </div>
</div>

</body>

</html>