<?php
$title = 'Proses Menu';
include APPPATH . 'Views/admin/partials/head.php';
?>

<style>
  /* Reuse theme variables from partial head.php */
  .card { border-radius:16px; box-shadow:0 12px 30px rgba(0,0,0,0.06); border:none; }
  .card-header { background:transparent; border-bottom:none; padding:18px 24px; }
  .card-header h6 { color:var(--primary); font-weight:700; margin:0; }

  /* Table spacing and style */
  .table { border-collapse: separate; border-spacing: 0 10px; }
  .table thead th { background:transparent; border:none; color:var(--muted); font-weight:600; padding:12px 18px; }
  .table tbody tr { background:var(--card); border-radius:12px; box-shadow:0 6px 14px rgba(0,0,0,0.03); }
  .table td { vertical-align: middle; border: none !important; padding:14px 18px; }

  /* Status badges */
  .order-pill {
    display:inline-flex;
    align-items:center;
    justify-content:center;
    gap:5px;
    min-height:30px;
    padding:6px 10px;
    border-radius:999px;
    font-size:0.78rem;
    font-weight:600;
    line-height:1;
    white-space:nowrap;
  }

  .badge-wait { background:#f6c23e; color:#fff; }
  .badge-proc { background:#4e73df; color:#fff; }
  .badge-done { background:#1cc88a; color:#fff; }
  .badge-cancel { background:#e74a3b; color:#fff; }

  /* Payment badges reuse */
  .badge-pay-unpaid { background:var(--primary); color:#fff; }
  .badge-pay-paid { background:#1cc88a; color:#fff; }
  .badge-pay-failed { background:#e74a3b; color:#fff; }

  /* Actions */
  .btn-detail { background:var(--primary); color:#fff; border:none; box-shadow:0 8px 20px rgba(255,71,102,0.12); text-decoration:none; }
  .btn-detail:hover { color:#fff; text-decoration:none; }
  .btn-text,
  .badge-text { margin-left:0; }
  .proof-thumb {
    display:inline-flex;
    align-items:center;
    justify-content:center;
    width:64px;
    height:64px;
    border-radius:10px;
    overflow:hidden;
    background:#f8f9fc;
    border:1px solid #edf1f7;
  }
  .proof-thumb img {
    width:100%;
    height:100%;
    object-fit:cover;
    display:block;
  }
  .proof-empty {
    color:var(--muted);
    font-size:0.82rem;
    white-space:nowrap;
  }
  .proof-check {
    display:inline-flex;
    align-items:center;
    justify-content:center;
    width:38px;
    height:38px;
    border-radius:999px;
    background:#dcfce7;
    color:#128454;
    font-size:1rem;
  }

  /* Pagination */
  .pagination li { display:inline-block; margin:0 4px; }
  .pagination li a, .pagination li span { padding:8px 12px; border-radius:8px; border:1px solid transparent; background:#fff; color:#555; }
  .pagination li.active span { background:var(--primary); color:#fff; border-color:var(--primary); }

  /* Responsive tweaks */
  @media (max-width:576px) {
    .table thead th { font-size:0.86rem; }
    .table td { padding:10px 12px; }
    .btn-text { display:none; }
  }
</style>

<h1 class="h3 mb-4 text-gray-800">Proses Menu / Pesanan</h1>

<div class="card shadow mb-4">
    <div class="card-header py-3 d-flex justify-content-between align-items-center">
        <h6 class="m-0 font-weight-bold text-primary">Daftar Pesanan</h6>

        <div class="d-flex align-items-center flex-wrap" style="gap: 10px;">
            <a href="<?= base_url('admin/orders/create'); ?>" class="btn btn-sm btn-primary">
                <i class="fas fa-plus"></i>
                Buat Pesanan
            </a>

            <form method="get" class="form-inline">
                <label class="mr-2 mb-0 small text-muted">Pembayaran:</label>
                <select name="payment" class="form-control form-control-sm" onchange="this.form.submit()">
                    <option value="">Semua</option>
                    <option value="lunas" <?= (isset($payment) && $payment === 'lunas') ? 'selected' : '' ?>>Lunas</option>
                    <option value="belum" <?= (isset($payment) && $payment === 'belum') ? 'selected' : '' ?>>Belum bayar</option>
                </select>
            </form>
        </div>
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
            <table class="table table-bordered" width="100%" cellspacing="0" data-admin-orders-poll="<?= base_url('admin/orders/statuses'); ?>">
                <thead class="thead-light">
                    <tr>
                        <th>Kode</th>
                        <th>Tanggal</th>
                        <th>Pemesan</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Pembayaran</th>
                        <th>Bukti Bayar</th>
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
                            $isAdminOrder = ($o['customer_role'] ?? '') === 'admin';
                            ?>
                            <tr>
                                <td>#<?= esc($o['code']); ?></td>
                                <td><?= esc(date('d M Y H:i', strtotime($o['created_at']))); ?></td>
                                <td><?= esc($o['customer_name'] ?? '-'); ?></td>
                                <td>Rp <?= number_format((int)$o['total_amount'], 0, ',', '.'); ?></td>
                                                                <td>
                                                                        <span class="badge order-pill <?= esc($clsKey); ?>" data-order-status-badge data-order-id="<?= (int) $o['id']; ?>">
                                                                                <?php if ($clsKey === 'badge-done'): ?>
                                                                                    <i class="fas fa-check-circle"></i>
                                                                                <?php elseif ($clsKey === 'badge-cancel'): ?>
                                                                                    <i class="fas fa-times-circle"></i>
                                                                                <?php else: ?>
                                                                                    <i class="fas fa-clock"></i>
                                                                                <?php endif; ?>
                                                                                <span class="badge-text"> <?= esc($label); ?></span>
                                                                        </span>
                                                                </td>
                                                                <td>
                                                                        <span class="order-pill <?= esc($payClass); ?>" data-order-payment-badge data-order-id="<?= (int) $o['id']; ?>">
                                                                                <?php if ($payClass === 'badge-pay-paid'): ?>
                                                                                    <i class="fas fa-wallet"></i>
                                                                                <?php elseif ($payClass === 'badge-pay-failed'): ?>
                                                                                    <i class="fas fa-exclamation-triangle"></i>
                                                                                <?php else: ?>
                                                                                    <i class="fas fa-credit-card"></i>
                                                                                <?php endif; ?>
                                                                                <span class="badge-text"> <?= esc($payLabel); ?></span>
                                                                        </span>
                                                                </td>
                                                                <td>
                                                                    <?php if ($isAdminOrder): ?>
                                                                        <span class="proof-check" title="Pembayaran kasir admin">
                                                                            <i class="fas fa-check"></i>
                                                                        </span>
                                                                    <?php elseif (!empty($o['payment_proof'])): ?>
                                                                        <a class="proof-thumb" href="<?= base_url($o['payment_proof']); ?>" target="_blank" rel="noopener" title="Lihat bukti bayar">
                                                                            <img src="<?= base_url($o['payment_proof']); ?>" alt="Bukti bayar #<?= esc($o['code']); ?>">
                                                                        </a>
                                                                    <?php else: ?>
                                                                        <span class="proof-empty">Belum ada</span>
                                                                    <?php endif; ?>
                                                                </td>
                                                                <td>
                                                                        <a href="<?= base_url('admin/orders/' . $o['id']); ?>" class="btn-detail order-pill">
                                                                                <i class="fas fa-eye"></i><span class="btn-text">Lihat Detail</span>
                                                                        </a>
                                                                </td>
                            </tr>
                        <?php endforeach; ?>

                    <?php else: ?>
                        <tr>
                            <td colspan="8" class="text-center text-muted py-4">
                                Belum ada pesanan.
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>

            <?php if (isset($pager)): ?>
                <div class="d-flex justify-content-center mt-3">
                    <?= $pager->links('default', 'arrows'); ?>
                </div>
            <?php endif; ?>
        </div>

    </div>
</div>

<?php include APPPATH . 'Views/admin/partials/foot.php'; ?>
