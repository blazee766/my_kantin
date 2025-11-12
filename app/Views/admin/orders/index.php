<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Pesanan Saya - KantinKamu</title>
  <link rel="stylesheet" href="<?= base_url('assets/css/style.css'); ?>">
  <style>
    .page-head{margin:20px 0 10px;text-align:center}
    .page-head h2{margin-bottom:6px}
    .orders{display:grid;grid-template-columns:repeat(auto-fill,minmax(280px,1fr));gap:16px}
    .card{background:#fff;border-radius:16px;box-shadow:0 6px 16px rgba(0,0,0,.08);padding:16px}
    .meta{color:#666;font-size:.9rem;margin:6px 0}
    .badge{display:inline-block;padding:4px 10px;border-radius:999px;font-size:.8rem}
    .badge.wait{background:#fff1cc;color:#a87000}
    .badge.paid{background:#eaffea;color:#1b7a2e}
    .badge.cancel{background:#ffe4e4;color:#b21d1d}
    .btn-link{display:inline-block;margin-top:8px;background:#FF6B35;color:#fff;padding:10px 14px;border-radius:10px;text-decoration:none}
    .empty{padding:24px;text-align:center;color:#777;background:#fff;border-radius:16px}
  </style>
</head>
<body>
<div class="container">

  <div class="page-head">
    <h2>Pesanan Saya</h2>
    <?php if(session()->getFlashdata('error')): ?>
      <div class="meta" style="color:#b21d1d;"><?= esc(session()->getFlashdata('error')); ?></div>
    <?php endif; ?>
    <?php if(session()->getFlashdata('success')): ?>
      <div class="meta" style="color:#1b7a2e;"><?= esc(session()->getFlashdata('success')); ?></div>
    <?php endif; ?>
  </div>

  <?php if(empty($orders)): ?>
    <div class="empty">
      Belum ada pesanan. Yuk mulai dari <a href="<?= site_url('menu'); ?>" style="color:#FF6B35;font-weight:600;">Menu</a>.
    </div>
  <?php else: ?>
    <div class="orders">
      <?php foreach($orders as $o): ?>
        <?php
          $status = strtolower($o['status'] ?? 'menunggu'); // contoh: menunggu, dibayar, batal
          $badgeClass = $status === 'dibayar' ? 'paid' : ($status === 'batal' ? 'cancel' : 'wait');
        ?>
        <div class="card">
          <h3 style="margin:0 0 8px;">#<?= esc($o['code'] ?? $o['id']); ?></h3>
          <div class="meta">Tanggal: <?= date('d M Y H:i', strtotime($o['created_at'] ?? 'now')); ?></div>
          <div class="meta">Total: <b>Rp <?= number_format((int)($o['total_amount'] ?? 0),0,',','.'); ?></b></div>
          <div class="meta">Status:
            <span class="badge <?= $badgeClass; ?>">
              <?= ucfirst($status); ?>
            </span>
          </div>
          <a class="btn-link" href="<?= site_url('orders/'.$o['id']); ?>">Lihat Detail</a>
        </div>
      <?php endforeach; ?>
    </div>
  <?php endif; ?>

</div>
</body>
</html>
