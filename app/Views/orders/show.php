<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Detail Pesanan - KantinKamu</title>
  <link rel="stylesheet" href="<?= base_url('assets/css/style.css'); ?>">
  <style>
    .section{background:#fff;border-radius:16px;box-shadow:0 6px 16px rgba(0,0,0,.08);padding:16px;margin:16px 0}
    table{width:100%;border-collapse:collapse}
    th,td{padding:10px;border-bottom:1px solid #f2f2f2;text-align:left}
    .btn{padding:10px 14px;border-radius:10px;text-decoration:none;display:inline-block}
    .btn-primary{background:#FF6B35;color:#fff}
    .btn-ghost{background:#fff;border:1px solid #eee;color:#333}
    .btn-danger{background:#ff4d4f;color:#fff;border:none}
    .btn-inline{display:inline-flex;gap:8px;flex-wrap:wrap}
  </style>
</head>
<body>
<div class="container">
  <div class="section">
    <h2>Detail Pesanan #<?= esc($order['code'] ?? $order['id']); ?></h2>
    <p>Tanggal: <?= date('d M Y H:i', strtotime($order['created_at'] ?? 'now')); ?></p>
    <p>Total: <b>Rp <?= number_format((int)($order['total_amount'] ?? 0),0,',','.'); ?></b></p>
    <p>Status: <b><?= esc($order['status'] ?? 'pending'); ?></b></p>
  </div>

  <div class="section">
    <h3>Item</h3>
    <table>
      <thead><tr><th>Menu</th><th>Qty</th><th>Harga</th><th>Subtotal</th></tr></thead>
      <tbody>
        <?php foreach (($order['items'] ?? []) as $it): ?>
          <tr>
            <td><?= esc($it['name'] ?? ''); ?></td>
            <td><?= (int)($it['qty'] ?? 0); ?></td>
            <td>Rp <?= number_format((int)($it['price'] ?? 0),0,',','.'); ?></td>
            <td>Rp <?= number_format((int)($it['subtotal'] ?? 0),0,',','.'); ?></td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>

    <div class="btn-inline" style="margin-top:12px">
      <a href="<?= site_url('orders'); ?>" class="btn btn-ghost">Kembali</a>
      <a href="<?= site_url('menu'); ?>" class="btn btn-primary">Tambah Pesanan</a>

      <?php if (($order['status'] ?? '') !== 'paid'): ?>
        <!-- Hapus/Batalkan pesanan -->
        <form action="<?= site_url('orders/'.$order['id'].'/delete'); ?>" method="post" onsubmit="return confirm('Yakin ingin membatalkan/hapus pesanan ini?');" style="display:inline">
          <?= csrf_field(); ?>
          <input type="hidden" name="_method" value="DELETE">
          <button type="submit" class="btn btn-danger">Hapus / Batalkan</button>
        </form>
      <?php endif; ?>
    </div>
  </div>
</div>
</body>
</html>
