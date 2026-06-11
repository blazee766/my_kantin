<?php
$title = 'Detail Pesanan';
include APPPATH . 'Views/admin/partials/head.php';
?>

<style>
    .order-page {
        color: #172033;
    }

    .order-titlebar {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 18px;
        margin-bottom: 24px;
    }

    .order-titlebar h1 {
        margin: 0;
        font-weight: 800;
        color: #102033;
        letter-spacing: 0;
    }

    .order-subtitle {
        color: #778196;
        margin-top: 6px;
        font-size: 0.95rem;
    }

    .order-code {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        min-height: 38px;
        padding: 8px 14px;
        border-radius: 999px;
        background: #fff;
        border: 1px solid #e7eaf2;
        color: #3b4760;
        font-weight: 700;
        box-shadow: 0 8px 24px rgba(31, 44, 71, 0.06);
        white-space: nowrap;
    }

    .summary-grid {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 16px;
        margin-bottom: 20px;
    }

    .summary-card {
        background: #fff;
        border: 1px solid #edf0f6;
        border-radius: 14px;
        padding: 18px;
        box-shadow: 0 14px 32px rgba(31, 44, 71, 0.06);
    }

    .summary-label,
    .detail-label,
    .section-label {
        color: #778196;
        font-size: 0.76rem;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.04em;
    }

    .summary-label {
        margin-bottom: 8px;
    }

    .summary-value {
        color: #142033;
        font-size: 1.25rem;
        font-weight: 800;
    }

    .dashboard-card {
        background: #fff;
        border: 1px solid #edf0f6;
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 18px 44px rgba(31, 44, 71, 0.08);
    }

    .dashboard-card .card-header {
        background: #fff;
        border-bottom: 1px solid #edf0f6;
        padding: 20px 24px;
    }

    .dashboard-card .card-header h6 {
        color: #142033 !important;
        font-weight: 800;
        font-size: 1rem;
    }

    .dashboard-card .card-body {
        padding: 24px;
    }

    .order-page .alert,
    .order-page .ajax-flash {
        width: 100%;
        max-width: 100%;
        font-size: 0.95rem;
        line-height: 1.45;
        overflow-wrap: anywhere;
        white-space: normal;
    }

    .detail-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 14px;
        margin-bottom: 20px;
    }

    .detail-item {
        padding: 14px;
        border-radius: 12px;
        background: #f8fafc;
        border: 1px solid #edf0f6;
    }

    .detail-label {
        display: block;
        margin-bottom: 6px;
    }

    .detail-value {
        color: #222c3f;
        font-weight: 700;
        line-height: 1.35;
    }

    .order-page .badge {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        min-height: 30px;
        padding: 7px 12px;
        border-radius: 999px !important;
        font-size: 0.78rem;
        font-weight: 800;
        line-height: 1;
        white-space: nowrap;
    }

    .order-page .badge.wait {
        background-color: #fff4d4;
        color: #a46400;
    }

    .order-page .badge.proc {
        background-color: #e7f0ff;
        color: #1f62c9;
    }

    .order-page .badge.done {
        background-color: #dcfce7;
        color: #128454;
    }

    .order-page .badge.cancel {
        background-color: #ffe4e6;
        color: #d12b3f;
    }

    .action-section {
        border-top: 1px solid #edf0f6;
        margin-top: 20px;
        padding-top: 20px;
    }

    .section-label {
        margin-bottom: 10px;
    }

    .order-page .btn {
        border-radius: 10px !important;
        font-weight: 700;
        min-height: 40px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        box-shadow: none !important;
    }

    .order-page .btn-success {
        background: #19c37d !important;
        border-color: #19c37d !important;
    }

    .order-page .btn-info {
        background: #2674e8 !important;
        border-color: #2674e8 !important;
    }

    .order-page .btn-primary {
        background: #ff4766 !important;
        border-color: #ff4766 !important;
    }

    .order-page .btn-danger {
        background: #ef4444 !important;
        border-color: #ef4444 !important;
    }

    .status-actions,
    .utility-actions {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
    }

    .utility-actions {
        margin-top: 18px;
    }

    .status-actions .btn,
    .utility-actions .btn {
        padding: 8px 14px;
    }

    .order-table {
        border-collapse: separate;
        border-spacing: 0;
        overflow: hidden;
        border-radius: 14px;
        border: 1px solid #e4e8f1;
    }

    .order-table thead th {
        background: #f4f7fb;
        border: none;
        color: #5d6678;
        font-size: 0.82rem;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.03em;
        padding: 15px 18px;
    }

    .order-table tbody td {
        border-color: #edf0f6;
        color: #333d52;
        padding: 16px 18px;
        vertical-align: middle;
        font-weight: 600;
    }

    .order-table .total-row td {
        background: #fbfcfe;
        color: #142033;
        font-weight: 800;
        font-size: 1rem;
    }

    .proof-card {
        border-top: 1px solid #edf0f6;
        margin-top: 20px;
        padding-top: 20px;
    }

    .proof-image-link {
        display: block;
        width: 100%;
        max-width: 360px;
        border-radius: 14px;
        overflow: hidden;
        border: 1px solid #edf0f6;
        background: #f8fafc;
        box-shadow: 0 14px 32px rgba(31, 44, 71, 0.06);
    }

    .proof-image-link img {
        display: block;
        width: 100%;
        max-height: 360px;
        object-fit: contain;
        background: #fff;
    }

    .proof-empty {
        padding: 14px;
        border-radius: 12px;
        background: #f8fafc;
        border: 1px dashed #d8deea;
        color: #778196;
        font-weight: 700;
    }

    .proof-admin-paid {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        padding: 12px 14px;
        border-radius: 12px;
        background: #dcfce7;
        border: 1px solid #bbf7d0;
        color: #128454;
        font-weight: 800;
    }

    @media (max-width: 992px) {
        .summary-grid {
            grid-template-columns: 1fr;
        }
    }

    @media (max-width: 576px) {
        .order-titlebar {
            display: block;
        }

        .order-code {
            margin-top: 14px;
        }

        .detail-grid {
            grid-template-columns: 1fr;
        }
    }
</style>

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
$statusIconMap = [
    'pending'    => 'fas fa-clock',
    'processing' => 'fas fa-utensils',
    'completed'  => 'fas fa-check-circle',
    'canceled'   => 'fas fa-times-circle',
];
$statusIcon = $statusIconMap[$status] ?? 'fas fa-info-circle';

$paymentStatus = $order['payment_status'] ?? 'unpaid';

$payLabelMap = [
    'unpaid' => 'Belum Dibayar',
    'paid'   => 'Sudah Dibayar',
    'failed' => 'Gagal / Kadaluarsa',
];

$payBadgeMap = [
    'unpaid' => 'badge wait',
    'paid'   => 'badge done',
    'failed' => 'badge cancel',
];

$paymentLabel      = $payLabelMap[$paymentStatus] ?? ucfirst($paymentStatus);
$paymentBadgeClass = $payBadgeMap[$paymentStatus] ?? 'badge';
$paymentIconMap = [
    'unpaid' => 'fas fa-credit-card',
    'paid'   => 'fas fa-wallet',
    'failed' => 'fas fa-exclamation-triangle',
];
$paymentIcon = $paymentIconMap[$paymentStatus] ?? 'fas fa-wallet';
$isAdminOrder = ($order['customer_role'] ?? '') === 'admin';

$waLink = null;

if (!empty($order['no_hp'])) {
    $waPhone = preg_replace('/^0/', '62', $order['no_hp']);

    $message =
        "Halo {$order['customer_name']},\n" .
        "Pesanan Anda dengan kode {$order['code']} sudah *SELESAI*\n" .
        "Silakan diambil / ditunggu ya.\n" .
        "Terima kasih";

    $waMessage = urlencode($message);
    $waLink = "https://wa.me/{$waPhone}?text={$waMessage}";
}

$deliveryLabel = '-';
$dm = $order['delivery_method'] ?? null;

if ($dm === 'pickup') {
    $deliveryLabel = 'Ambil Sendiri';
} elseif ($dm === 'delivery') {
    $deliveryLabel = 'Diantar';
}

$locBuilding = $order['address_building'] ?? ($order['building'] ?? '-');
$locRoom     = $order['address_room'] ?? ($order['room'] ?? '');
$locNote     = $order['address_note'] ?? '';

$groupedItems = [];

foreach ($items as $it) {
    $key = $it['name'];

    if (!isset($groupedItems[$key])) {
        $groupedItems[$key] = [
            'name'     => $it['name'],
            'qty'      => (int) $it['qty'],
            'price'    => (int) $it['price'],
            'subtotal' => (int) $it['subtotal'],
        ];
    } else {
        $groupedItems[$key]['qty']      += (int) $it['qty'];
        $groupedItems[$key]['subtotal'] += (int) $it['subtotal'];
    }
}
?>

<div class="order-page">
    <div class="order-titlebar">
        <div>
            <h1 class="h3 text-gray-800">Detail Pesanan</h1>
            <div class="order-subtitle">Kelola status pesanan, pembayaran, dan dokumen transaksi.</div>
        </div>
        <div class="order-code">
            <i class="fas fa-receipt"></i>
            #<?= esc($order['code']); ?>
        </div>
    </div>

    <?php if (session('success')): ?>
        <div class="alert alert-success" role="alert"><?= esc(session('success')); ?></div>
    <?php endif; ?>
    <?php if (session('error')): ?>
        <div class="alert alert-danger" role="alert"><?= esc(session('error')); ?></div>
    <?php endif; ?>

    <div class="summary-grid">
        <div class="summary-card">
            <div class="summary-label">Total Pesanan</div>
            <div class="summary-value">Rp <?= number_format((int)$order['total_amount'], 0, ',', '.'); ?></div>
        </div>
        <div class="summary-card">
            <div class="summary-label">Status Pesanan</div>
            <div class="summary-value">
                <span class="<?= $badgeClass; ?>" data-order-status-badge data-order-id="<?= (int) $order['id']; ?>"><i class="<?= esc($statusIcon); ?>"></i><span class="badge-text"> <?= esc($label); ?></span></span>
            </div>
        </div>
        <div class="summary-card">
            <div class="summary-label">Pembayaran</div>
            <div class="summary-value">
                <span class="<?= $paymentBadgeClass; ?>" data-order-payment-badge data-order-id="<?= (int) $order['id']; ?>"><i class="<?= esc($paymentIcon); ?>"></i><span class="badge-text"> <?= esc($paymentLabel); ?></span></span>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-6">
            <div class="card dashboard-card mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Informasi Pesanan</h6>
                </div>
                <div class="card-body">
                    <div class="detail-grid">
                        <div class="detail-item">
                            <span class="detail-label">Tanggal</span>
                            <span class="detail-value"><?= esc(date('d M Y H:i', strtotime($order['created_at']))); ?></span>
                        </div>
                        <div class="detail-item">
                            <span class="detail-label">Pemesan</span>
                            <span class="detail-value"><?= esc($order['customer_name'] ?? '-'); ?></span>
                        </div>
                        <div class="detail-item">
                            <span class="detail-label">Metode</span>
                            <span class="detail-value"><?= esc($deliveryLabel); ?></span>
                        </div>
                        <div class="detail-item">
                            <span class="detail-label">Lokasi</span>
                            <span class="detail-value"><?= esc(trim($locBuilding . ' ' . $locRoom)); ?></span>
                        </div>
                        <div class="detail-item">
                            <span class="detail-label">Status</span>
                            <span class="detail-value"><span class="<?= $badgeClass; ?>" data-order-status-badge data-order-id="<?= (int) $order['id']; ?>"><i class="<?= esc($statusIcon); ?>"></i><span class="badge-text"> <?= esc($label); ?></span></span></span>
                        </div>
                        <div class="detail-item">
                            <span class="detail-label">Pembayaran</span>
                            <span class="detail-value"><span class="<?= $paymentBadgeClass; ?>" data-order-payment-badge data-order-id="<?= (int) $order['id']; ?>"><i class="<?= esc($paymentIcon); ?>"></i><span class="badge-text"> <?= esc($paymentLabel); ?></span></span></span>
                        </div>
                    </div>

                    <?php if (!empty($locNote)): ?>
                        <div class="detail-item mb-3">
                            <span class="detail-label">Catatan</span>
                            <span class="detail-value"><?= esc($locNote); ?></span>
                        </div>
                    <?php endif; ?>

                    <div class="proof-card">
                        <div class="section-label">Bukti Pembayaran</div>
                        <?php if ($isAdminOrder): ?>
                            <div class="proof-admin-paid">
                                <i class="fas fa-check-circle"></i>
                                Pembayaran kasir admin
                            </div>
                        <?php elseif (!empty($order['payment_proof'])): ?>
                            <a
                                class="proof-image-link"
                                href="<?= base_url($order['payment_proof']); ?>"
                                target="_blank"
                                rel="noopener">
                                <img src="<?= base_url($order['payment_proof']); ?>" alt="Bukti pembayaran #<?= esc($order['code']); ?>">
                            </a>
                        <?php else: ?>
                            <div class="proof-empty">Belum ada bukti pembayaran.</div>
                        <?php endif; ?>
                    </div>

                    <?php if ($paymentStatus !== 'paid'): ?>
                        <form action="<?= base_url('admin/orders/' . $order['id'] . '/paid'); ?>" method="post" class="action-section" data-ajax-form data-ajax-action="admin-paid">
                            <?= csrf_field(); ?>
                            <div class="section-label">Pembayaran</div>
                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-money-bill-wave"></i>
                                Tandai Sudah Dibayar (Tunai)
                            </button>
                        </form>
                    <?php endif; ?>

                    <form action="<?= base_url('admin/orders/' . $order['id'] . '/status'); ?>" method="post" class="action-section" data-ajax-form data-ajax-action="admin-status">
                        <?= csrf_field(); ?>
                        <div class="section-label">Ubah Status Pesanan</div>
                        <div class="status-actions" role="group" aria-label="Ubah Status">
                            <button type="submit" name="status" value="pending" class="btn btn-light border">
                                <i class="fas fa-hourglass-half"></i>
                                Menunggu
                            </button>
                            <button type="submit" name="status" value="processing" class="btn btn-info text-white">
                                <i class="fas fa-utensils"></i>
                                Diproses
                            </button>
                            <button type="submit" name="status" value="completed" class="btn btn-success">
                                <i class="fas fa-check"></i>
                                Selesai
                            </button>
                            <button type="submit" name="status" value="canceled" class="btn btn-danger">
                                <i class="fas fa-times"></i>
                                Batal
                            </button>
                        </div>
                    </form>

                    <?php if ($status === 'completed' && $waLink): ?>
                        <div class="mt-3">
                            <a href="<?= $waLink ?>" target="_blank" class="btn btn-success">
                                <i class="fab fa-whatsapp"></i>
                                Kirim WhatsApp ke Pembeli
                            </a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="card dashboard-card mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Item Pesanan</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered order-table mb-0">
                            <thead class="thead-light">
                                <tr>
                                    <th>Menu</th>
                                    <th>Qty</th>
                                    <th>Harga</th>
                                    <th>Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $grandTotal = 0; ?>
                                <?php foreach ($groupedItems as $it): ?>
                                    <tr>
                                        <td><?= esc($it['name']); ?></td>
                                        <td><?= $it['qty']; ?></td>
                                        <td>Rp <?= number_format((int)$it['price'], 0, ',', '.'); ?></td>
                                        <td>Rp <?= number_format((int)$it['subtotal'], 0, ',', '.'); ?></td>
                                    </tr>
                                    <?php $grandTotal += (int)$it['subtotal']; ?>
                                <?php endforeach; ?>

                                <tr class="total-row">
                                    <td colspan="3">Total</td>
                                    <td>Rp <?= number_format($grandTotal, 0, ',', '.'); ?></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="utility-actions">
                        <a href="<?= base_url('admin/orders'); ?>" class="btn btn-light border">
                            <i class="fas fa-arrow-left"></i>
                            Kembali
                        </a>
                        <a class="btn btn-primary" target="_blank" href="<?= base_url('admin/orders/' . $order['id'] . '/nota'); ?>">
                            <i class="fas fa-print"></i>
                            Cetak Nota
                        </a>
                        <a class="btn btn-outline-secondary" target="_blank" href="<?= base_url('admin/orders/' . $order['id'] . '/nota/pdf'); ?>">
                            <i class="fas fa-file-pdf"></i>
                            Download PDF
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include APPPATH . 'Views/admin/partials/foot.php'; ?>
