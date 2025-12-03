<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Detail Pesanan - Kantin G'penk</title>
  <link rel="stylesheet" href="<?= base_url('assets/css/style.css'); ?>">
  <style>
    :root {
      --bg-page: #fdeff0;
      --card-bg: #ffffff;
      --text-dark: #0b2130;
      --muted: #6b7280;
      --accent: #ff4766;
      --accent-dark: #e03f5d;
      --shadow: rgba(10, 25, 40, 0.06);
      --table-border: #f3f2f4;
      --danger: #ff4d4f;
      --ghost-border: #eee;
    }

    html,
    body {
      margin: 0;
      padding: 0;
      max-width: 100%;
      overflow-x: hidden;
    }

    body {
      background: var(--bg-page);
      margin: 0;
      font-family: 'Poppins', sans-serif;
      color: var(--text-dark);
      min-height: 100vh;
      padding: 0;
    }

    .container {
      max-width: 1100px;
      margin: 0 auto;
      padding: 20px 16px;
    }

    .section {
      background: var(--card-bg);
      border-radius: 16px;
      box-shadow: 0 6px 16px var(--shadow);
      padding: 16px;
      margin: 16px 0;
    }

    .section h2,
    .section h3 {
      margin: 0 0 8px 0;
      color: var(--accent);
      font-weight: 700;
    }

    p {
      color: var(--muted);
      margin: 6px 0;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 8px;
      background: transparent;
    }

    th,
    td {
      padding: 12px 10px;
      border-bottom: 1px solid var(--table-border);
      text-align: left;
      color: var(--text-dark);
      font-size: 0.95rem;
    }

    thead th {
      font-weight: 700;
      color: var(--text-dark);
      background: transparent;
    }

    .btn {
      padding: 10px 14px;
      border-radius: 10px;
      text-decoration: none;
      display: inline-block;
      font-weight: 600;
      cursor: pointer;
    }

    .btn-primary {
      background: var(--accent);
      color: #fff;
      border: none;
    }

    .btn-primary:hover {
      background: var(--accent-dark);
    }

    .btn-ghost {
      background: #fff;
      border: 1px solid var(--ghost-border);
      color: var(--text-dark);
    }

    .btn-danger {
      background: var(--danger);
      color: #fff;
      border: none;
    }

    .btn-inline {
      display: inline-flex;
      gap: 8px;
      flex-wrap: wrap;
    }

    .badge {
      display: inline-block;
      padding: 4px 10px;
      border-radius: 999px;
      font-size: .8rem;
      font-weight: 600;
    }

    .badge.pending {
      background: #fff3d6;
      color: #a26a00;
    }

    .badge.paid {
      background: #e8ffe8;
      color: #1b7a2e;
    }

    .badge.cancel {
      background: #ffe5e7;
      color: #b21d1d;
    }

    @media (max-width:720px) {

      th,
      td {
        padding: 10px 8px;
        font-size: 0.92rem
      }

      .section {
        padding: 14px
      }
    }
  </style>

</head>

<body>
  <?php
  $status = $order['status'] ?? 'pending';

  $labelMap = [
    'pending'    => 'Menunggu',
    'menunggu'   => 'Menunggu',
    'processing' => 'Diproses',
    'diproses'   => 'Diproses',
    'completed'  => 'Selesai',
    'selesai'    => 'Selesai',
    'canceled'   => 'Batal',
    'batal'      => 'Batal',
  ];

  $classMap = [
    'pending'    => 'pending',
    'menunggu'   => 'pending',
    'processing' => 'pending',
    'diproses'   => 'pending',
    'completed'  => 'paid',
    'selesai'    => 'paid',
    'canceled'   => 'cancel',
    'batal'      => 'cancel',
  ];

  $statusLabel = $labelMap[$status]  ?? ucfirst($status);
  $statusClass = $classMap[$status] ?? 'pending';
  $deliveryRaw  = $order['delivery_method'] ?? 'pickup';
  $deliveryText = $deliveryRaw === 'delivery'
    ? 'Diantar'
    : 'Ambil Sendiri';
  ?>

  <div class="container">
    <div class="section">
      <h2>Detail Pesanan #<?= esc($order['code'] ?? $order['id']); ?></h2>
      <p>Tanggal: <?= date('d M Y H:i', strtotime($order['created_at'] ?? 'now')); ?></p>
      <p>Total: <b>Rp <?= number_format((int)($order['total_amount'] ?? 0), 0, ',', '.'); ?></b></p>
      <p>Metode: <b><?= esc($deliveryText); ?></b></p>

      <?php if ($deliveryRaw === 'delivery'): ?>
        <?php
        $loc = trim(
          (string)($order['address_building'] ?? '') .
            (!empty($order['address_room']) ? ' - ' . $order['address_room'] : '')
        );
        ?>
        <?php if ($loc !== ''): ?>
          <p>Lokasi: <b><?= esc($loc); ?></b></p>
        <?php endif; ?>

        <?php if (!empty($order['address_note'])): ?>
          <p style="font-size: .9rem; color:#666;">
            Catatan: <?= esc($order['address_note']); ?>
          </p>
        <?php endif; ?>
      <?php endif; ?>
      <p>Status: <span class="badge <?= $statusClass; ?>"><?= esc($statusLabel); ?></span>
      </p>
      <p>
        Status Pembayaran:
        <b>
          <?= $paymentStatus === 'paid' ? 'Sudah Dibayar' : 'Belum Dibayar'; ?>
        </b>
      </p>
    </div>

    <div class="section">
      <h3>Item</h3>
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
          <?php
          $grandTotal = 0;
          foreach (($order['items'] ?? []) as $it):
            $lineTotal = (int)($it['subtotal'] ?? ((int)($it['price'] ?? 0) * (int)($it['qty'] ?? 0)));
            $grandTotal += $lineTotal;
          ?>
            <tr>
              <td><?= esc($it['name'] ?? ''); ?></td>
              <td><?= (int)($it['qty'] ?? 0); ?></td>
              <td>Rp <?= number_format((int)($it['price'] ?? 0), 0, ',', '.'); ?></td>
              <td>Rp <?= number_format($lineTotal, 0, ',', '.'); ?></td>
            </tr>
          <?php endforeach; ?>
          <tr>
            <td style="font-weight:bold;">Total</td>
            <td></td>
            <td></td>
            <td style="font-weight:bold;">Rp <?= number_format($grandTotal, 0, ',', '.'); ?></td>
          </tr>
        </tbody>
      </table>

      <div class="btn-inline" style="margin-top:12px">
        <a href="<?= site_url('/'); ?>" class="btn btn-ghost">Kembali</a>
        <?php if (in_array($status, ['pending', 'menunggu'], true)): ?>
          <!-- HANYA tampil kalau status masih menunggu -->
          <a href="<?= site_url('menu'); ?>" class="btn btn-primary">Tambah Pesanan</a>
        <?php endif; ?>

        <?php
        // tombol BAYAR SEKARANG hanya kalau order masih pending & belum paid
        $paymentStatus = $order['payment_status'] ?? 'unpaid';
        if (in_array($status, ['pending', 'menunggu'], true) && $paymentStatus !== 'paid'): ?>
          <a href="<?= site_url('p/payment/' . $order['id']); ?>" class="btn btn-primary">
            Bayar Sekarang
          </a>
        <?php endif; ?>

        <?php if (!in_array($status, ['completed', 'selesai', 'canceled', 'batal'], true)): ?>
          <form action="<?= site_url('p/orders/' . $order['id'] . '/delete'); ?>"
            method="post"
            onsubmit="return confirm('Yakin ingin membatalkan pesanan?');"
            style="display:inline">
            <?= csrf_field(); ?>
            <button type="submit" class="btn btn-danger">Hapus / Batalkan</button>
          </form>
        <?php endif; ?>
      </div>
    </div>
  </div>
</body>

</html>