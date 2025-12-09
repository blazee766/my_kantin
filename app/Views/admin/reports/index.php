<?php
$title = 'Laporan Keuangan';
include APPPATH . 'Views/admin/partials/head.php';
?>

<style>
  :root {
    --bg-page: #fdeff0;
    --card-bg: #ffffff;
    --text-dark: #0b2130;
    --muted: #6b7280;
    --accent: #ff4766;
    --accent-dark: #e03f5d;
    --border: #e9e6e8;
    --shadow: rgba(10, 25, 40, 0.06);
  }

  body {
    background: var(--bg-page);
    color: var(--text-dark);
    font-family: 'Poppins', sans-serif;
  }

  .report-wrapper {
    max-width: 1100px;
    margin: 0 auto;
  }

  .report-card {
    background: var(--card-bg);
    border-radius: 18px;
    box-shadow: 0 12px 30px var(--shadow);
    padding: 22px 24px 26px;
    margin-bottom: 20px;
  }

  h1, h3 {
    color: var(--text-dark);
    margin-top: 0;
  }

  label {
    font-weight: 600;
    color: var(--text-dark);
    display: block;
    margin-bottom: 4px;
  }

  input[type="date"] {
    border: 1px solid var(--border);
    background: #fff;
    color: var(--text-dark);
    border-radius: 10px;
    padding: 8px 10px;
    min-width: 180px;
  }

  input[type="date"]:focus {
    outline: none;
    border-color: var(--accent);
    box-shadow: 0 6px 18px rgba(255, 71, 102, 0.12);
  }

  .btn {
    border: 1px solid var(--border);
    border-radius: 10px;
    background: #fff;
    color: var(--text-dark);
    font-weight: 600;
  }

  .btn-primary {
    background: var(--accent);
    color: #fff;
    border: none;
  }

  .btn-primary:hover {
    background: var(--accent-dark);
  }

  .grid {
    display: grid;
    gap: 16px;
    margin-bottom: 20px;
  }

  .grid-2 {
    grid-template-columns: minmax(0, 1.1fr) minmax(0, 1fr);
  }

  @media (max-width: 768px) {
    .grid-2 {
      grid-template-columns: 1fr;
    }
  }

  .card-inner {
    background: #fff;
    border-radius: 14px;
    border: 1px solid #f3f3f4;
    padding: 14px 16px 16px;
    box-shadow: 0 6px 18px var(--shadow);
  }

  table {
    width: 100%;
    border-collapse: collapse;
  }

  thead th {
    padding: 10px;
    border-bottom: 1px solid var(--border);
    color: var(--text-dark);
    background: rgba(255, 255, 255, 0.7);
    font-size: 0.9rem;
  }

  tbody td {
    padding: 10px;
    border-bottom: 1px solid #f2f2f2;
    color: var(--text-dark);
    font-size: 0.9rem;
  }

  small {
    color: var(--muted);
  }

  .filter-row {
    display: flex;
    flex-wrap: wrap;
    gap: 12px;
    align-items: flex-end;
    margin-bottom: 18px;
  }

  .filter-row > div {
    display: flex;
    flex-direction: column;
    gap: 4px;
  }

  @media (max-width: 720px) {
    .filter-row {
      flex-direction: column;
      align-items: stretch;
    }

    .filter-row .btn,
    .filter-row a.btn {
      width: 100%;
      text-align: center;
    }
  }
</style>

<h1 class="h3 mb-4 text-gray-800">Laporan Keuangan</h1>

<div class="report-wrapper">
  <div class="report-card">

    <form method="get" class="mb-2" action="<?= base_url('admin/reports'); ?>">
      <div class="filter-row">
        <div>
          <label for="from">Dari</label>
          <input type="date" id="from" name="from" value="<?= esc($from); ?>">
        </div>
        <div>
          <label for="to">Sampai</label>
          <input type="date" id="to" name="to" value="<?= esc($to); ?>">
        </div>
        <button class="btn btn-primary" type="submit">
          <i class="fa fa-filter"></i> Terapkan
        </button>
        <a class="btn" href="<?= base_url('admin/reports/export?from=' . $from . '&to=' . $to); ?>">
          <i class="fa fa-file-csv"></i> Export CSV
        </a>
      </div>
    </form>

    <div class="grid grid-2 mb-2">
      <div class="card-inner">
        <h3>Ringkasan</h3>
        <p>Total Transaksi: <b><?= (int)($sum['cnt'] ?? 0); ?></b></p>
        <p>Omzet (paid): <b>Rp <?= number_format((int)($sum['grand_total'] ?? 0), 0, ',', '.'); ?></b></p>
      </div>

      <div class="card-inner">
        <h3>Top Menu</h3>
        <?php if (!empty($top)): ?>
          <table>
            <thead>
              <tr>
                <th>Nama</th>
                <th>Qty</th>
                <th>Omzet</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($top as $t): ?>
                <tr>
                  <td><?= esc(ucwords($t['name'])); ?></td>
                  <td><?= (int)$t['qty']; ?></td>
                  <td>Rp <?= number_format((int)$t['omzet'], 0, ',', '.'); ?></td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        <?php else: ?>
          <small>Tidak ada data menu di rentang tanggal ini.</small>
        <?php endif; ?>
      </div>
    </div>

    <!-- OMZET HARIAN -->
    <div class="card-inner">
      <h3>Omzet Harian</h3>
      <?php if (!empty($daily)): ?>
        <table>
          <thead>
            <tr>
              <th>Tanggal</th>
              <th>Orders</th>
              <th>Omzet</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($daily as $d): ?>
              <tr>
                <td><?= esc($d['d']); ?></td>
                <td><?= (int)$d['orders']; ?></td>
                <td>Rp <?= number_format((int)$d['omzet'], 0, ',', '.'); ?></td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      <?php else: ?>
        <small>Belum ada transaksi pada rentang tanggal ini.</small>
      <?php endif; ?>
    </div>

  </div>
</div>
<?php include APPPATH . 'Views/admin/partials/foot.php'; ?>
