<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Menu - KantinKamu</title>
  <link rel="stylesheet" href="<?= base_url('assets/css/style.css'); ?>">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
  <style>
    :root {
      --bg-page: #fdeff0;
      --hero-pale: #fdeff0;
      --text-dark: #0b2130;
      --muted: #6b7280;
      --accent: #ff4766;
      --accent-dark: #e03f5d;
      --nav-active: #ff6a4a;
      --card-bg: #ffffff;
      --card-shadow: rgba(10, 25, 40, 0.06);
      --fab-bg: #111111;
      --fab-accent: var(--accent);
      --skeleton: #f3f3f5;
      --whatsapp: #25D366;
    }

    html,
    body {
      margin: 0;
      padding: 0;
      max-width: 100%;
      overflow-x: hidden;
    }

    body {
      background: var(--bg-page) !important;
      font-family: 'Poppins', sans-serif;
      margin: 0;
      color: var(--text-dark);
    }

    header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 20px 50px;
      background: var(--bg-page);
      box-shadow: 0 2px 8px rgba(10, 25, 40, 0.03);
    }

    nav ul {
      list-style: none;
      display: flex;
      gap: 18px;
      margin: 0;
      padding: 0;
      align-items: center
    }

    nav a {
      text-decoration: none;
      color: var(--text-dark);
      font-weight: 500
    }

    nav a.active {
      color: var(--text-dark);
      border-bottom: none;
    }

    nav a:hover {
      color: var(--accent);
      border-bottom: 2px solid var(--accent);
    }

    .container {
      max-width: 1200px;
      margin: 20px auto;
      padding: 0 16px
    }

    h2 {
      text-align: center;
      margin: 10px 0 18px;
      color: var(--text-dark);
      font-weight: 700
    }

    .tabs {
      display: flex;
      gap: 8px;
      justify-content: center;
      flex-wrap: wrap;
      margin: 6px 0 18px
    }

    .tab {
      padding: .5rem .9rem;
      border-radius: 999px;
      background: #fff;
      border: 1px solid #eee;
      text-decoration: none;
      color: var(--text-dark);
      margin: .2rem;
      transition: .2s;
      font-weight: 600;
      box-shadow: 0 2px 6px rgba(10, 25, 40, 0.02);
    }

    .tab.active,
    .tab:hover {
      background: var(--accent);
      color: #fff;
      border-color: var(--accent)
    }

    .grid {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
      gap: 24px
    }

    .card {
      background: var(--card-bg);
      border-radius: 16px;
      padding: 16px;
      box-shadow: 0 6px 18px var(--card-shadow);
      text-align: center;
      display: flex;
      flex-direction: column;
      transition: transform .18s ease, box-shadow .18s ease;
    }

    .card:hover {
      transform: translateY(-6px);
      box-shadow: 0 14px 30px rgba(10, 25, 40, 0.08);
    }

    .thumb {
      position: relative;
      border-radius: 12px;
      overflow: hidden;
      background: linear-gradient(180deg, #fff 0%, #fff 60%, #faf6f8 100%)
    }

    .thumb img {
      width: 100%;
      height: 200px;
      object-fit: cover;
      display: block
    }

    .fab {
      position: absolute;
      right: 12px;
      bottom: 12px;
      width: 44px;
      height: 44px;
      border-radius: 50%;
      background: var(--accent);
      color: #fff;
      border: none;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 1.1rem;
      cursor: pointer;
      box-shadow: 0 6px 14px rgba(0, 0, 0, .18);
      transition: .18s;
      z-index: 2
    }

    .fab:hover {
      background: var(--accent-dark)
    }

    .fab:disabled {
      background: var(--fab-bg);
      cursor: not-allowed;
      color: #fff;
      opacity: 0.95
    }

    .fab i {
      pointer-events: none
    }

    .card-body {
      flex: 1 1 auto
    }

    .card h3 {
      margin: 12px 0 6px;
      color: var(--text-dark);
      font-size: 1.05rem
    }

    .card p.desc {
      color: var(--muted);
      font-size: .95rem;
      line-height: 1.35;
      display: -webkit-box;
      -webkit-line-clamp: 2;
      line-clamp: 2;
      -webkit-box-orient: vertical;
      overflow: hidden;
      min-height: 38px
    }

    .price {
      display: block;
      color: var(--accent);
      font-weight: 800;
      margin-top: 8px
    }

    .stock {
      margin-top: 8px;
      font-size: .85rem;
      color: var(--muted)
    }

    .stock.out {
      color: #c0392b
    }

    .skeleton {
      background: var(--skeleton);
      height: 260px;
      border-radius: 16px;
      animation: pulse 1.2s infinite
    }

    @keyframes pulse {
      0% {
        opacity: .6
      }

      50% {
        opacity: 1
      }

      100% {
        opacity: .6
      }
    }

    .whatsapp-btn {
      background: var(--whatsapp);
      color: #fff;
      padding: 8px 10px;
      border-radius: 8px;
      text-decoration: none;
      display: inline-flex;
      gap: 8px;
      align-items: center
    }

    .contact-modal-backdrop {
      position: fixed;
      inset: 0;
      background: rgba(0, 0, 0, .35);
      display: none;
      align-items: center;
      justify-content: center;
      z-index: 9999
    }

    .contact-modal {
      background: #fff;
      border-radius: 12px;
      padding: 18px 20px;
      max-width: 420px;
      width: 92%;
      box-shadow: 0 12px 40px rgba(0, 0, 0, .18)
    }

    .contact-modal h3 {
      margin: 0 0 8px;
      color: var(--text-dark)
    }

    .contact-modal .actions {
      display: flex;
      gap: 10px;
      margin-top: 14px;
      justify-content: flex-end
    }

    .contact-modal .phone {
      font-weight: 700;
      color: var(--text-dark);
      margin-top: 6px
    }

    .hero-panel {
      background: linear-gradient(180deg, var(--hero-pale), #fff);
      border-radius: 16px;
      padding: 36px;
      margin-bottom: 28px;
      box-shadow: 0 10px 30px rgba(10, 25, 40, 0.03);
    }

    @media (max-width:720px) {
      header {
        padding: 16px
      }

      .thumb img {
        height: 180px
      }
    }

    #deliveryModal,
    #addressModal {
      backdrop-filter: blur(3px);
      opacity: 0;
      transition: opacity .25s ease, background .25s ease;
    }

    #deliveryModal.show,
    #addressModal.show {
      opacity: 1;
    }

    #deliveryModal .contact-modal,
    #addressModal .contact-modal {
      max-width: 480px;
      border-radius: 20px;
      padding: 20px 22px;
      box-shadow: 0 18px 50px rgba(15, 23, 42, .25);
      transform: translateY(18px) scale(.94);
      opacity: 0;
      transition: transform .25s ease, opacity .25s ease;
    }

    #deliveryModal.show .contact-modal,
    #addressModal.show .contact-modal {
      transform: translateY(0) scale(1);
      opacity: 1;
    }

    #deliveryModal .delivery-options {
      display: flex;
      flex-direction: column;
      gap: 10px;
      margin-top: 4px;
    }

    #addressModal .delivery-options {
      display: none;
      margin-top: 8px;
    }

    #addressModal.open .delivery-options {
      display: flex;
      flex-direction: column;
      gap: 10px;
      max-height: 260px;
      overflow-y: auto;
    }

    .dropdown-trigger {
      border: 1px solid #e5e7eb;
      padding: 12px 14px;
      border-radius: 14px;
      display: flex;
      align-items: center;
      justify-content: space-between;
      cursor: pointer;
      background: #fff;
      font-weight: 600;
      margin-top: 4px;
    }

    .dropdown-trigger i {
      font-size: 18px;
      color: #555;
      transition: transform .25s;
    }

    #addressModal.open .dropdown-trigger i {
      transform: rotate(180deg);
    }

    #deliveryModal .delivery-pill,
    #addressModal .delivery-pill {
      width: 100%;
      border: 1px solid #e5e7eb;
      background: #fff;
      border-radius: 999px;
      padding: 10px 14px;
      display: flex;
      align-items: center;
      gap: 10px;
      cursor: pointer;
      text-align: left;
      transition: transform .18s ease, box-shadow .18s ease, border-color .18s ease, background .18s ease;
    }

    #deliveryModal .delivery-pill .icon,
    #addressModal .delivery-pill .icon {
      width: 34px;
      height: 34px;
      border-radius: 999px;
      display: flex;
      align-items: center;
      justify-content: center;
      background: #f3f4ff;
      color: #4f46e5;
      flex-shrink: 0;
    }

    #deliveryModal .delivery-pill .text,
    #addressModal .delivery-pill .text {
      display: flex;
      flex-direction: column;
      gap: 2px;
    }

    #deliveryModal .delivery-pill .title,
    #addressModal .delivery-pill .title {
      font-weight: 600;
      font-size: 0.94rem;
      color: #111827;
    }

    #deliveryModal .delivery-pill .subtitle,
    #addressModal .delivery-pill .subtitle {
      font-size: 0.8rem;
      color: #6b7280;
    }

    #deliveryModal .delivery-pill.primary .icon,
    #addressModal .delivery-pill.primary .icon {
      background: #ffe4ea;
      color: #ef4444;
    }

    #deliveryModal .delivery-pill.primary .title,
    #addressModal .delivery-pill.primary .title {
      color: #b91c1c;
    }

    #deliveryModal .delivery-pill:hover,
    #addressModal .delivery-pill:hover {
      transform: translateY(-2px);
      box-shadow: 0 10px 25px rgba(15, 23, 42, .15);
      border-color: #fecaca;
      background: #fff7f7;
    }

    #deliveryModal .delivery-pill:active,
    #addressModal .delivery-pill:active {
      transform: translateY(0);
      box-shadow: 0 4px 12px rgba(15, 23, 42, .18);
    }

    @media (max-width:480px) {

      #deliveryModal .contact-modal,
      #addressModal .contact-modal {
        padding: 18px 16px;
      }

      #deliveryModal .delivery-pill,
      #addressModal .delivery-pill {
        border-radius: 16px;
      }
    }

    .cart-burst {
      position: fixed;
      font-weight: 700;
      pointer-events: none;
      animation: cartBurst 0.6s ease-out forwards;
      z-index: 9999;
      color: var(--accent);
      text-shadow: 0 0 2px #fff;
      font-size: 1.1rem;
    }

    @keyframes cartBurst {
      from {
        transform: translate(-50%, 0);
        opacity: 1;
      }

      to {
        transform: translate(-50%, -30px);
        opacity: 0;
      }
    }

    .header-cart {
      background: transparent !important;
      border: none !important;
      box-shadow: none !important;
      padding: 0 !important;
      border-radius: 0 !important;
    }

    .header-cart i {
      font-size: 18px;
      color: var(--text-dark);
    }

    .header-cart:hover i {
      color: var(--accent);
    }
  </style>

</head>

<body>

  <?php
  $contactPhone = getenv('CONTACT_PHONE') ?: (isset($contactPhone) ? $contactPhone : '08123456789');
  $telNormalized = preg_replace('/[^\d+]/', '', $contactPhone);
  $waNormalized = preg_replace('/[^\d]/', '', preg_replace('/^\+/', '', $contactPhone));
  $waMessage = rawurlencode("Halo KantinKamu, saya ingin memesan.");
  $telDisplay = $contactPhone;
  ?>

  <header>
    <div class="logo"><i class="fas fa-utensils"></i> KantinKamu</div>
    <nav>
      <ul>
        <li><a href="<?= site_url('/'); ?>">Home</a></li>
        <li><a href="<?= site_url('menu'); ?>" class="active">Menu</a></li>
        <li><a href="https://wa.me/<?= esc($waNormalized); ?>?text=<?= esc($waMessage); ?>" id="contactLink">Contact</a></li>

        <li><a href="#">About Us</a></li>
        <li><a href="<?= site_url('p/orders'); ?>" class="btn header-cart" aria-label="Keranjang">
            <i class="fas fa-shopping-bag"></i>
            <span class="cart-count" style="display:none">0</span>
          </a></li>
      </ul>
    </nav>
  </header>

  <div class="container">
    <h2>Daftar Menu Lengkap</h2>

    <div class="tabs" id="tabs">
      <a href="#" data-slug="" class="tab">Semua</a>
      <?php foreach ($categories as $c): ?>
        <a href="#" data-slug="<?= esc($c['slug']); ?>" class="tab"><?= esc($c['name']); ?></a>
      <?php endforeach; ?>
    </div>

    <div id="menuGrid" class="grid" aria-live="polite"></div>
  </div>

  <div class="contact-modal-backdrop" id="contactModal" aria-hidden="true">
    <div class="contact-modal" role="dialog" aria-modal="true" aria-labelledby="contactModalTitle">
      <h3 id="contactModalTitle">Hubungi KantinKamu</h3>
      <div>Anda akan dihubungkan ke nomor berikut:</div>
      <div class="phone" id="modalPhone"><?= esc($telDisplay); ?></div>

      <div style="margin-top:10px"><small style="color:#666">Pilih "Ya" untuk melanjutkan panggilan seluler, atau gunakan WhatsApp.</small></div>

      <div class="actions">
        <button id="modalCancel" class="btn">Batal</button>
        <a id="modalWhatsApp" class="whatsapp-btn" href="https://wa.me/<?= esc($waNormalized); ?>?text=<?= esc($waMessage); ?>" target="_blank" rel="noopener">
          <i class="fab fa-whatsapp"></i> WhatsApp
        </a>
        <button id="modalCall" class="btn btn-primary">Ya, Panggil</button>
      </div>
    </div>
  </div>
  <div class="contact-modal-backdrop" id="deliveryModal" aria-hidden="true">
    <div class="contact-modal" role="dialog" aria-modal="true" aria-labelledby="deliveryModalTitle">
      <h3 id="deliveryModalTitle" style="margin-bottom:4px;">Pilih Metode Pengambilan</h3>
      <p style="margin:4px 0 14px;color:#6b7280;font-size:0.92rem;">
        Silakan pilih apakah pesanan akan diantar ke tempatmu atau kamu ambil sendiri di kantin.
      </p>

      <div class="delivery-options">
        <button type="button" class="delivery-pill" id="deliveryPickupBtn">
          <div class="icon">
            <i class="fas fa-store"></i>
          </div>
          <div class="text">
            <span class="title">Ambil Sendiri</span>
            <span class="subtitle">Datang ke kantin, tanpa biaya antar.</span>
          </div>
        </button>

        <button type="button" class="delivery-pill primary" id="deliveryDeliveryBtn">
          <div class="icon">
            <i class="fas fa-motorcycle"></i>
          </div>
          <div class="text">
            <span class="title">Diantar</span>
            <span class="subtitle">Pesanan diantar ke lokasi kamu.</span>
          </div>
        </button>
      </div>
    </div>
  </div>

  <div class="contact-modal-backdrop" id="addressModal" aria-hidden="true">
    <div class="contact-modal" role="dialog" aria-modal="true" aria-labelledby="addressModalTitle">
      <h3 id="addressModalTitle" style="margin-bottom:4px;">Pilih Ruangan Pengantaran</h3>
      <p style="margin:4px 0 14px;color:#6b7280;font-size:0.92rem;">
        Pilih ruangan / lokasi tempat pesanan akan diantar.
      </p>

      <?php if (!empty($addresses ?? [])): ?>

        <div class="dropdown-trigger" id="addressDropdownTrigger">
          Pilih Ruangan
          <i class="fas fa-chevron-down"></i>
        </div>

        <div class="delivery-options">
          <?php foreach (($addresses ?? []) as $addr): ?>
            <button type="button"
              class="delivery-pill address-pill"
              data-address-id="<?= esc($addr['id']); ?>">
              <div class="icon">
                <i class="fas fa-location-dot"></i>
              </div>
              <div class="text">
                <span class="title">
                  <?= esc($addr['building']); ?>
                  <?php if (!empty($addr['room'])): ?>
                    - <?= esc($addr['room']); ?>
                  <?php endif; ?>
                </span>
                <?php if (!empty($addr['note'])): ?>
                  <span class="subtitle"><?= esc($addr['note']); ?></span>
                <?php endif; ?>
              </div>
            </button>
          <?php endforeach; ?>
        </div>

      <?php else: ?>
        <p style="margin:4px 0 0;color:#ef4444;font-size:0.9rem;">
          Kamu belum menyimpan ruangan/alamat. Silakan atur dulu di profil atau informasikan ke kasir.
        </p>
        <div class="actions">
          <button type="button" id="addressModalClose" class="btn">Tutup</button>
        </div>
      <?php endif; ?>
    </div>
  </div>

  <script>
    (function() {
      const grid = document.getElementById('menuGrid');
      const tabs = Array.from(document.querySelectorAll('#tabs .tab'));

      const app = {
        api: '<?= rtrim(base_url(),  '/'); ?>', // <<< PAKAI base_url, bukan site_url
        asset: '<?= rtrim(base_url(), '/'); ?>'
      };

      const prettyBase = '<?= rtrim(base_url(), '/'); ?>';
      const activeInitial = '<?= esc($activeSlug ?? ''); ?>';

      function setActive(slug) {
        tabs.forEach(a => a.classList.toggle('active', a.dataset.slug === slug));
      }

      function money(x) {
        return new Intl.NumberFormat('id-ID').format(x);
      }

      function cardTemplate(m) {
        const img = m.image ? `${app.asset}/assets/img/${m.image}` : `${app.asset}/assets/img/placeholder.png`;
        const disabled = !(m.stock > 0);

        return `
          <div class="card">
            <div class="thumb">
              <img src="${img}" alt="${m.name}">
              ${disabled
              ? `<button class="fab" disabled title="Habis"><i class="fas fa-times"></i></button>`
              : `<button class="fab add-to-cart" data-id="${m.id}" title="Tambah ke keranjang"><i class="fas fa-plus"></i></button>`
            }
            </div>

            <div class="card-body">
              <h3>${m.name}</h3>
              <p class="desc">${m.description || ''}</p>
              <span class="price">Rp ${money(m.price)}</span>
              <div class="stock ${disabled ? 'out':''}">${disabled ? 'Habis' : 'Stok: '+m.stock}</div>
            </div>
          </div>
        `;
      }

      function showSkeleton(n = 8) {
        grid.innerHTML = Array.from({
          length: n
        }).map(() => `<div class="skeleton"></div>`).join('');
      }

      async function loadMenus(slug = '') {
        setActive(slug);
        showSkeleton();
        const url = slug ? `${app.api}/menu/json?cat=${encodeURIComponent(slug)}` : `${app.api}/menu/json`;
        const res = await fetch(url);
        const js = await res.json();
        const rows = js.data || [];
        grid.innerHTML = rows.map(cardTemplate).join('') || '<p style="text-align:center;color:#777">Belum ada menu.</p>';
        bindAddButtons();
      }

      function bindAddButtons() {
        document.querySelectorAll('.add-to-cart').forEach(btn => {
          btn.addEventListener('click', (ev) => {
            const clickX = ev.clientX;
            const clickY = ev.clientY;

            openDeliveryModal(async (deliveryMethod, addressId) => {
              const payload = new URLSearchParams();
              payload.append('id', btn.dataset.id);
              payload.append('qty', '1');
              payload.append('delivery_method', deliveryMethod);

              if (deliveryMethod === 'delivery' && addressId) {
                payload.append('delivery_address_id', addressId);
              }

              const res = await fetch('<?= base_url('cart/add'); ?>', {
                method: 'POST',
                headers: {
                  'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: payload.toString()
              });

              if (res.status === 401) {
                const go = confirm('Anda harus login terlebih dahulu untuk memesan. Buka halaman login sekarang?');
                if (go) window.location.href = '<?= site_url('login'); ?>';
                return;
              }

              const data = await res.json().catch(() => ({
                ok: false
              }));

              if (data.ok) {
                /* if (data.redirect) {
                   window.location.href = data.redirect;
                   return;
                 } */

                showCartBurst(clickX, clickY);

                const countEl = document.querySelector('.cart-count');
                if (countEl) {
                  let next;
                  if (typeof data.cart_count !== 'undefined') {
                    next = parseInt(data.cart_count, 10);
                  } else {
                    next = parseInt(countEl.textContent || '0', 10);
                    if (isNaN(next)) next = 0;
                    next += 1;
                  }
                  countEl.textContent = next;
                  if (next > 0) {
                    countEl.style.display = 'inline-block';
                  }
                }
              } else {
                alert(data.msg || 'Gagal menambahkan item.');
              }

            });
          });
        });
      }

      tabs.forEach(a => {
        a.addEventListener('click', e => {
          e.preventDefault();
          const slug = a.dataset.slug || '';
          loadMenus(slug);
          history.replaceState(null, '', slug ? `${prettyBase}/menu?cat=${slug}` : `${prettyBase}/menu`);
        });
      });

      loadMenus(activeInitial);

      const contactLink = document.getElementById('contactLink');
      const contactModal = document.getElementById('contactModal');
      const modalPhone = document.getElementById('modalPhone');
      const modalCancel = document.getElementById('modalCancel');
      const modalCall = document.getElementById('modalCall');
      const modalWhatsApp = document.getElementById('modalWhatsApp');

      const TEL_NUMBER = "<?= esc($telNormalized); ?>";
      const TEL_DISPLAY = "<?= esc($telDisplay); ?>";
      const WA_URL = "https://wa.me/<?= esc($waNormalized); ?>?text=<?= esc($waMessage); ?>";

      function showContactModal() {
        if (!contactModal) return;
        modalPhone.textContent = TEL_DISPLAY;
        modalWhatsApp.href = WA_URL;
        contactModal.style.display = 'flex';
        contactModal.setAttribute('aria-hidden', 'false');
      }

      function hideContactModal() {
        if (!contactModal) return;
        contactModal.style.display = 'none';
        contactModal.setAttribute('aria-hidden', 'true');
      }

      if (contactLink) contactLink.addEventListener('click', function(e) {
        e.preventDefault();
        showContactModal();
      });
      if (modalCancel) modalCancel.addEventListener('click', () => hideContactModal());
      if (modalCall) modalCall.addEventListener('click', () => {
        hideContactModal();
        window.location.href = 'tel:' + TEL_NUMBER;
      });

      if (contactModal) {
        contactModal.addEventListener('click', (e) => {
          if (e.target === contactModal) hideContactModal();
        });
      }

      document.querySelectorAll('a[href^="tel:"]').forEach(a => {
        a.addEventListener('click', function(e) {
          const href = this.getAttribute('href') || '';
          if (href.includes(TEL_NUMBER) || href.includes('tel:')) {
            e.preventDefault();
            showContactModal();
          }
        });
      });

      function showCartBurst(x, y) {
        if (x == null || y == null) return;
        const dot = document.createElement('div');
        dot.className = 'cart-burst';
        dot.textContent = '+1';
        dot.style.left = x + 'px';
        dot.style.top = y + 'px';
        document.body.appendChild(dot);
        setTimeout(() => dot.remove(), 650);
      }

      let pendingAddToCartCallback = null;
      let pendingAddressCallback = null;

      function openDeliveryModal(onChoice) {
        const dm = document.getElementById('deliveryModal');
        if (!dm) {
          onChoice('pickup', null);
          return;
        }
        pendingAddToCartCallback = onChoice;
        dm.style.display = 'flex';
        dm.setAttribute('aria-hidden', 'false');

        requestAnimationFrame(() => {
          dm.classList.add('show');
        });
      }

      function closeDeliveryModal() {
        const dm = document.getElementById('deliveryModal');
        if (!dm) return;

        dm.classList.remove('show');
        dm.setAttribute('aria-hidden', 'true');

        setTimeout(() => {
          dm.style.display = 'none';
        }, 220);
      }

      function openAddressModal(onSelect) {
        const am = document.getElementById('addressModal');
        if (!am) {
          onSelect(null);
          return;
        }
        const hasButtons = am.querySelectorAll('.address-pill').length > 0;
        if (!hasButtons) {
          onSelect(null);
          return;
        }

        pendingAddressCallback = onSelect;
        am.style.display = 'flex';
        am.setAttribute('aria-hidden', 'false');
        requestAnimationFrame(() => am.classList.add('show'));
      }

      function closeAddressModal() {
        const am = document.getElementById('addressModal');
        if (!am) return;

        am.classList.remove('show');
        am.setAttribute('aria-hidden', 'true');
        setTimeout(() => {
          am.style.display = 'none';
        }, 220);
      }

      (function initDeliveryModal() {
        const dm = document.getElementById('deliveryModal');
        if (dm) {
          const btnPickup = document.getElementById('deliveryPickupBtn');
          const btnDelivery = document.getElementById('deliveryDeliveryBtn');

          if (btnPickup) {
            btnPickup.addEventListener('click', () => {
              if (pendingAddToCartCallback) pendingAddToCartCallback('pickup', null);
              pendingAddToCartCallback = null;
              closeDeliveryModal();
            });
          }

          if (btnDelivery) {
            btnDelivery.addEventListener('click', () => {
              closeDeliveryModal();
              openAddressModal((addressId) => {
                if (pendingAddToCartCallback) pendingAddToCartCallback('delivery', addressId);
                pendingAddToCartCallback = null;
              });
            });
          }

          dm.addEventListener('click', (e) => {
            if (e.target === dm) {
              closeDeliveryModal();
            }
          });
        }

        const am = document.getElementById('addressModal');
        if (am) {
          am.addEventListener('click', (e) => {
            if (e.target === am) {
              closeAddressModal();
              pendingAddressCallback = null;
            }
          });

          am.addEventListener('click', (e) => {
            const btn = e.target.closest('.address-pill');
            if (!btn) return;

            const id = btn.getAttribute('data-address-id') || null;

            if (pendingAddressCallback) {
              pendingAddressCallback(id);
            }

            pendingAddressCallback = null;
            closeAddressModal();
          });

          const closeBtn = document.getElementById('addressModalClose');
          if (closeBtn) {
            closeBtn.addEventListener('click', () => {
              closeAddressModal();
              pendingAddressCallback = null;
            });
          }
        }
      })();

      const addressModalEl = document.getElementById('addressModal');
      const addressTrigger = document.getElementById('addressDropdownTrigger');

      if (addressModalEl && addressTrigger) {
        addressTrigger.addEventListener('click', () => {
          addressModalEl.classList.toggle('open');
        });
      }

    })();
  </script>
</body>
</html>