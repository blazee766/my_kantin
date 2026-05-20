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
      font-family: 'Poppins', sans-serif;
      background: radial-gradient(circle at top, rgba(255, 255, 255, 1), rgba(248, 250, 252, 1) 48%);
    }

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
</head>

<body class="home-page">
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

    <header class="page-header">
      <div class="header-brand">
        <div class="brand-icon"><i class="fas fa-utensils"></i></div>
        <div>
          <span class="brand-title">Kantin G'penk</span>
          <span class="brand-subtitle">Pesan makanan & minuman modern</span>
        </div>
      </div>

      <div class="header-actions">
        <div class="header-nav">
          <nav aria-label="Primary navigation">
            <ul class="nav-links">
              <li><a href="<?= base_url('/'); ?>">Home</a></li>
              <li><a href="<?= base_url('menu'); ?>">Menu</a></li>
              <li><a href="<?= base_url('about'); ?>">About</a></li>
              <li><a href="<?= site_url('contact'); ?>">Contact</a></li>
            </ul>
          </nav>
        </div>

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

        <?php if (session('user')): ?>
          <a href="<?= base_url('logout'); ?>" class="btn">Logout</a>
          <?php if (session('user.role') === 'admin'): ?>
            <a href="<?= base_url('admin'); ?>" class="btn btn-primary">Dashboard</a>
          <?php else: ?>
            <a href="<?= site_url('p/orders'); ?>" class="icon-btn header-cart" aria-label="Keranjang">
              <i class="fas fa-shopping-bag"></i>
              <span class="badge cart-count">0</span>
            </a>
          <?php endif; ?>
        <?php else: ?>
          <a href="<?= base_url('login'); ?>" class="btn btn-outline">Sign In</a>
          <a href="<?= base_url('register'); ?>" class="btn btn-outline">Sign Up</a>
        <?php endif; ?>

        <button class="hamburger icon-btn d-md-none" id="hamburger" aria-label="Toggle menu">
          <i class="fas fa-bars"></i>
        </button>
      </div>
    </header>

    <main>
      <?php if (session()->getFlashdata('success')): ?>
        <div class="flash-alert">
          <?= esc(session()->getFlashdata('success')); ?>
        </div>
      <?php endif; ?>

      <section class="hero-section">
        <div class="hero-content">
          <div class="hero-copy">
            <span class="badge rounded-pill px-3 py-2 hero-chip">Startup Food Experience</span>
            <h1>Temukan Kelezatan Sehari-hari Anak Kampus</h1>
            <p>Rasakan hidangan favorit mahasiswa dengan cita rasa rumahan yang selalu ngangenin. Dari menu simpel penyelamat tanggal tua hingga pilihan kenyang sebelum kelas, semua dibuat dengan penuh kehangatan dan harga yang tetap bersahabat untuk kantong mahasiswa.</p>

            <div class="hero-actions">
              <a href="<?= site_url('menu'); ?>" class="btn btn-primary">Explore Menu</a>
              <button id="orderNowBtn" class="btn btn-secondary"><i class="fas fa-phone"></i> Order Now</button>
            </div>

            <div class="hero-stats">
              <div class="hero-stat">
                <strong>4.9/5</strong>
                <span>Review pelanggan</span>
              </div>
              <div class="hero-stat">
                <strong>120+</strong>
                <span>Menu pilihan</span>
              </div>
              <div class="hero-stat">
                <strong>256</strong>
                <span>Pesanan hari ini</span>
              </div>
            </div>
          </div>

          <div class="hero-visual">
            <img src="<?= base_url('assets/img/13-1765157815.png'); ?>" alt="Gourmet Food Selection">
          </div>
        </div>
      </section>

      <section class="popular-dishes" id="menu">
        <div class="section-header">
          <div>
            <h2>Menu Terlaris</h2>
            <p>Pilihan favorit pelanggan yang paling sering dipesan hari ini.</p>
          </div>
        </div>

        <div class="dishes home-menu-grid">
          <?php foreach ($menus as $m): ?>
            <?php
            $stock = (int)($m['stock'] ?? 0);
            $stockClass = $stock <= 0 ? 'out' : ($stock <= 5 ? 'low' : 'available');
            $stockLabel = $stock > 0 ? $stock . ' tersisa' : 'Habis';
            ?>
            <article class="menu-card animate-fade" data-img="<?= esc($m['image']); ?>">
              <div class="thumb">
                <img src="<?= base_url('assets/img/' . esc($m['image'])); ?>" alt="<?= esc($m['name']); ?>">
                <span class="badge-popular">Populer</span>
                <button class="btn-add <?= $stock > 0 ? 'add-to-cart' : 'disabled'; ?>"
                  data-id="<?= $m['id']; ?>"
                  data-name="<?= esc($m['name']); ?>"
                  data-price="<?= $m['price']; ?>"
                  <?= $stock > 0 ? '' : 'disabled'; ?>
                  aria-label="<?= $stock > 0 ? 'Tambah ' . esc($m['name']) . ' ke keranjang' : esc($m['name']) . ' habis'; ?>">
                  <i class="fas <?= $stock > 0 ? 'fa-plus' : 'fa-ban'; ?>"></i>
                </button>
              </div>
              <div class="card-body">
                <h3><?= esc(ucwords($m['name'])); ?></h3>
                <p class="desc"><?= esc($m['description'] ?: 'Menu favorit pelanggan untuk dinikmati kapan saja.'); ?></p>
                <div class="meta">
                  <span class="category"><i class="fas fa-fire"></i>Terlaris</span>
                  <span class="rating"><i class="fas fa-star"></i><strong>4.8</strong></span>
                </div>
                <div class="price-row">
                  <span class="price">Rp <?= number_format($m['price'], 0, ',', '.'); ?></span>
                  <span class="stock-badge <?= esc($stockClass); ?>"><?= esc($stockLabel); ?></span>
                </div>
              </div>
            </article>
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

      <div class="modal-note">
        Pilih "Ya" untuk melanjutkan panggilan seluler, atau gunakan WhatsApp.
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
      <h3 id="deliveryModalTitle" class="modal-heading">Pilih Metode Pengambilan</h3>
      <p class="modal-description">
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
      <h3 id="addressModalTitle" class="modal-heading">Pilih Ruangan Pengantaran</h3>
      <p class="modal-description">
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
        <p class="alert-text">
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
              if (typeof window.setCartCount === 'function' && typeof data.cart_count !== 'undefined') {
                window.setCartCount(data.cart_count);
              } else if (typeof window.refreshCartCount === 'function') {
                window.refreshCartCount();
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
        if (data.ok) {
          if (typeof window.setCartCount === 'function' && typeof data.cart_count !== 'undefined') {
            window.setCartCount(data.cart_count);
          } else if (typeof window.refreshCartCount === 'function') {
            window.refreshCartCount();
          }
        }
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
  <script>
    const hamburger = document.getElementById('hamburger');
    const nav = document.getElementById('nav');
    const icon = hamburger.querySelector('i');

    hamburger.addEventListener('click', () => {
      nav.classList.toggle('active');

      if (nav.classList.contains('active')) {
        icon.classList.remove('fa-bars');
        icon.classList.add('fa-times'); // jadi X
      } else {
        icon.classList.remove('fa-times');
        icon.classList.add('fa-bars'); // balik ☰
      }
    });

    // auto close saat klik menu
    document.querySelectorAll('#nav a').forEach(link => {
      link.addEventListener('click', () => {
        nav.classList.remove('active');
        icon.classList.remove('fa-times');
        icon.classList.add('fa-bars');
      });
    });
  </script>

</body>

</html>
