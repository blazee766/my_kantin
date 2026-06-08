<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Pesanan Saya - Kantin G'penk</title>
  <link rel="stylesheet" href="<?= base_url('assets/css/style.css?v=' . filemtime(FCPATH . 'assets/css/style.css')); ?>">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

  <style>
    :root {
      --orders-bg: #f8fafc;
      --orders-surface: #ffffff;
      --orders-soft: #fff1f4;
      --orders-text: #172033;
      --orders-muted: #667085;
      --orders-border: #e7ecf4;
      --orders-primary: #ff4766;
      --orders-accent: #ffb703;
      --orders-shadow: 0 24px 70px rgba(31, 44, 71, 0.1);
    }

    html,
    body {
      margin: 0;
      padding: 0;
      max-width: 100%;
      overflow-x: hidden;
    }

    body {
      background: radial-gradient(circle at top left, rgba(255, 71, 102, 0.08), transparent 34%),
        linear-gradient(180deg, #ffffff 0%, var(--orders-bg) 46%, #ffffff 100%);
      min-height: 100vh;
      font-family: 'Poppins', sans-serif;
      color: var(--orders-text);
      -webkit-font-smoothing: antialiased;
      -moz-osx-font-smoothing: grayscale;
      margin: 0;
    }

    .container {
      max-width: 1280px;
      margin: 0 auto;
      padding: 126px 18px 48px;
      box-sizing: border-box;
    }

    .page-head {
      display: grid;
      grid-template-columns: minmax(0, 1fr) auto;
      align-items: end;
      gap: 18px;
      margin: 16px 0 24px;
      padding: 28px;
      border: 1px solid var(--orders-border);
      border-radius: 28px;
      background: rgba(255, 255, 255, 0.88);
      box-shadow: var(--orders-shadow);
      backdrop-filter: blur(16px);
    }

    .page-head h2 {
      color: var(--orders-text);
      font-size: clamp(2rem, 4vw, 3.5rem);
      line-height: 1.03;
      letter-spacing: -0.04em;
      font-weight: 800;
      margin: 0;
    }

    .page-head p {
      max-width: 58ch;
      margin: 12px 0 0;
      color: var(--orders-muted);
      font-size: 1rem;
      line-height: 1.8;
    }

    .page-badge {
      display: inline-flex;
      align-items: center;
      gap: 8px;
      width: fit-content;
      margin-bottom: 14px;
      padding: 8px 14px;
      border-radius: 999px;
      background: rgba(255, 71, 102, 0.12);
      color: var(--orders-primary);
      font-weight: 800;
      font-size: 0.88rem;
    }

    .page-summary {
      min-width: 190px;
      padding: 18px;
      border-radius: 22px;
      background: linear-gradient(135deg, var(--orders-primary), var(--orders-accent));
      color: #fff;
      box-shadow: 0 20px 44px rgba(255, 71, 102, 0.2);
    }

    .page-summary span {
      display: block;
      font-size: 0.82rem;
      font-weight: 700;
      opacity: 0.9;
    }

    .page-summary strong {
      display: block;
      margin-top: 6px;
      font-size: 2rem;
      line-height: 1;
    }

    .orders {
      display: grid;
      grid-template-columns: repeat(3, minmax(0, 1fr));
      gap: 18px;
    }

    .card {
      position: relative;
      overflow: hidden;
      background: var(--orders-surface);
      border: 1px solid var(--orders-border);
      border-radius: 24px;
      box-shadow: 0 18px 46px rgba(31, 44, 71, 0.08);
      padding: 22px;
      transition: transform 0.22s ease, box-shadow 0.22s ease;
    }

    .card:hover {
      transform: translateY(-4px);
      box-shadow: 0 28px 68px rgba(31, 44, 71, 0.12);
    }

    .card::before {
      content: '';
      position: absolute;
      inset: 0 0 auto;
      height: 5px;
      background: linear-gradient(135deg, var(--orders-primary), var(--orders-accent));
    }

    .card h3 {
      color: var(--orders-text);
      font-size: 1.2rem;
      font-weight: 800;
      letter-spacing: -0.02em;
      margin: 0;
    }

    .order-top {
      display: flex;
      align-items: flex-start;
      justify-content: space-between;
      gap: 14px;
      margin-bottom: 18px;
      padding-bottom: 16px;
      border-bottom: 1px solid var(--orders-border);
    }

    .meta {
      display: flex;
      align-items: flex-start;
      justify-content: space-between;
      gap: 16px;
      color: var(--orders-muted);
      font-size: .92rem;
      margin: 0;
      padding: 9px 0;
      border-bottom: 1px solid rgba(231, 236, 244, 0.75);
    }

    .meta:last-of-type {
      border-bottom: 0;
    }

    .meta .label {
      display: inline-flex;
      align-items: center;
      gap: 8px;
      flex: 0 0 auto;
      color: var(--orders-muted);
      font-weight: 600;
    }

    .meta b,
    .meta .value {
      color: #273246;
      font-weight: 800;
      text-align: right;
      overflow-wrap: anywhere;
    }

    .badge {
      display: inline-flex;
      align-items: center;
      justify-content: center;
      min-height: 32px;
      padding: 7px 12px;
      border-radius: 999px;
      font-size: .8rem;
      font-weight: 800;
      white-space: nowrap;
    }

    .badge.pending {
      background: #fff4d4;
      color: #a46400;
    }

    .badge.paid {
      background: #dcfce7;
      color: #128454;
    }

    .badge.cancel {
      background: #ffe4e6;
      color: #d12b3f;
    }

    .btn-link {
      display: inline-flex;
      align-items: center;
      justify-content: center;
      gap: 8px;
      width: 100%;
      min-height: 46px;
      margin-top: 18px;
      background: linear-gradient(135deg, var(--orders-primary), var(--orders-accent));
      color: #fff;
      padding: 10px 16px;
      border-radius: 14px;
      text-decoration: none;
      font-weight: 800;
      box-shadow: 0 18px 34px rgba(255, 71, 102, 0.18);
      transition: transform .22s ease, box-shadow .22s ease;
    }

    .btn-link:hover {
      color: #fff;
      transform: translateY(-1px);
      box-shadow: 0 22px 42px rgba(255, 71, 102, 0.24);
    }

    .empty {
      padding: 42px 24px;
      text-align: center;
      color: var(--orders-muted);
      background: #fff;
      border: 1px solid var(--orders-border);
      border-radius: 24px;
      font-size: 1rem;
      box-shadow: var(--orders-shadow);
    }

    .empty a {
      color: var(--orders-primary);
      font-weight: 700;
      text-decoration: none;
    }

    .flash {
      grid-column: 1 / -1;
      margin-top: 14px;
      padding: 12px 16px;
      border-radius: 14px;
      font-weight: 700;
    }

    .flash.success {
      background: #dcfce7;
      color: #128454;
      border: 1px solid #bbf7d0;
    }

    .flash.error {
      background: #ffe4e6;
      color: #d12b3f;
      border: 1px solid #fecdd3;
    }

    @media (max-width: 1100px) {
      .orders {
        grid-template-columns: repeat(2, minmax(0, 1fr));
      }
    }

    @media (max-width: 720px) {
      .container {
        padding: 100px 14px 32px;
      }

      .page-head {
        grid-template-columns: 1fr;
        padding: 22px;
      }

      .page-summary {
        min-width: 0;
      }

      .orders {
        grid-template-columns: 1fr;
        gap: 14px;
      }

      .card {
        padding: 18px;
      }

      .meta {
        display: grid;
        gap: 4px;
      }

      .meta b,
      .meta .value {
        text-align: left;
      }

      .order-top {
        display: grid;
      }

      .order-top .badge {
        width: fit-content;
      }
    }

    @media (max-width: 768px) {
      header nav {
        display: none;
      }

      header nav.active {
        display: flex;
        position: absolute;
        top: 100%;
        right: 1rem;
        left: 1rem;
        background: #ffffff;
        border-radius: 22px;
        padding: 1rem;
        box-shadow: 0 24px 60px rgba(15, 23, 42, 0.15);
      }

      header nav.active .nav-links {
        flex-direction: column;
        width: 100%;
      }

      header nav.active .nav-links a {
        width: 100%;
        text-align: center;
      }

      .hamburger {
        display: inline-grid;
      }
    }
  </style>

</head>

<body class="orders-page">

  <header class="page-header">
    <div class="header-brand">
      <div class="brand-icon"><i class="fas fa-utensils"></i></div>
      <div>
        <span class="brand-title">Kantin G'penk</span>
      </div>
    </div>

    <div class="header-actions">
      <div class="header-nav">
        <nav aria-label="Primary navigation">
          <ul class="nav-links">
            <li><a href="<?= site_url('/'); ?>">Home</a></li>
            <li><a href="<?= site_url('menu'); ?>">Menu</a></li>
            <li><a href="<?= site_url('about'); ?>">About</a></li>
            <li><a href="<?= site_url('contact'); ?>">Contact</a></li>
          </ul>
        </nav>
      </div>

      <button class="hamburger icon-btn d-md-none" aria-label="Toggle menu" aria-expanded="false">
        <i class="fas fa-bars"></i>
      </button>
    </div>
  </header>

  <div class="container">
    <div class="page-head">
      <div>
        <span class="page-badge"><i class="fas fa-receipt"></i> Riwayat pesanan</span>
        <h2>Pesanan Saya</h2>
        <p>Pantau status pesanan, metode pengambilan, dan detail transaksi makanan favorit kamu.</p>
      </div>
      <div class="page-summary">
        <span>Total Pesanan</span>
        <strong><?= number_format(count($orders ?? []), 0, ',', '.'); ?></strong>
      </div>

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
            <div class="order-top">
              <h3>#<?= esc($o['code'] ?? $o['id']); ?></h3>
              <span
                class="badge <?= $cls; ?> order-status-badge"
                data-order-id="<?= (int)$o['id']; ?>"
                data-status="<?= esc($status); ?>"
                data-check-url="<?= site_url('p/orders/' . $o['id'] . '/check'); ?>">
                <?= esc($label); ?>
              </span>
            </div>
            <div class="meta">
              <span class="label"><i class="fas fa-calendar-alt"></i> Tanggal</span>
              <span class="value"><?= date('d M Y H:i', strtotime($o['created_at'] ?? 'now')); ?></span>
            </div>
            <div class="meta">
              <span class="label"><i class="fas fa-user"></i> Nama</span>
              <b><?= esc($o['customer_name'] ?? ($user['name'] ?? '-')); ?></b>
            </div>
            <div class="meta">
              <span class="label"><i class="fas fa-wallet"></i> Total</span>
              <b>Rp <?= number_format((int)($o['total_amount'] ?? 0), 0, ',', '.'); ?></b>
            </div>
            <div class="meta">
              <span class="label"><i class="fas fa-bag-shopping"></i> Metode</span>
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
                  <span class="label"><i class="fas fa-location-dot"></i> Lokasi</span>
                  <b><?= esc($loc); ?></b>
                </div>
              <?php endif; ?>

              <?php if (!empty($o['address_note'])): ?>
                <div class="meta">
                  <span class="label"><i class="fas fa-note-sticky"></i> Catatan</span>
                  <span class="value"><?= esc($o['address_note']); ?></span>
                </div>
              <?php endif; ?>
            <?php endif; ?>
            <a class="btn-link" href="<?= site_url('p/orders/' . $o['id']); ?>">
              <i class="fas fa-eye"></i>
              Lihat Detail
            </a>
          </div>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>
  </div>
  <script>
    window.APP_BASE = "<?= rtrim(base_url('/'), '/'); ?>/";
  </script>
  <script src="<?= base_url('assets/js/script.js?v=' . filemtime(FCPATH . 'assets/js/script.js')); ?>"></script>
  <script src="<?= base_url('assets/js/ajax-actions.js?v=' . filemtime(FCPATH . 'assets/js/ajax-actions.js')); ?>"></script>

  <script>
    (function() {
      const badges = document.querySelectorAll('.order-status-badge');
      if (!badges.length) return;

      function updateBadge(badge, data) {
        const oldStatus = badge.dataset.status || '';
        const newStatus = data.status || '';

        if (oldStatus === newStatus) return;

        badge.dataset.status = newStatus;
        badge.textContent = data.statusLabel || newStatus;
        badge.className = 'badge order-status-badge ' + (data.statusClass || '');

        badge.style.transition = 'transform .2s ease, box-shadow .2s ease';
        badge.style.transform = 'scale(1.08)';
        badge.style.boxShadow = '0 0 0 4px rgba(255, 200, 150, 0.5)';
        setTimeout(() => {
          badge.style.transform = 'scale(1)';
          badge.style.boxShadow = 'none';
        }, 220);
      }

      function pollAll() {
        badges.forEach((badge) => {
          fetch(badge.dataset.checkUrl, { cache: 'no-store' })
            .then((response) => response.ok ? response.json() : null)
            .then((data) => {
              if (data && data.ok) updateBadge(badge, data);
            })
            .catch(() => {});
        });
      }

      pollAll();
      setInterval(pollAll, 15000);
    })();
  </script>
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const hamburger = document.querySelector('.hamburger');
      const nav = document.querySelector('header nav');
      const icon = hamburger.querySelector('i');

      if (!hamburger || !nav) return;

      hamburger.addEventListener('click', function() {
        nav.classList.toggle('active');

        // toggle icon ☰ ↔ X
        if (nav.classList.contains('active')) {
          icon.classList.remove('fa-bars');
          icon.classList.add('fa-times');
        } else {
          icon.classList.remove('fa-times');
          icon.classList.add('fa-bars');
        }
      });

      // klik di luar menu → tutup
      document.addEventListener('click', function(e) {
        if (!nav.contains(e.target) && !hamburger.contains(e.target)) {
          nav.classList.remove('active');
          icon.classList.remove('fa-times');
          icon.classList.add('fa-bars');
        }
      });
    });
  </script>

</body>

</html>
