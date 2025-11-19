<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>KantinKamu - Delightful Food Experience</title>
  <link rel="stylesheet" href="<?= base_url('assets/css/style.css'); ?>">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

  <!-- ===== tambahan CSS untuk hero rotate & gambar tanpa kotak ===== -->
  <style>
    /* NAVBAR HOVER / ACTIVE (paste ke dalam <style> Anda) */
    :root {
      --nav-accent: #ff4766;
      /* warna pink/coral yang dipakai */
      --nav-text: #0b2130;
      /* warna teks default */
    }

    /* dasar navbar: buat sedikit ruang bawah supaya underline tidak "memindahkan" teks */
    header nav a {
      color: var(--nav-text);
      text-decoration: none;
      padding-bottom: 6px;
      /* ruang untuk underline */
      transition: color .22s, border-color .22s, transform .18s;
      border-bottom: 2px solid transparent;
      /* placeholder underline */
      display: inline-block;
      /* agar border-bottom hanya di bawah teks */
    }

    /* hover: semua item berubah pink + muncul underline */
    header nav a:hover {
      color: var(--nav-accent);
      border-bottom-color: var(--nav-accent);
    }

    /* jika ada class "active" di link (halaman sekarang), beri styling yang sama */
    header nav a.active {
      color: var(--nav-accent);
      border-bottom-color: var(--nav-accent);
    }

    /* opsi: beri sedikit jarak antar list item agar penekanan hover rapi */
    header nav ul {
      gap: 18px;
      display: flex;
      align-items: center;
      list-style: none;
      margin: 0;
      padding: 0;
    }

    /* responsif: di layar kecil beri padding lebih kecil supaya tetap rapi */
    @media (max-width:720px) {
      header nav a {
        padding-bottom: 4px;
      }
    }

    /* Hilangkan kotak / shadow khusus di area gambar hero & dish (CSS override) */
    .hero-image,
    .dishes .dish,
    .dishes .dish img {
      background: transparent !important;
      box-shadow: none !important;
      padding: 0 !important;
    }

    /* HERO: continuous slow rotation (non-stop) */
    .hero-image img {
      width: 100%;
      height: auto;
      object-fit: cover;
      border-radius: 12px;
      /* ubah ke 50% jika ingin lingkaran */
      box-shadow: none;
      transform-origin: 50% 50%;
      animation: kk-hero-spin 24s linear infinite;
      /* 24s = pelan */
      will-change: transform;
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

    /* DISH / POPULAR: hover rotate (lebih aman) */
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

    .dishes .dish img:hover {
      transform: rotate(360deg);
    }

    /* Jika mau agar dish juga berputar terus, ubah:
       .dishes .dish img { animation: kk-dish-spin 18s linear infinite; }
       and add keyframes kk-dish-spin like kk-hero-spin.
    */

    /* Hormati prefer-reduced-motion */
    @media (prefers-reduced-motion: reduce) {

      .hero-image img,
      .dishes .dish img {
        animation: none !important;
        transition: none !important;
        transform: none !important;
      }
    }

    /* Responsive tweak: menjaga tinggi gambar agar proporsional */
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

    /* CONTACT modal / WA button (basic styles) */
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
  </style>
  <!-- ===== end tambahan CSS ===== -->
</head>

<body>
  <?php
  // Ambil nomor dari env atau fallback
  $contactPhone = getenv('CONTACT_PHONE') ?: (isset($contactPhone) ? $contactPhone : '08123456789');
  // Normalisasi: biarkan + dan digits saja
  $telNormalized = preg_replace('/[^\d+]/', '', $contactPhone);
  // Untuk wa.me: harus tanpa + dan tanpa simbol lain. wa.me expects international format without plus, e.g. 628123...
  $waNormalized = preg_replace('/[^\d]/', '', preg_replace('/^\+/', '', $contactPhone));
  // Pesan default WhatsApp (URL-encoded)
  $waMessage = rawurlencode("Halo Admin KantinKamu, saya ingin memesan.");
  // Tampilan nomor (apa adanya)
  $telDisplay = $contactPhone;
  ?>

  <section class="quick-search">
    <div class="searchbar">
      <i class="fas fa-magnifying-glass"></i>
      <input id="qsearch" type="text" placeholder="Lagi mau mamam apa?" aria-label="Cari menu">
      <i class="fas fa-filter"></i>
    </div>

  </section>

  <?php if ($wel = session()->getFlashdata('welcome')): ?>
    <style>
      .toast {
        position: fixed;
        top: 30px;
        /* tengah atas */
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
      // otomatis hilang setelah 3.5 detik
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
      <div class="logo"><i class="fas fa-utensils"></i> KantinKamu</div>

      <nav id="nav">
        <ul>
          <li><a href="<?= base_url('/'); ?>">Home</a></li>
          <li><a href="<?= base_url('menu'); ?>">Menu</a></li>

          <!-- Contact: show modal -->
          <li><a href="https://wa.me/<?= esc($waNormalized); ?>?text=<?= esc($waMessage); ?>" id="contactLink">Contact</a></li>

          <li><a href="#">About Us</a></li>
          <li><a href="#">Gallery</a></li>
        </ul>
      </nav>

      <?php if (session('user')): ?>
        <div class="address-pill" title="Lokasi pengantaran kamu">
          <i class="fas fa-location-dot"></i>
          <span>
            <?= esc(session('user.building') ?? 'Gedung belum diatur'); ?>
            <?= esc(session('user.room') ? ' - ' . session('user.room') : ''); ?>
          </span>
        </div>
      <?php endif; ?>


      <div class="buttons">

        <?php if (session('user')): ?>
          <a href="<?= base_url('logout'); ?>" class="btn">Logout</a>
          <?php if (session('user.role') === 'admin'): ?>
            <a href="<?= base_url('admin'); ?>" class="btn btn-primary">Dashboard</a>
          <?php else: ?>
            <!-- di dalam <div class="buttons"> ... sebelum hamburger -->
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

      <!-- Hero section sama persis -->
      <section class="hero">
        <div class="hero-text">
          <h1>Temukan Keunggulan Kuliner</h1>
          <p>Rasakan pilihan hidangan terbaik yang dibuat dengan sepenuh hati. Dari bahan-bahan segar dari peternakan hingga kreasi yang menggugah selera.</p>
          <a href="<?= site_url('menu'); ?>" class="btn btn-primary">Explore Menu</a>
          <button id="orderNowBtn" class="btn btn-secondary"><i class="fas fa-phone"></i> Order Now</button>

        </div>

        <div class="hero-image">
          <!-- Hero image akan berputar non-stop -->
          <img src="<?= base_url('assets/img/1.png'); ?>" alt="Gourmet Food Selection" id="heroImage">
        </div>
      </section>

      <!-- Section Popular Menu -->
      <section class="popular-dishes" id="menu">
        <h2>Popular Menu</h2>

        <div class="dishes">
          <?php foreach ($menus as $m): ?>
            <div class="dish" data-img="<?= esc($m['image']); ?>">
              <!-- Dish image: hover akan memicu rotasi satu putaran -->
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
  <!-- letakkan sebelum <script src="assets/js/script.js"></script> -->

  <!-- CONTACT / CALL CONFIRMATION MODAL -->
  <div class="contact-modal-backdrop" id="contactModal" aria-hidden="true">
    <div class="contact-modal" role="dialog" aria-modal="true" aria-labelledby="contactModalTitle">
      <h3 id="contactModalTitle">Hubungi KantinKamu</h3>
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

  <script>
    window.APP_BASE = "<?= rtrim(base_url('/'), '/'); ?>/";
    window.ASSETS_BASE = "<?= rtrim(base_url('/'), '/'); ?>/";
  </script>

  <script src="<?= base_url('assets/js/script.js'); ?>"></script>

  <script>
    // Globals: nomor tersedia di JS via data dari PHP
    const TEL_NUMBER = "<?= esc($telNormalized); ?>";
    const TEL_DISPLAY = "<?= esc($telDisplay); ?>";
    const WA_URL = "https://wa.me/<?= esc($waNormalized); ?>?text=<?= esc($waMessage); ?>";

    // modal elements
    const contactLink = document.getElementById('contactLink');
    const orderNowBtn = document.getElementById('orderNowBtn');
    const contactModal = document.getElementById('contactModal');
    const modalPhone = document.getElementById('modalPhone');
    const modalCancel = document.getElementById('modalCancel');
    const modalCall = document.getElementById('modalCall');
    const modalWhatsApp = document.getElementById('modalWhatsApp');

    // Show modal helper
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

    // Attach events: navbar Contact and Order Now both show modal
    if (contactLink) contactLink.addEventListener('click', (e) => {
      e.preventDefault();
      showContactModal();
    });
    if (orderNowBtn) orderNowBtn.addEventListener('click', (e) => {
      e.preventDefault();
      showContactModal();
    });

    // modal buttons
    if (modalCancel) modalCancel.addEventListener('click', () => hideContactModal());
    if (modalCall) modalCall.addEventListener('click', () => {
      // direct dial
      hideContactModal();
      window.location.href = 'tel:' + TEL_NUMBER;
    });

    // Close modal on click outside modal box
    if (contactModal) {
      contactModal.addEventListener('click', (e) => {
        if (e.target === contactModal) hideContactModal();
      });
    }

    // Also capture any <a href="tel:..."> clicks and show modal instead (if you want)
    // OPTIONAL: disable default tel links to require confirmation - comment out if not wanted
    document.querySelectorAll('a[href^="tel:"]').forEach(a => {
      a.addEventListener('click', function(e) {
        // If link already points to same TEL_NUMBER, show modal; otherwise allow
        const href = this.getAttribute('href') || '';
        if (href.includes(TEL_NUMBER) || href.includes('tel:')) {
          e.preventDefault();
          showContactModal();
        }
      });
    });

    // Quick: open WA links in new tab (already target="_blank"), no extra handling needed.
  </script>

  <!-- Tambahkan keranjang (tidak mengubah tampilan) -->
  <script>
    document.querySelectorAll('.add-to-cart').forEach(btn => {
      btn.addEventListener('click', async () => {
        const payload = new URLSearchParams();
        payload.append('id', btn.dataset.id);
        payload.append('qty', '1');

        try {
          const res = await fetch('<?= base_url('cart/add'); ?>', {
            method: 'POST',
            headers: {
              'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: payload.toString()
          });

          // Jika unauthorized -> tanyakan dan arahkan ke login (browser fetch tidak auto-redirect)
          if (res.status === 401 || res.redirected || res.status === 302) {
            const go = confirm('Anda harus login terlebih dahulu untuk memesan. Buka halaman login sekarang?');
            if (go) window.location.href = '<?= site_url('login'); ?>';
            return;
          }

          // parse JSON (status bukan 401)
          const data = await res.json().catch(() => ({
            ok: false,
            msg: 'Respon tidak valid'
          }));

          if (data.ok) {
            const countEl = document.querySelector('.cart-count');
            if (countEl) countEl.textContent = parseInt(countEl.textContent || '0') + 1;
            alert('✅ Ditambahkan ke keranjang: ' + btn.dataset.name);
            if (data.redirect) window.location.href = data.redirect;
          } else {
            // Jika server mengeklaim user perlu login lewat pesan, tangani juga
            const msg = (data.msg || '').toLowerCase();
            if (msg.includes('login') || msg.includes('unauth') || msg.includes('silakan login')) {
              const go = confirm('Anda harus login terlebih dahulu untuk memesan. Buka halaman login sekarang?');
              if (go) window.location.href = '<?= site_url('login'); ?>';
              return;
            }

            alert(data.msg || 'Gagal menambah.');
            if (typeof refreshCartCount === 'function') refreshCartCount();
          }
        } catch (err) {
          console.error(err);
          alert('Terjadi kesalahan jaringan. Coba lagi.');
        }
      });
    });
    
  </script>

  <script>
    async function addToCart(id) {
      const payload = new URLSearchParams();
      payload.append('id', id);
      payload.append('qty', '1');

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
    }
    if (typeof refreshCartCount === 'function') refreshCartCount();
  </script>
</body>

</html>