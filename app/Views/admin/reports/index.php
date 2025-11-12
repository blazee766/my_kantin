<?php $title='Laporan Keuangan'; include APPPATH.'Views/admin/partials/head.php'; ?>
<div class="card">
  <h1>Laporan Keuangan</h1>

  <form method="get" class="mb-2" action="<?= base_url('admin/reports'); ?>">
    <div style="display:flex;gap:8px;flex-wrap:wrap;align-items:center">
      <div><label>Dari</label><input type="date" name="from" value="<?= esc($from); ?>"></div>
      <div><label>Sampai</label><input type="date" name="to" value="<?= esc($to); ?>"></div>
      <button class="btn btn-primary" type="submit"><i class="fa fa-filter"></i> Terapkan</button>
      <a class="btn" href="<?= base_url('admin/reports/export?from='.$from.'&to='.$to); ?>"><i class="fa fa-file-csv"></i> Export CSV</a>
    </div>
  </form>

  <div class="grid grid-2 mb-2">
    <div class="card">
      <h3 style="margin-top:0">Ringkasan</h3>
      <p>Total Transaksi: <b><?= (int)($sum['cnt'] ?? 0); ?></b></p>
      <p>Omzet (paid): <b>Rp <?= number_format((int)($sum['grand_total'] ?? 0),0,',','.'); ?></b></p>
      <small>Status dihitung dari order <b>paid</b>.</small>
    </div>
    <div class="card">
      <h3 style="margin-top:0">Top Menu</h3>
      <table>
        <thead><tr><th>Nama</th><th>Qty</th><th>Omzet</th></tr></thead>
        <tbody>
          <?php foreach($top as $t): ?>
          <tr>
            <td><?= esc(ucwords($t['name'])); ?></td>
            <td><?= (int)$t['qty']; ?></td>
            <td>Rp <?= number_format((int)$t['omzet'],0,',','.'); ?></td>
          </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>

  <div class="card">
    <h3 style="margin-top:0">Omzet Harian</h3>
    <table>
      <thead><tr><th>Tanggal</th><th>Orders</th><th>Omzet</th></tr></thead>
      <tbody>
        <?php foreach($daily as $d): ?>
        <tr>
          <td><?= esc($d['d']); ?></td>
          <td><?= (int)$d['orders']; ?></td>
          <td>Rp <?= number_format((int)$d['omzet'],0,',','.'); ?></td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>
</div></body></html>
