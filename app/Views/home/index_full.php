<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>KantinG'penk - Delightful Food Experience</title>
  <link rel="stylesheet" href="<?= base_url('assets/css/style.css'); ?>">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

  <style>
    :root {
      --nav-accent: #ff4766;
      --nav-text: #0b2130;
    }

    html,
    body {
      margin: 0;
      padding: 0;
      max-width: 100%;
      overflow-x: hidden;
    }

    header nav a {
      color: var(--nav-text);
      text-decoration: none;
      padding-bottom: 6px;
      transition: color .22s, border-color .22s, transform .18s;
      border-bottom: 2px solid transparent;
      display: inline-block;
    }

    header nav a:hover {
      color: var(--nav-accent);
      border-bottom-color: var(--nav-accent);
    }

    header nav a.active {
      color: var(--nav-accent);
      border-bottom-color: var(--nav-accent);
    }

    header nav ul {
      gap: 18px;
      display: flex;
      align-items: center;
      list-style: none;
      margin: 0;
      padding: 0;
    }

    @media (max-width:720px) {
      header nav a {
        padding-bottom: 4px;
      }
    }

    .hero-image,
    .dishes .dish,
    .dishes .dish img {
      background: transparent !important;
      box-shadow: none !important;
      padding: 0 !important;
    }

    .hero-image img {
      width: 100%;
      height: auto;
      object-fit: cover;
      border-radius: 12px;
      box-shadow: none;
      transform-origin: 50% 50%;
      animation: kk-hero-spin 40s linear infinite;
      display: block;
    }

    @keyframes kk-hero-spin {
      from {
        transform: rotate(0deg);
      }

      to {
        transform: rotate(360deg);
      }
    }

    .dishes .dish img {
      width: 100%;
      height: 140px;
      object-fit: cover;
      border-radius: 12px;
      transition: transform 1.6s cubic-bezier(.2, .9, .2, 1);
      transform-origin: 50% 50%;
      will-change: transform;
      box-shadow: none;
      background: transparent;
      display: block;
    }

    @media (min-width:560px) {
      .hero-image {
        max-width: 460px;
      }

      .dishes .dish img {
        height: 150px;
      }
    }

    @media (min-width:768px) {
      .hero-image {
        max-width: 520px;
      }

      .dishes .dish img {
        height: 160px;
      }
    }

    .whatsapp-btn {
      background: #25D366;
      color: #fff;
      border-radius: 8px;
      padding: 8px 12px;
      display: inline-flex;
      align-items: center;
      gap: 8px;
      text-decoration: none
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
      margin: 0 0 8px
    }

    .contact-modal .actions {
      display: flex;
      gap: 10px;
      margin-top: 14px;
      justify-content: flex-end
    }

    .contact-modal .phone {
      font-weight: 700;
      color: #111;
      margin-top: 6px
    }

    @media (max-width:480px) {
      .contact-modal {
        padding: 14px
      }

      .whatsapp-btn {
        padding: 7px 10px
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

    #addressModal .delivery-options::-webkit-scrollbar-thumb:hover {
      background: #9ca3af;
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

    header {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      z-index: 999;

      display: flex;
      align-items: center;
      justify-content: space-between;
      padding: 18px 50px;
      background: #ffffff;
    }

    .logo {
      display: flex;
      align-items: center;
      gap: 8px;
      font-weight: 700;
      font-size: 20px;
    }

    .logo i {
      font-size: 22px;
      color: #ff4766;
    }

    .container {
      padding-top: 110px;
    }

    @media (max-width: 720px) {
      .container {
        padding-top: 95px;
      }

    }
  </style>
</head>

<body>
  <?php
  $contactPhone = getenv('CONTACT_PHONE') ?: (isset($contactPhone) ? $contactPhone : '08123456789');
  $telNormalized = preg_replace('/[^\d+]/', '', $contactPhone);
  $waNormalized = preg_replace('/[^\d]/', '', preg_replace('/^\+/', '', $contactPhone));
  $waMessage = rawurlencode("Halo Admin Kantin G'penk, saya ingin memesan.");
  $telDisplay = $contactPhone;
  ?>

  <?php if ($wel = session()->getFlashdata('welcome')): ?>
    <style>
      .toast {
        position: fixed;
        top: 30px;
        left: 50%;
        transform: translateX(-50%);
        background: #fff;
        border-left: 6px solid #FF6B35;
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15);
        border-radius: 16px;
        padding: 16px 28px;
        display: flex;
        align-items: center;
        gap: 12px;
        z-index: 9999;
        opacity: 0;
        animation: fadeSlide 0.6s forwards;
      }

      .toast .icon {
        background: #FFE7DE;
        width: 42px;
        height: 42px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
        color: #FF6B35;
      }

      .toast .msg {
        font-weight: 600;
        color: #333;
        font-size: 1rem;
      }

      @keyframes fadeSlide {
        from {
          opacity: 0;
          transform: translate(-50%, -20px);
        }

        to {
          opacity: 1;
          transform: translate(-50%, 0);
        }
      }

      .toast.hide {
        animation: fadeOut 0.5s forwards;
      }

      @keyframes fadeOut {
        to {
          opacity: 0;
          transform: translate(-50%, -20px);
        }
      }
    </style>

    <div class="toast" id="welcomeToast">
      <div class="icon"><i class="fas fa-smile"></i></div>
      <div class="msg"><?= esc($wel) ?></div>
    </div>

    <script>
      setTimeout(() => {
        const toast = document.getElementById('welcomeToast');
        if (toast) {
          toast.classList.add('hide');
          setTimeout(() => toast.remove(), 500);
        }
      }, 3600);
    </script>
  <?php endif; ?>


  <div class="container">

    <header>
      <div class="logo"><i class="fas fa-utensils"></i> Kantin G'penk</div>

      <nav id="nav">
        <ul>
          <li><a href="<?= base_url('/'); ?>">Home</a></li>
          <li><a href="<?= base_url('menu'); ?>">Menu</a></li>
          <li><a href="https://wa.me/<?= esc($waNormalized); ?>?text=<?= esc($waMessage); ?>" id="contactLink">Contact</a></li>
          <li><a href="<?= base_url('about'); ?>">About Us</a></li>
        </ul>
      </nav>

      <?php if (session('user')): ?>
        <div class="address-pill" title="Lokasi pengantaran kamu">
          <i class="fas fa-location-dot"></i>
          <span>
            <?php
            if (session('delivery_display')) {
              echo esc(session('delivery_display'));
            } elseif (session('user.building')) {
              $txt = session('user.building');
              if (session('user.room')) {
                $txt .= ' - ' . session('user.room');
              }
              echo esc($txt);
            } else {
              echo 'Gedung belum diatur';
            }
            ?>
          </span>
        </div>
      <?php endif; ?>


      <div class="buttons">

        <?php if (session('user')): ?>
          <a href="<?= base_url('logout'); ?>" class="btn">Logout</a>
          <?php if (session('user.role') === 'admin'): ?>
            <a href="<?= base_url('admin'); ?>" class="btn btn-primary">Dashboard</a>
          <?php else: ?>
            <a href="<?= site_url('p/orders'); ?>" class="btn header-cart" aria-label="Keranjang">
              <i class="fas fa-shopping-bag"></i>
              <span class="cart-count" style="display:none">0</span>
            </a>
          <?php endif; ?>
        <?php else: ?>
          <a href="<?= base_url('login'); ?>" class="btn">Sign In</a>
          <a href="<?= base_url('register'); ?>" class="btn btn-primary">Sign Up</a>
        <?php endif; ?>

        <div class="hamburger" id="hamburger">
          <i class="fas fa-bars"></i>
        </div>

      </div>
    </header>

    <main>
      <?php if (session()->getFlashdata('success')): ?>
        <div style="text-align:center;background:#fffae6;color:#333;padding:10px;border-radius:8px;margin-top:10px;">
          <?= esc(session()->getFlashdata('success')); ?>
        </div>
      <?php endif; ?>

      <section class="hero">
        <div class="hero-text">
          <h1>Temukan Kelezatan Sehari-hari Anak Kampus</h1>
          <p>Rasakan hidangan favorit mahasiswa dengan cita rasa rumahan yang selalu ngangenin.
            Dari menu simpel penyelamat tanggal tua hingga pilihan kenyang sebelum kelas, semua dibuat dengan penuh kehangatan dan harga yang tetap bersahabat untuk kantong mahasiswa.</p>
          <a href="<?= site_url('menu'); ?>" class="btn btn-primary">Explore Menu</a>
          <button id="orderNowBtn" class="btn btn-secondary"><i class="fas fa-phone"></i> Order Now</button>
        </div>

        <div class="hero-image">
          <img src="<?= base_url('assets/img/13-1765157815.png'); ?>" alt="Gourmet Food Selection" id="heroImage">
        </div>
      </section>

      <section class="popular-dishes" id="menu">
        <h2>Menu Terlaris</h2>

        <div class="dishes">
          <?php foreach ($menus as $m): ?>
            <div class="dish" data-img="<?= esc($m['image']); ?>">
              <img src="<?= base_url('assets/img/' . esc($m['image'])); ?>" alt="<?= esc($m['name']); ?>">
              <h3><?= esc(ucwords($m['name'])); ?></h3>
              <p><?= esc($m['description']); ?></p>
              <span class="price">Rp <?= number_format($m['price'], 0, ',', '.'); ?></span>
              <button class="add-to-cart"
                data-id="<?= $m['id']; ?>"
                data-name="<?= esc($m['name']); ?>"
                data-price="<?= $m['price']; ?>">
                <i class="fas fa-plus"></i>
              </button>
            </div>
          <?php endforeach; ?>
        </div>
      </section>
    </main>
  </div>

  <div class="contact-modal-backdrop" id="contactModal" aria-hidden="true">
    <div class="contact-modal" role="dialog" aria-modal="true" aria-labelledby="contactModalTitle">
      <h3 id="contactModalTitle">Hubungi Kantin G'penk</h3>
      <div>Anda akan dihubungkan ke nomor berikut:</div>
      <div class="phone" id="modalPhone"><?= esc($telDisplay); ?></div>

      <div style="margin-top:10px">
        <small style="color:#666">Pilih "Ya" untuk melanjutkan panggilan seluler, atau gunakan WhatsApp.</small>
      </div>

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
                  <?php if (!empty($addr['room'])): ?> - <?= esc($addr['room']); ?><?php endif; ?>
                </span>
              </div>
            </button>
          <?php endforeach; ?>
        </div>

      <?php else: ?>
        <p style="margin:4px 0 0;color:#ef4444;font-size:0.9rem;">
          Kamu belum menyimpan ruangan/alamat. Silakan atur dulu di profil.
        </p>
        <div class="actions">
          <button type="button" id="addressModalClose" class="btn">Tutup</button>
        </div>
      <?php endif; ?>
    </div>
  </div>

  <script>
    window.APP_BASE = "<?= rtrim(base_url('/'), '/'); ?>/";
    window.ASSETS_BASE = "<?= rtrim(base_url('/'), '/'); ?>/";
  </script>

  <script src="<?= base_url('assets/js/script.js'); ?>"></script>

  <script>
    document.addEventListener('DOMContentLoaded', () => {
      const heroImg = document.getElementById('heroImage');
      if (!heroImg) return;

      const originalSrc = heroImg.src;

      document.querySelectorAll('.dishes .dish').forEach(card => {
        card.addEventListener('mouseenter', () => {
          heroImg.src = originalSrc;
        });
        card.addEventListener('mouseleave', () => {
          heroImg.src = originalSrc;
        });
      });
    });
  </script>


  <script>
    const TEL_NUMBER = "<?= esc($telNormalized); ?>";
    const TEL_DISPLAY = "<?= esc($telDisplay); ?>";
    const WA_URL = "https://wa.me/<?= esc($waNormalized); ?>?text=<?= esc($waMessage); ?>";

    const contactLink = document.getElementById('contactLink');
    const orderNowBtn = document.getElementById('orderNowBtn');
    const contactModal = document.getElementById('contactModal');
    const modalPhone = document.getElementById('modalPhone');
    const modalCancel = document.getElementById('modalCancel');
    const modalCall = document.getElementById('modalCall');
    const modalWhatsApp = document.getElementById('modalWhatsApp');

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

    if (contactLink) contactLink.addEventListener('click', (e) => {
      e.preventDefault();
      showContactModal();
    });
    if (orderNowBtn) orderNowBtn.addEventListener('click', (e) => {
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
  </script>

  <script>
    document.querySelectorAll('.add-to-cart').forEach(btn => {
      btn.addEventListener('click', () => {
        openDeliveryModal(async (deliveryMethod, addressId) => {
          const payload = new URLSearchParams();
          payload.append('id', btn.dataset.id);
          payload.append('qty', '1');
          payload.append('delivery_method', deliveryMethod);

          if (deliveryMethod === 'delivery' && addressId) {
            payload.append('delivery_address_id', addressId);
          }

          try {
            const res = await fetch('<?= base_url('cart/add'); ?>', {
              method: 'POST',
              headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
              },
              body: payload.toString()
            });
            if (res.status === 401 || res.redirected || res.status === 302) {
              const go = confirm('Anda harus login terlebih dahulu untuk memesan. Buka halaman login sekarang?');
              if (go) window.location.href = '<?= site_url('login'); ?>';
              return;
            }

            const data = await res.json().catch(() => ({
              ok: false,
              msg: 'Respon tidak valid'
            }));

            if (data.ok) {
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
              const msg = (data.msg || '').toLowerCase();
              if (msg.includes('login') || msg.includes('unauth') || msg.includes('silakan login')) {
                const go = confirm('Anda harus login terlebih dahulu untuk memesan. Buka halaman login sekarang?');
                if (go) window.location.href = '<?= site_url('login'); ?>';
                return;
              }

              alert(data.msg || 'Gagal menambah.');
            }

          } catch (err) {
            console.error(err);
            alert('Terjadi kesalahan jaringan. Coba lagi.');
          }

        });
      });
    });
  </script>

  <script>
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
      requestAnimationFrame(() => {
        am.classList.add('show');
      });
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


    document.addEventListener('DOMContentLoaded', () => {
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
              if (pendingAddToCartCallback) {
                pendingAddToCartCallback('delivery', addressId);
              }
              pendingAddToCartCallback = null;
            });
          });
        }
        dm.addEventListener('click', (e) => {
          if (e.target === dm) closeDeliveryModal();
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

        am.querySelectorAll('.address-pill').forEach(btn => {
          btn.addEventListener('click', () => {
            const id = btn.getAttribute('data-address-id') || null;
            if (pendingAddressCallback) pendingAddressCallback(id);
            pendingAddressCallback = null;
            closeAddressModal();
          });
        });

        const closeBtn = document.getElementById('addressModalClose');
        if (closeBtn) {
          closeBtn.addEventListener('click', () => {
            closeAddressModal();
            pendingAddressCallback = null;
          });
        }
      }
    });
  </script>

  <script>
    async function addToCart(id) {
      openDeliveryModal(async (deliveryMethod, addressId) => {
        const payload = new URLSearchParams();
        console.log("PAYLOAD:", deliveryMethod, addressId);
        payload.append('id', id);
        payload.append('qty', '1');
        payload.append('delivery_method', deliveryMethod);
        if (deliveryMethod === 'delivery' && addressId) {
          payload.append('delivery_address_id', addressId);
        }

        const res = await fetch('<?= site_url('cart/add'); ?>', {
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
        alert(data.ok ? 'Ditambahkan ke keranjang' : (data.msg || 'Gagal menambah'));
      });
    }
    if (typeof refreshCartCount === 'function') refreshCartCount();
  </script>
  <script>
    const addressModalEl = document.getElementById('addressModal');
    const addressTrigger = document.getElementById('addressDropdownTrigger');

    if (addressModalEl && addressTrigger) {
      addressTrigger.addEventListener('click', () => {
        addressModalEl.classList.toggle('open');
      });
    }
  </script>
</body>

</html>