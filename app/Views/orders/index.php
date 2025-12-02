<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Pesanan Saya - KantinKamu</title>
  <link rel="stylesheet" href="<?= base_url('assets/css/style.css'); ?>">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

  <style>
    :root {
      --bg-page: #fdeff0;
      --card-bg: #ffffff;
      --text-dark: #0b2130;
      --muted: #6b7280;
      --accent: #ff4766;
      --accent-dark: #e03f5d;

      --pending-bg: #fff3d6;
      --pending-text: #a26a00;

      --paid-bg: #e8ffe8;
      --paid-text: #1b7a2e;

      --cancel-bg: #ffe5e7;
      --cancel-text: #b21d1d;

      --flash-success-bg: #e8fce9;
      --flash-success-border: #c0f0c6;
      --flash-success-text: #1f7d1f;

      --flash-error-bg: #ffeaea;
      --flash-error-border: #f3c3c3;
      --flash-error-text: #842323;
    }

    html,
    body {
      margin: 0;
      padding: 0;
      max-width: 100%;
      overflow-x: hidden;
    }

    body {
      background: var(--bg-page) fixed center/cover;
      min-height: 100vh;
      font-family: 'Poppins', sans-serif;
      color: var(--text-dark);
      -webkit-font-smoothing: antialiased;
      -moz-osx-font-smoothing: grayscale;
      margin: 0;
    }

    header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 20px 50px;
      background: var(--bg-page);
      box-shadow: 0 2px 8px rgba(10, 25, 40, 0.03);
      position: static;
      top: auto;
      border-bottom: none;
      z-index: 10;
    }

    header .logo {
      font-weight: 700;
      font-size: 1.1rem;
      display: flex;
      align-items: center;
      gap: 8px;
    }

    header .logo i {
      color: var(--accent);
    }

    header nav ul {
      list-style: none;
      display: flex;
      gap: 18px;
      margin: 0;
      padding: 0;
      align-items: center;
    }

    header nav a {
      text-decoration: none;
      color: var(--text-dark);
      font-weight: 500;
      padding-bottom: 4px;
      border-bottom: 2px solid transparent;
      transition: color .2s, border-color .2s;
    }

    header nav a:hover {
      color: var(--accent);
      border-bottom-color: var(--accent);
    }

    header nav a.active {
      color: var(--text-dark);
      border-bottom: none;
    }

    .container {
      max-width: 1100px;
      margin: 0 auto;
      padding: 28px 16px;
      box-sizing: border-box;
    }

    .page-head {
      margin: 8px 0 18px;
      text-align: center;
    }

    .page-head h2 {
      color: var(--accent);
      font-weight: 700;
      margin: 0;
    }

    .orders {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
      gap: 16px;
    }

    .card {
      background: var(--card-bg);
      border-radius: 16px;
      box-shadow: 0 6px 16px rgba(0, 0, 0, .06);
      padding: 16px;
    }

    .card h3 {
      color: var(--text-dark);
      font-weight: 700;
      margin: 0 0 8px 0;
    }

    .meta {
      color: var(--muted);
      font-size: .9rem;
      margin: 6px 0;
    }

    .badge {
      display: inline-block;
      padding: 4px 10px;
      border-radius: 999px;
      font-size: .8rem;
      font-weight: 600;
    }

    .badge.pending {
      background: var(--pending-bg);
      color: var(--pending-text);
    }

    .badge.paid {
      background: var(--paid-bg);
      color: var(--paid-text);
    }

    .badge.cancel {
      background: var(--cancel-bg);
      color: var(--cancel-text);
    }

    .btn-link {
      display: inline-block;
      margin-top: 8px;
      background: var(--accent);
      color: #fff;
      padding: 10px 14px;
      border-radius: 10px;
      text-decoration: none;
      font-weight: 600;
      transition: background .25s;
    }

    .btn-link:hover {
      background: var(--accent-dark);
    }

    .empty {
      padding: 24px;
      text-align: center;
      color: var(--muted);
      background: #fff;
      border-radius: 16px;
      font-size: 1rem;
    }

    .empty a {
      color: var(--accent);
      font-weight: 700;
      text-decoration: none;
    }

    .flash {
      max-width: 900px;
      margin: 10px auto;
      padding: 12px 16px;
      border-radius: 10px;
      font-weight: 600;
    }

    .flash.success {
      background: var(--flash-success-bg);
      color: var(--flash-success-text);
      border: 1px solid var(--flash-success-border);
    }

    .flash.error {
      background: var(--flash-error-bg);
      color: var(--flash-error-text);
      border: 1px solid var(--flash-error-border);
    }

    @media (max-width: 720px) {
      header {
        padding: 16px;
      }

      .container {
        padding: 18px 12px;
      }

      .orders {
        gap: 12px;
        grid-template-columns: 1fr;
      }
    }
  </style>

</head>

<body>

  <header>
    <div class="logo">
      <i class="fas fa-utensils"></i> KantinKamu
    </div>
    <nav>
      <ul>
        <li><a href="<?= site_url('/'); ?>">Home</a></li>
        <li><a href="<?= site_url('menu'); ?>">Menu</a></li>
        <li><a href="<?= site_url('about'); ?>">About Us</a></li>
      </ul>
    </nav>
  </header>

  <div class="container">
    <div class="page-head">
      <h2>Pesanan Saya</h2>

      <?php if ($msg = session()->getFlashdata('success')): ?>
        <div class="flash success"><?= esc($msg); ?></div>
      <?php endif; ?>
      <?php if ($msg = session()->getFlashdata('error')): ?>
        <div class="flash error"><?= esc($msg); ?></div>
      <?php endif; ?>
    </div>

    <?php if (empty($orders)): ?>
      <div class="empty">
        Belum ada pesanan. Mulai dari
        <a href="<?= site_url('menu'); ?>">Menu</a>.
      </div>
    <?php else: ?>
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
        'pending'    => 'pending',
        'menunggu'   => 'pending',
        'processing' => 'pending',
        'diproses'   => 'pending',
        'completed'  => 'paid',
        'selesai'    => 'paid',
        'canceled'   => 'cancel',
        'batal'      => 'cancel',
      ];
      ?>
      <div class="orders">
        <?php foreach ($orders as $o): ?>
          <?php
          $status = $o['status'] ?? 'pending';
          $label  = $statusLabelMap[$status] ?? ucfirst($status);
          $cls    = $statusClassMap[$status] ?? 'pending';

          $deliveryRaw  = $o['delivery_method'] ?? 'pickup';         
          $deliveryText = $deliveryRaw === 'delivery'
            ? 'Diantar'
            : 'Ambil Sendiri';
          ?>
          <div class="card">
            <h3>#<?= esc($o['code'] ?? $o['id']); ?></h3>
            <div class="meta">
              Tanggal:
              <?= date('d M Y H:i', strtotime($o['created_at'] ?? 'now')); ?>
            </div>
            <div class="meta">
              Total:
              <b>Rp <?= number_format((int)($o['total_amount'] ?? 0), 0, ',', '.'); ?></b>
            </div>
            <div class="meta">
              Metode:
              <b><?= esc($deliveryText); ?></b>
            </div>
            <?php if ($deliveryRaw === 'delivery'): ?>
              <?php
              $loc = trim(
                (string)($o['address_building'] ?? '') .
                  (!empty($o['address_room']) ? ' - ' . $o['address_room'] : '')
              );
              ?>
              <?php if ($loc !== ''): ?>
                <div class="meta">
                  Lokasi: <b><?= esc($loc); ?></b>
                </div>
              <?php endif; ?>

              <?php if (!empty($o['address_note'])): ?>
                <div class="meta" style="font-size: .85rem; color:#666;">
                  Catatan: <?= esc($o['address_note']); ?>
                </div>
              <?php endif; ?>
            <?php endif; ?>
            <div class="meta">
              Status:
              <span class="badge <?= $cls; ?>"><?= esc($label); ?></span>
            </div>
            <a class="btn-link" href="<?= site_url('p/orders/' . $o['id']); ?>">
              Lihat Detail
            </a>
          </div>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>
  </div>
</body>

</html>