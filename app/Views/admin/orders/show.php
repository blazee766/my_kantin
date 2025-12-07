<?php
$title = 'Detail Pesanan';
include APPPATH . 'Views/admin/partials/head.php';
?>

<style>
    .badge.wait {
        background-color: #f6c23e;
        color: #fff;
    }

    .badge.proc {
        background-color: #4e73df;
        color: #fff;
    }

    .badge.done {
        background-color: #1cc88a;
        color: #fff;
    }

    .badge.cancel {
        background-color: #e74a3b;
        color: #fff;
    }
</style>

<h1 class="h3 mb-4 text-gray-800">Detail Pesanan</h1>

<?php if (session('success')): ?>
    <div class="alert alert-success" role="alert"><?= esc(session('success')); ?></div>
<?php endif; ?>
<?php if (session('error')): ?>
    <div class="alert alert-danger" role="alert"><?= esc(session('error')); ?></div>
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
?>

<div class="row">
    <div class="col-lg-6">

        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">
                    Detail Pesanan #<?= esc($order['code']); ?>
                </h6>
            </div>
            <div class="card-body">

                <?php
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
                ?>

                <p class="mb-1">
                    <strong>Tanggal:</strong>
                    <?= esc(date('d M Y H:i', strtotime($order['created_at']))); ?>
                </p>
                <p class="mb-1">
                    <strong>Pemesan:</strong> <?= esc($order['customer_name'] ?? '-'); ?>
                </p>
                <p class="mb-1">
                    <strong>Total:</strong>
                    Rp <?= number_format((int)$order['total_amount'], 0, ',', '.'); ?>
                </p>
                <p class="mb-1">
                    <strong>Metode:</strong> <?= esc($deliveryLabel); ?>
                </p>
                <p class="mb-1">
                    <strong>Lokasi:</strong> <?= esc(trim($locBuilding . ' ' . $locRoom)); ?>
                </p>
                <?php if (!empty($locNote)): ?>
                    <p class="mb-1">
                        <strong>Catatan:</strong> <?= esc($locNote); ?>
                    </p>
                <?php endif; ?>

                <p class="mb-1">
                    <strong>Status:</strong>
                    <span class="<?= $badgeClass; ?>"><?= $label; ?></span>
                </p>
                <p class="mb-3">
                    <strong>Status Pembayaran:</strong>
                    <span class="<?= $paymentBadgeClass; ?>"><?= $paymentLabel; ?></span>
                </p>
                <?php if ($paymentStatus !== 'paid'): ?>
                    <form action="<?= base_url('admin/orders/' . $order['id'] . '/paid'); ?>"
                        method="post"
                        class="mt-2">
                        <?= csrf_field(); ?>
                        <button type="submit" class="btn btn-success btn-sm">
                            Tandai Sudah Dibayar (Tunai)
                        </button>
                    </form>
                <?php endif; ?>

                <form action="<?= base_url('admin/orders/' . $order['id'] . '/status'); ?>" method="post" class="mt-3">
                    <?= csrf_field(); ?>

                    <div class="btn-group" role="group" aria-label="Ubah Status">
                        <button type="submit" name="status" value="pending" class="btn btn-light border">
                            Menunggu
                        </button>
                        <button type="submit" name="status" value="processing" class="btn btn-info text-white">
                            Diproses
                        </button>
                        <button type="submit" name="status" value="completed" class="btn btn-success">
                            Selesai
                        </button>
                        <button type="submit" name="status" value="canceled" class="btn btn-danger">
                            Batal
                        </button>
                    </div>
                </form>

            </div>
        </div>

    </div>

    <div class="col-lg-6">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Item Pesanan</h6>
            </div>
            <div class="card-body">

                <?php
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

                <div class="table-responsive">
                    <table class="table table-bordered mb-0">
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

                            <tr>
                                <td colspan="3" style="font-weight:bold;">Total</td>
                                <td style="font-weight:bold;">Rp <?= number_format($grandTotal, 0, ',', '.'); ?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="mt-3">
                    <a href="<?= base_url('admin/orders'); ?>" class="btn btn-light border">
                        Kembali
                    </a>
                </div>

            </div>
        </div>
    </div>
</div>
<?php include APPPATH . 'Views/admin/partials/foot.php'; ?>