<?php $title='Laporan Keuangan'; include APPPATH.'Views/admin/partials/head.php'; ?>
<style>
  :root{
    --bg-page:#fdeff0;
    --card-bg:#ffffff;
    --text-dark:#0b2130;
    --muted:#6b7280;
    --accent:#ff4766;
    --accent-dark:#e03f5d;
    --border:#e9e6e8;
    --shadow:rgba(10,25,40,0.06);
  }

  /* latar belakang halaman */
  body{
    background:var(--bg-page);
    color:var(--text-dark);
    font-family:'Poppins',sans-serif;
  }

  /* card */
  .card{
    background:var(--card-bg);
    border-radius:16px;
    box-shadow:0 12px 30px var(--shadow);
  }

  h1,h3{
    color:var(--text-dark);
  }

  label{
    font-weight:600;
    color:var(--text-dark);
  }

  /* input tanggal */
  input[type="date"]{
    border:1px solid var(--border);
    background:#fff;
    color:var(--text-dark);
    border-radius:10px;
    padding:8px 10px;
  }
  input[type="date"]:focus{
    outline:none;
    border-color:var(--accent);
    box-shadow:0 6px 18px rgba(255,71,102,0.12);
  }

  /* tombol */
  .btn{
    border:1px solid var(--border);
    border-radius:10px;
    background:#fff;
    color:var(--text-dark);
    font-weight:600;
  }

  .btn-primary{
    background:var(--accent);
    color:#fff;
    border:none;
  }
  .btn-primary:hover{
    background:var(--accent-dark);
  }

  /* table */
  table{
    width:100%;
    border-collapse:collapse;
  }
  thead th{
    padding:10px;
    border-bottom:1px solid var(--border);
    color:var(--text-dark);
    background:rgba(255,255,255,0.5);
  }
  tbody td{
    padding:10px;
    border-bottom:1px solid #f2f2f2;
    color:var(--text-dark);
  }

  small{ color:var(--muted); }
</style>

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
