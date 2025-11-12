<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Detail Pesanan - KantinKamu</title>
  <link rel="stylesheet" href="<?= base_url('assets/css/style.css'); ?>">
  <style>
    .section{background:#fff;border-radius:16px;box-shadow:0 6px 16px rgba(0,0,0,.08);padding:16px;margin-bottom:16px}
    .title{margin:6px 0 12px}
    table{width:100%;border-collapse:collapse}
    th,td{padding:10px;border-bottom:1px solid #f2f2f2;text-align:left}
    .meta{color:#666;font-size:.95rem}
    .badge{display:inline-block;padding:4px 10px;border-radius:999px;font-size:.8rem}
    .badge.wait{background:#fff1cc;color:#a87000}
    .badge.paid{background:#eaffea;color:#1b7a2e}
    .badge.cancel{background:#ffe4e4;color:#b21d1d}
    .actions{display:flex;gap:10px;margin-top:12px}
    .btn{padding:10px 14px;border-radius:10px;text-decoration:none}
    .btn-primary{background:#FF6B35;color:#fff}
    .btn-ghost{background:#fff;border:1px solid #eee;color:#333}
  </style>
</head>
<body>
<div class="container">

  <div class="section">
    <h2 class="title">Detail Pesanan #<?= esc($order['code'] ?? $order['id']); ?></h2>
    <?php
      $status = strtolower($order['status'] ?? 'menunggu');
      $badgeClass = $status === 'dibayar' ? 'paid' : ($status === 'batal' ? 'cancel' : 'wait');
    ?>
    <div class="meta">Tanggal: <?= date('d M Y H:i', strtotime($order['created_at'] ?? 'now')); ?></div>
    <div class="meta">Total: <b>Rp <?= number_format((int)($order['total_amount'] ?? 0),0,',','.'); ?></b></div>
    <div class="meta">Status:
      <span class="badge <?= $badgeClass; ?>"><?= ucfirst($status); ?></span>
    </div>
    <div class="actions">
      <a href="<?= site_url('orders'); ?>" class="btn btn-ghost">Kembali</a>
      <a href="<?= site_url('menu'); ?>" class="btn btn-primary">Tambah Pesanan</a>
    </div>
  </div>

  <div class="section">
    <h3 class="title">Item</h3>
    <table>
      <thead>
        <tr>
          <th>Menu</th><th>Qty</th><th>Harga</th><th>Subtotal</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach(($order['items'] ?? []) as $it): ?>
          <tr>
            <td><?= esc($it['name'] ?? ''); ?></td>
            <td><?= (int)($it['qty'] ?? 0); ?></td>
            <td>Rp <?= number_format((int)($it['price'] ?? 0),0,',','.'); ?></td>
            <td>Rp <?= number_format((int)($it['subtotal'] ?? 0),0,',','.'); ?></td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>

  <?php if(!empty($order['payment'])): ?>
  <div class="section">
    <h3 class="title">Pembayaran</h3>
    <div class="meta">Metode: <b><?= esc($order['payment']['method'] ?? '-'); ?></b></div>
    <div class="meta">Jumlah: <b>Rp <?= number_format((int)($order['payment']['amount'] ?? 0),0,',','.'); ?></b></div>
    <div class="meta">Status: <b><?= esc(ucfirst($order['payment']['status'] ?? '-')); ?></b></div>
    <?php if(!empty($order['payment']['paid_at'])): ?>
      <div class="meta">Dibayar: <?= date('d M Y H:i', strtotime($order['payment']['paid_at'])); ?></div>
    <?php endif; ?>
  </div>
  <?php endif; ?>

</div>
</body>
</html>
