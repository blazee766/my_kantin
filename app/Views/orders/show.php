<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Detail Pesanan - Kantin G'penk</title>
  <link rel="stylesheet" href="<?= base_url('assets/css/style.css?v=' . filemtime(FCPATH . 'assets/css/style.css')); ?>">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
  <style>
    :root {
      --detail-bg: #f8fafc;
      --detail-surface: #ffffff;
      --detail-text: #172033;
      --detail-muted: #667085;
      --detail-border: #e7ecf4;
      --detail-primary: #ff4766;
      --detail-accent: #ffb703;
      --detail-danger: #ef4444;
      --detail-shadow: 0 24px 70px rgba(31, 44, 71, 0.1);
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
        linear-gradient(180deg, #ffffff 0%, var(--detail-bg) 46%, #ffffff 100%);
      margin: 0;
      font-family: 'Poppins', sans-serif;
      color: var(--detail-text);
      min-height: 100vh;
      padding: 0;
    }

    .container {
      max-width: 1280px;
      margin: 0 auto;
      padding: 126px 18px 48px;
    }

    .section {
      background: rgba(255, 255, 255, 0.92);
      border: 1px solid var(--detail-border);
      border-radius: 26px;
      box-shadow: var(--detail-shadow);
      padding: 26px 28px;
      margin: 18px 0;
      backdrop-filter: blur(16px);
      overflow: hidden;
    }

    .section h2,
    .section h3 {
      margin: 0;
      color: var(--detail-text);
      font-weight: 800;
      letter-spacing: -0.03em;
    }

    .detail-title {
      display: flex;
      align-items: flex-start;
      justify-content: space-between;
      gap: 18px;
      margin-bottom: 22px;
      padding-bottom: 18px;
      border-bottom: 1px solid var(--detail-border);
    }

    .detail-title h2 {
      font-size: clamp(1.7rem, 3vw, 2.6rem);
    }

    .order-code {
      display: inline-flex;
      align-items: center;
      gap: 8px;
      padding: 9px 14px;
      border-radius: 999px;
      background: linear-gradient(135deg, var(--detail-primary), var(--detail-accent));
      color: #fff;
      font-weight: 800;
      white-space: nowrap;
      box-shadow: 0 18px 34px rgba(255, 71, 102, 0.18);
    }

    .info-grid {
      display: grid;
      grid-template-columns: repeat(3, minmax(0, 1fr));
      gap: 14px;
    }

    p {
      color: var(--detail-muted);
      margin: 6px 0;
    }

    .info-item {
      min-width: 0;
      padding: 15px;
      border: 1px solid var(--detail-border);
      border-radius: 16px;
      background: #f8fafc;
    }

    .info-label {
      display: flex;
      align-items: center;
      gap: 8px;
      margin-bottom: 7px;
      color: var(--detail-muted);
      font-size: 0.78rem;
      font-weight: 800;
      letter-spacing: 0.04em;
      text-transform: uppercase;
    }

    .info-value {
      color: #273246;
      font-weight: 800;
      line-height: 1.35;
      overflow-wrap: anywhere;
    }

    .section-head {
      display: flex;
      align-items: center;
      justify-content: space-between;
      gap: 12px;
      margin-bottom: 18px;
    }

    .section-head h3 {
      font-size: 1.35rem;
    }

    .table-scroll {
      width: 100%;
      overflow-x: auto;
      -webkit-overflow-scrolling: touch;
      border: 1px solid var(--detail-border);
      border-radius: 16px;
      background: #fff;
    }

    table {
      width: 100%;
      border-collapse: separate;
      border-spacing: 0;
      overflow: hidden;
      min-width: 620px;
      background: #fff;
    }

    th,
    td {
      padding: 16px 18px;
      border-bottom: 1px solid var(--detail-border);
      text-align: left;
      color: var(--detail-text);
      font-size: 0.95rem;
    }

    thead th {
      font-weight: 800;
      color: #5d6678;
      background: #f4f7fb;
      text-transform: uppercase;
      letter-spacing: 0.03em;
      font-size: 0.82rem;
    }

    tbody tr:last-child td {
      border-bottom: 0;
      background: #fbfcfe;
      font-weight: 800;
    }

    .btn {
      min-height: 46px;
      padding: 10px 16px;
      border-radius: 14px;
      text-decoration: none;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      gap: 8px;
      font-weight: 800;
      cursor: pointer;
      transition: transform .22s ease, box-shadow .22s ease, background .22s ease;
    }

    .btn-primary {
      background: linear-gradient(135deg, var(--detail-primary), var(--detail-accent));
      color: #fff;
      border: none;
      box-shadow: 0 18px 34px rgba(255, 71, 102, 0.18);
    }

    .btn-primary:hover {
      color: #fff;
      transform: translateY(-1px);
      box-shadow: 0 22px 42px rgba(255, 71, 102, 0.24);
    }

    .btn-ghost {
      background: #fff;
      border: 1px solid var(--detail-border);
      color: var(--detail-text);
    }

    .btn-danger {
      background: var(--detail-danger);
      color: #fff;
      border: none;
    }

    .btn-inline {
      display: inline-flex;
      gap: 10px;
      flex-wrap: wrap;
      margin-top: 18px;
    }

    .btn-inline form {
      margin: 0;
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
      background: #fff3d6;
      color: #a26a00;
    }

    .badge.paid {
      background: #dcfce7;
      color: #128454;
    }

    .badge.cancel {
      background: #ffe4e6;
      color: #d12b3f;
    }

    .payment-pill {
      display: inline-flex;
      align-items: center;
      gap: 8px;
      padding: 7px 12px;
      border-radius: 999px;
      background: #fff4d4;
      color: #a46400;
      font-weight: 800;
      white-space: nowrap;
    }

    .payment-pill.paid {
      background: #dcfce7;
      color: #128454;
    }

    .flash {
      margin: 0 0 14px;
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

    .item-remove-form {
      margin: 0;
    }

    .btn-item-remove {
      min-height: 34px;
      padding: 6px 10px;
      border-radius: 8px;
      border: 0;
      background: #ff5566;
      color: #fff;
      font-weight: 600;
      cursor: pointer;
      display: inline-flex;
      align-items: center;
      gap: 8px;
    }

    @media (max-width: 1024px) {
      .container {
        padding-inline: 16px;
      }

      .section {
        border-radius: 22px;
        padding: 24px;
      }

      .info-grid {
        grid-template-columns: repeat(2, minmax(0, 1fr));
      }

      .btn-inline {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        align-items: stretch;
      }

      .btn-inline .btn,
      .btn-inline form,
      .btn-inline form .btn {
        width: 100%;
      }
    }

    @media (max-width:720px) {
      .container {
        padding: 100px 12px 34px;
      }

      .section {
        padding: 18px 14px;
        border-radius: 18px;
        margin: 14px 0;
      }

      .detail-title,
      .section-head {
        display: grid;
      }

      .info-grid {
        grid-template-columns: 1fr;
        gap: 10px;
      }

      th,
      td {
        padding: 12px 10px;
        font-size: 0.92rem
      }

      .btn,
      .btn-inline,
      .btn-inline form {
        width: 100%;
      }

      .btn-inline {
        display: grid;
        grid-template-columns: 1fr;
      }

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

    @media (max-width:430px) {
      .container {
        padding-inline: 10px;
      }

      .section {
        padding: 16px 12px;
      }

      .detail-title {
        gap: 12px;
        margin-bottom: 16px;
        padding-bottom: 14px;
      }

      .detail-title h2 {
        font-size: 1.45rem;
      }

      .detail-title p {
        font-size: 0.9rem;
        line-height: 1.6;
      }

      .order-code {
        width: 100%;
        justify-content: center;
        white-space: normal;
        text-align: center;
      }

      .info-item {
        padding: 13px;
        border-radius: 14px;
      }

      .section-head h3 {
        font-size: 1.2rem;
      }

      table {
        min-width: 540px;
      }

      th,
      td {
        font-size: 0.86rem;
      }
    }
  </style>

</head>

<body class="orders-page">
  <?php
  $status = $order['status'] ?? 'pending';
  $statusKey = strtolower((string) $status);

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

  $statusLabel = $labelMap[$statusKey]  ?? ucfirst((string) $status);
  $statusClass = $classMap[$statusKey] ?? 'pending';
  $canModifyOrder = in_array($statusKey, ['pending', 'menunggu'], true);
  $canModifyItem = in_array($statusKey, ['pending', 'menunggu', 'processing', 'diproses'], true);
  $canPayOrder = in_array($statusKey, ['pending', 'menunggu', 'processing', 'diproses'], true);
  $deliveryRaw  = $order['delivery_method'] ?? 'pickup';
  $deliveryText = $deliveryRaw === 'delivery'
    ? 'Diantar'
    : 'Ambil Sendiri';
  ?>

  <header class="page-header">
    <div class="header-brand">
      <div class="brand-icon has-logo"><img class="brand-logo" src="<?= base_url('assets/img/kantin-logo.svg'); ?>" alt="Logo Kantin G'penk"></div>
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
    <?php if ($msg = session()->getFlashdata('success')): ?>
      <div class="flash success"><?= esc($msg); ?></div>
    <?php endif; ?>
    <?php if ($msg = session()->getFlashdata('error')): ?>
      <div class="flash error"><?= esc($msg); ?></div>
    <?php endif; ?>

    <div class="section">
      <div class="detail-title">
        <div>
          <h2>Detail Pesanan</h2>
          <p>Pantau ringkasan pesanan, status pembayaran, dan daftar item yang kamu pesan.</p>
        </div>
        <div class="order-code"><i class="fas fa-receipt"></i>#<?= esc($order['code'] ?? $order['id']); ?></div>
      </div>

      <div class="info-grid">
        <div class="info-item">
          <span class="info-label"><i class="fas fa-calendar-alt"></i>Tanggal</span>
          <div class="info-value"><?= date('d M Y H:i', strtotime($order['created_at'] ?? 'now')); ?></div>
        </div>
        <div class="info-item">
          <span class="info-label"><i class="fas fa-user"></i>Nama</span>
          <div class="info-value"><?= esc($order['customer_name'] ?? ($user['name'] ?? '-')); ?></div>
        </div>
        <div class="info-item">
          <span class="info-label"><i class="fas fa-wallet"></i>Total</span>
          <div class="info-value">Rp <?= number_format((int)($order['total_amount'] ?? 0), 0, ',', '.'); ?></div>
        </div>
        <div class="info-item">
          <span class="info-label"><i class="fas fa-bag-shopping"></i>Metode</span>
          <div class="info-value"><?= esc($deliveryText); ?></div>
        </div>

      <?php if ($deliveryRaw === 'delivery'): ?>
        <?php
        $loc = trim(
          (string)($order['address_building'] ?? '') .
            (!empty($order['address_room']) ? ' - ' . $order['address_room'] : '')
        );
        ?>
        <?php if ($loc !== ''): ?>
          <div class="info-item">
            <span class="info-label"><i class="fas fa-location-dot"></i>Lokasi</span>
            <div class="info-value"><?= esc($loc); ?></div>
          </div>
        <?php endif; ?>

        <?php if (!empty($order['address_note'])): ?>
          <div class="info-item">
            <span class="info-label"><i class="fas fa-note-sticky"></i>Catatan</span>
            <div class="info-value"><?= esc($order['address_note']); ?></div>
          </div>
        <?php endif; ?>
      <?php endif; ?>
        <div class="info-item">
          <span class="info-label"><i class="fas fa-clock"></i>Status</span>
          <span
            id="orderStatusBadge"
            class="badge <?= $statusClass; ?>"
            data-status="<?= esc($status); ?>">
            <?= esc($statusLabel); ?>
          </span>
        </div>
        <div class="info-item">
          <span class="info-label"><i class="fas fa-credit-card"></i>Pembayaran</span>
          <span class="payment-pill <?= $paymentStatus === 'paid' ? 'paid' : ''; ?>">
            <?= $paymentStatus === 'paid' ? 'Sudah Dibayar' : 'Belum Dibayar'; ?>
          </span>
        </div>
      </div>
    </div>

    <div class="section">
      <div class="section-head">
        <h3>Item Pesanan</h3>
      </div>
      <div class="table-scroll">
        <table>
          <thead>
            <tr>
              <th>Menu</th>
              <th>Qty</th>
              <th>Harga</th>
              <th>Subtotal</th>
              <?php if ($canModifyItem): ?>
                <th>Aksi</th>
              <?php endif; ?>
            </tr>
          </thead>
          <tbody>
            <?php
            $grouped = [];

            foreach (($order['items'] ?? []) as $it) {
              $key = $it['menu_id'] ?? $it['id'] ?? $it['name'];

              $qty   = (int)($it['qty'] ?? 0);
              $price = (int)($it['price'] ?? 0);
              $sub   = (int)($it['subtotal'] ?? ($price * $qty));

              if (!isset($grouped[$key])) {
                $grouped[$key] = [
                  'menu_id'   => (int)($it['menu_id'] ?? 0),
                  'name'     => $it['name'] ?? '',
                  'qty'      => $qty,
                  'price'    => $price,
                  'subtotal' => $sub,
                ];
              } else {
                $grouped[$key]['qty']      += $qty;
                $grouped[$key]['subtotal']  = $grouped[$key]['qty'] * $grouped[$key]['price'];
              }
            }

            $grandTotal = 0;
            foreach ($grouped as $row):
              $grandTotal += $row['subtotal'];
            ?>
              <tr data-order-item-row data-menu-id="<?= (int) $row['menu_id']; ?>">
                <td><?= esc($row['name']); ?></td>
                <td data-item-qty><?= $row['qty']; ?></td>
                <td>Rp <?= number_format($row['price'], 0, ',', '.'); ?></td>
                <td data-item-subtotal>Rp <?= number_format($row['subtotal'], 0, ',', '.'); ?></td>
                <?php if ($canModifyItem): ?>
                  <td>
                    <?php if (!empty($row['menu_id'])): ?>
                      <form
                        class="item-remove-form"
                        action="<?= site_url('p/orders/' . $order['id'] . '/items/' . $row['menu_id'] . '/remove'); ?>"
                        method="post"
                        data-ajax-form
                        data-ajax-action="remove-order-item"
                        data-confirm="Hapus 1 qty menu ini dari pesanan?">
                        <?= csrf_field(); ?>
                        <button type="submit" class="btn-item-remove" title="Hapus">
                          <i class="fas fa-trash"></i>
                          <span>Hapus</span>
                        </button>
                      </form>
                    <?php endif; ?>
                  </td>
                <?php endif; ?>
              </tr>
            <?php endforeach; ?>

            <tr>
              <td style="font-weight:bold;">Total</td>
              <td></td>
              <td></td>
              <td style="font-weight:bold;" data-order-total>Rp <?= number_format($grandTotal, 0, ',', '.'); ?></td>
              <?php if ($canModifyItem): ?>
                <td></td>
              <?php endif; ?>
            </tr>
          </tbody>
        </table>
      </div>

      <div class="btn-inline">
        <a href="<?= site_url('/'); ?>" class="btn btn-ghost"><i class="fas fa-arrow-left"></i>Kembali</a>
        <?php if ($canModifyOrder): ?>
          <a href="<?= site_url('menu'); ?>" class="btn btn-primary"><i class="fas fa-plus"></i>Tambah Pesanan</a>
        <?php endif; ?>

        <?php
        if ($canPayOrder && $paymentStatus !== 'paid'): ?>
          <a href="<?= site_url('p/payment/' . $order['id']); ?>" class="btn btn-primary">
            <i class="fas fa-credit-card"></i>
            Bayar Sekarang
          </a>
        <?php endif; ?>

        <?php
        if ($canModifyOrder): ?>
          <form action="<?= site_url('p/orders/' . $order['id'] . '/delete'); ?>"
            method="post"
            data-ajax-form
            data-confirm="Yakin ingin membatalkan pesanan?"
            style="display:inline">
            <?= csrf_field(); ?>
            <button type="submit" class="btn btn-danger"><i class="fas fa-trash"></i>Hapus / Batalkan</button>
          </form>
        <?php endif; ?>
      </div>
    </div>
  </div>
  <script>
    window.APP_BASE = "<?= rtrim(base_url('/'), '/'); ?>/";
  </script>
  <script src="<?= base_url('assets/js/script.js?v=' . filemtime(FCPATH . 'assets/js/script.js')); ?>"></script>
  <script src="<?= base_url('assets/js/ajax-actions.js?v=' . filemtime(FCPATH . 'assets/js/ajax-actions.js')); ?>"></script>
  <script>
    const hamburger = document.querySelector('.hamburger');
    const nav = document.querySelector('header nav');

    if (hamburger && nav) {
      hamburger.addEventListener('click', () => {
        const opened = nav.classList.toggle('active');
        hamburger.innerHTML = opened ? '<i class="fas fa-times"></i>' : '<i class="fas fa-bars"></i>';
      });
    }

    document.addEventListener('click', (event) => {
      if (!hamburger || !nav) return;
      if (!nav.classList.contains('active')) return;
      if (nav.contains(event.target) || hamburger.contains(event.target)) return;

      nav.classList.remove('active');
      hamburger.innerHTML = '<i class="fas fa-bars"></i>';
    });

    
    (function() {
      const badge = document.getElementById('orderStatusBadge');
      if (!badge) return;

      const orderId = <?= (int) $order['id']; ?>;
      const checkUrl = "<?= site_url('p/orders/' . $order['id'] . '/check'); ?>";

      function updateBadge(data) {
        const oldStatus = badge.dataset.status || '';
        const newStatus = data.status || '';

        if (!newStatus || oldStatus === newStatus) return;

        badge.dataset.status = newStatus;
        badge.textContent = data.statusLabel || newStatus;
        badge.className = 'badge ' + (data.statusClass || 'pending');

        if (['processing', 'diproses'].includes(newStatus.toLowerCase())) {
          setTimeout(() => window.location.reload(), 400);
        }
      }

      function pollStatus() {
        fetch(checkUrl, { cache: 'no-store' })
          .then((response) => response.ok ? response.json() : null)
          .then((data) => {
            if (data && data.ok) updateBadge(data);
          })
          .catch(() => {});
      }

      pollStatus();
      setInterval(pollStatus, 15000);
    })();
    
  </script>
</body>
</html>
