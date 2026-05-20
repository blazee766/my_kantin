<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
  <title>Menu - Kantin G'penk</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Lc4Sh8vYObQf/jdNwWfLuWbD0/4K4sK1sFVI+EZ7D0kXh+ctSBEHfNXc2r4+No8x" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link rel="stylesheet" href="<?= base_url('assets/css/style.css'); ?>">

</head>

<body class="menu-page">

  <?php
  $contactPhone = getenv('CONTACT_PHONE') ?: (isset($contactPhone) ? $contactPhone : '08123456789');
  $telNormalized = preg_replace('/[^\d+]/', '', $contactPhone);
  $waNormalized = preg_replace('/[^\d]/', '', preg_replace('/^\+/', '', $contactPhone));
  $waMessage = rawurlencode("Halo Kantin G'penk, saya ingin memesan.");
  $telDisplay = $contactPhone;
  ?>

  <header class="page-header">
    <div class="header-brand">
      <div class="brand-icon"><i class="fas fa-utensils"></i></div>
      <div>
        <span class="brand-title">Kantin G'penk</span>
        <span class="brand-subtitle">Pesan makanan & minuman modern</span>
      </div>
    </div>

    <div class="search-wrapper">
      <input type="search" id="menuSearch" placeholder="Cari menu favorit" aria-label="Cari menu">
      <button type="button" id="menuSearchBtn" class="search-submit" aria-label="Cari menu">
        <i class="fas fa-search"></i>
      </button>
    </div>

    <div class="header-actions">
      <button type="button" id="searchToggle" class="icon-btn d-md-none" aria-label="Buka pencarian">
        <i class="fas fa-search"></i>
      </button>

      <div class="header-nav">
        <nav aria-label="Primary navigation">
          <ul class="nav-links">
            <li><a href="<?= site_url('/'); ?>">Home</a></li>
            <li><a href="<?= site_url('menu'); ?>" class="active">Menu</a></li>
            <li><a href="<?= site_url('about'); ?>">About</a></li>
            <li><a href="<?= site_url('contact'); ?>">Contact</a></li>
          </ul>
        </nav>
      </div>

      <a href="<?= site_url('p/orders'); ?>" class="icon-btn header-cart" aria-label="Keranjang">
        <i class="fas fa-shopping-bag"></i>
        <span class="badge cart-count">0</span>
      </a>

      <button class="hamburger icon-btn d-md-none" aria-label="Toggle menu">
        <i class="fas fa-bars"></i>
      </button>
    </div>
  </header>

  <main class="container py-4">
    <section class="hero-section">
      <div class="hero-content">
        <div class="hero-copy">
          <span class="badge rounded-pill px-3 py-2 hero-chip">Startup Food Experience</span>
          <h1>Jelajahi menu segar dan langsung pesan dengan cepat.</h1>
          <p>Desain baru yang bersih, responsif, dan terasa seperti aplikasi GoFood / ShopeeFood premium. Cari makanan favorit dan tambahkan ke keranjang dalam satu klik.</p>

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
          <img src="<?= base_url('assets/img/makanan.jpg'); ?>" alt="Menu Kantin G'penk premium">
        </div>
      </div>
    </section>

    <section class="menu-overview">
      <div class="section-header">
        <div>
          <h2>Daftar Menu Lengkap</h2>
          <p>Gunakan kategori dan pencarian untuk menemukan makanan dan minuman yang paling cocok untuk kamu.</p>
        </div>
      </div>

      <div class="tabs" id="tabs">
        <a href="#" data-slug="" class="tab active">Semua</a>
        <?php foreach ($categories as $c): ?>
          <a href="#" data-slug="<?= esc($c['slug']); ?>" class="tab"><?= esc($c['name']); ?></a>
        <?php endforeach; ?>
      </div>

      <div id="menuGrid" class="grid" aria-live="polite"></div>
    </section>
  </main>

  <div class="contact-modal-backdrop" id="contactModal" aria-hidden="true">
    <div class="contact-modal" role="dialog" aria-modal="true" aria-labelledby="contactModalTitle">
      <h3 id="contactModalTitle">Hubungi Kantin G'penk</h3>
      <div>Anda akan dihubungkan ke nomor berikut:</div>
      <div class="phone" id="modalPhone"><?= esc($telDisplay); ?></div>

      <div class="modal-note">Pilih "Ya" untuk melanjutkan panggilan seluler, atau gunakan WhatsApp.</div>

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

        <div class="delivery-options hidden" id="addressDropdownMenu">
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
    (function() {
      const grid = document.getElementById('menuGrid');
      const tabsContainer = document.getElementById('tabs');
      let tabs = Array.from(document.querySelectorAll('#tabs .tab'));
      const searchInput = document.getElementById('menuSearch');
      const searchButton = document.getElementById('menuSearchBtn');
      const searchToggle = document.getElementById('searchToggle');
      const header = document.querySelector('.page-header');
      const hamburger = document.querySelector('.hamburger');
      const mobileNav = document.querySelector('header nav');

      const app = {
        api: '<?= rtrim(base_url(),  '/'); ?>',
        asset: '<?= rtrim(base_url(), '/'); ?>'
      };

      function syncTabs() {
        tabs = Array.from(document.querySelectorAll('#tabs .tab'));
        tabs.forEach(tab => {
          tab.onclick = (e) => {
            e.preventDefault();
            const slug = tab.dataset.slug || '';
            currentSlug = slug;
            loadMenus(slug, currentQuery);
            history.replaceState(null, '', slug ? `${prettyBase}/menu?cat=${slug}` : `${prettyBase}/menu`);
          };
        });
      }

      function renderTabs(categories, activeSlug = '') {
        if (!tabsContainer || !Array.isArray(categories)) return;
        const allCategories = [{
          slug: '',
          name: 'Semua'
        }, ...categories];
        tabsContainer.innerHTML = allCategories.map(cat => `
          <a href="#" data-slug="${cat.slug}" class="tab${cat.slug === activeSlug ? ' active' : ''}">${cat.name}</a>
        `).join('');
        syncTabs();
      }

      function setCategoryLoading(isLoading) {
        tabs.forEach(tab => tab.classList.toggle('loading', isLoading));
      }

      const prettyBase = '<?= rtrim(base_url(), '/'); ?>';
      const activeInitial = '<?= esc($activeSlug ?? ''); ?>';

      let currentSlug = activeInitial || '';
      let currentQuery = '';

      if (searchToggle && searchInput) {
        searchToggle.addEventListener('click', () => {
          const opened = document.body.classList.toggle('search-open');
          if (opened) {
            searchInput.focus();
          } else {
            searchInput.blur();
          }
        });
      }

      if (hamburger && mobileNav) {
        hamburger.addEventListener('click', () => {
          const opened = mobileNav.classList.toggle('active');
          hamburger.innerHTML = opened ? '<i class="fas fa-times"></i>' : '<i class="fas fa-bars"></i>';
        });
      }

      document.addEventListener('click', (event) => {
        if (!mobileNav || !hamburger) return;
        const isOpen = mobileNav.classList.contains('active');
        if (!isOpen) return;
        if (mobileNav.contains(event.target) || hamburger.contains(event.target)) return;
        mobileNav.classList.remove('active');
        hamburger.innerHTML = '<i class="fas fa-bars"></i>';
      });

      document.addEventListener('scroll', () => {
        if (!header) return;
        header.classList.toggle('scrolled', window.scrollY > 18);
      });

      function setActive(slug) {
        currentSlug = slug;
        tabs.forEach(a => a.classList.toggle('active', a.dataset.slug === slug));
      }

      function money(x) {
        return new Intl.NumberFormat('id-ID').format(x);
      }

      function cardTemplate(m) {
        const img = m.image ? `${app.asset}/assets/img/${m.image}` : `${app.asset}/assets/img/placeholder.png`;
        const disabled = !(m.stock > 0);
        const ratingValue = typeof m.rating === 'number' ? m.rating : 4.8;
        const starCount = Math.min(5, Math.max(0, Math.round(ratingValue)));
        const ratingStars = Array.from({
          length: 5
        }, (_, index) => `<i class="fas fa-star${index < starCount ? '' : ' text-muted'}"></i>`).join('');
        const soldCount = typeof m.sold === 'number' ? m.sold : Math.max(15, (m.stock || 5) * 6);
        const stockClass = disabled ? 'out' : (m.stock <= 5 ? 'low' : 'available');

        return `
          <article class="menu-card animate-fade">
            <div class="thumb">
              <img src="${img}" alt="${m.name}">
              ${m.is_popular ? '<span class="badge-popular">Populer</span>' : ''}
              <button class="btn-add ${disabled ? 'disabled' : 'add-to-cart'}" data-id="${m.id}" ${disabled ? 'disabled' : ''} aria-label="${disabled ? 'Habis' : 'Tambah ke keranjang'}">
                <i class="fas ${disabled ? 'fa-ban' : 'fa-plus'}"></i>
              </button>
            </div>
            <div class="card-body">
              <h3>${m.name}</h3>
              <p class="desc">${m.description || 'Menu lezat untuk dinikmati kapan saja.'}</p>
              <div class="meta">
                <span class="category"><i class="fas fa-tag"></i>${m.category_name || 'Semua'}</span>
                <span class="sold"><i class="fas fa-fire"></i>${new Intl.NumberFormat('id-ID').format(soldCount)} terjual</span>
              </div>
              <div class="price-row">
                <span class="price">Rp ${money(m.price)}</span>
                <span class="stock-badge ${stockClass}">${m.stock_label}</span>
              </div>
            </div>
          </article>
        `;
      }

      function showSkeleton(n = 8) {
        grid.innerHTML = Array.from({
          length: n
        }).map(() => `<div class="skeleton"></div>`).join('');
      }

      async function loadMenus(slug = '', q = '') {
        setActive(slug);
        setCategoryLoading(true);
        showSkeleton();
        const url = slug ? `${app.api}/menu/json?cat=${encodeURIComponent(slug)}` : `${app.api}/menu/json`;
        const res = await fetch(url);
        const js = await res.json();
        if (Array.isArray(js.categories) && js.categories.length) {
          renderTabs(js.categories, slug);
        }
        let rows = js.data || [];

        if (q) {
          const qLower = q.toLowerCase();
          rows = rows.filter(m => {
            const name = (m.name || '').toLowerCase();
            const desc = (m.description || '').toLowerCase();
            return name.includes(qLower) || desc.includes(qLower);
          });
        }

        grid.innerHTML = rows.length ?
          rows.map(cardTemplate).join('') :
          '<p class="no-results">Menu tidak ditemukan.</p>';

        bindAddButtons();
        setCategoryLoading(false);
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
                showCartBurst(clickX, clickY);

                if (typeof data.cart_count !== 'undefined') {
                  setCartCount(data.cart_count);
                } else {
                  refreshCartCount();
                }
              } else {
                alert(data.msg || 'Gagal menambahkan item.');
              }

            });
          });
        });
      }

      function setCartCount(count) {
        const total = Number.parseInt(count, 10) || 0;

        document.querySelectorAll('.cart-count').forEach(el => {
          el.textContent = total > 99 ? '99+' : String(total);
          el.classList.toggle('show', total > 0);
          el.setAttribute('aria-label', `${total} item di keranjang`);
        });
      }

      async function refreshCartCount() {
        try {
          const res = await fetch('<?= base_url('cart/count'); ?>', {
            credentials: 'same-origin'
          });
          if (!res.ok) return;
          const data = await res.json();
          setCartCount(data.count || 0);
        } catch (error) {}
      }

      syncTabs();

      if (searchInput) {
        const debounce = (fn, delay = 300) => {
          let t;
          return (...args) => {
            clearTimeout(t);
            t = setTimeout(() => fn.apply(null, args), delay);
          };
        };

        const handleSearch = debounce(() => {
          currentQuery = searchInput.value.trim();
          loadMenus(currentSlug, currentQuery);
        }, 300);

        searchInput.addEventListener('input', handleSearch);
        searchInput.addEventListener('keydown', (event) => {
          if (event.key !== 'Enter') return;
          event.preventDefault();
          currentQuery = searchInput.value.trim();
          loadMenus(currentSlug, currentQuery);
        });
      }

      if (searchButton && searchInput) {
        searchButton.addEventListener('click', () => {
          currentQuery = searchInput.value.trim();
          loadMenus(currentSlug, currentQuery);
          searchInput.focus();
        });
      }

      loadMenus(activeInitial, currentQuery);
      refreshCartCount();

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
      const addressDropdownMenu = document.getElementById('addressDropdownMenu');

      if (addressTrigger && addressDropdownMenu) {

        addressTrigger.addEventListener('click', () => {

          addressDropdownMenu.classList.toggle('show');

          const icon = addressTrigger.querySelector('i');

          if (icon) {
            icon.classList.toggle('fa-chevron-down');
            icon.classList.toggle('fa-chevron-up');
          }
        });

      }

    })();
  </script>
</body>

</html>