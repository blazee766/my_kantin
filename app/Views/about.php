<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Tentang Kami - Kantin G'penk</title>

  <link rel="stylesheet" href="<?= base_url('assets/css/style.css'); ?>">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

  <style>
    main {
      padding-top: 100px;
      padding-bottom: 60px;
    }

    .about-section {
      max-width: 1000px;
      margin: 0 auto;
      display: grid;
      grid-template-columns: 1.2fr 1fr;
      gap: 48px;
      align-items: center;
    }

    .about-content h2 {
      font-size: 1.8rem;
      font-weight: 700;
      margin: 0 0 12px;
      color: var(--text);
    }

    .about-badge {
      display: inline-block;
      background: var(--chip);
      color: var(--brand);
      padding: 6px 12px;
      border-radius: 20px;
      font-size: 0.85rem;
      font-weight: 600;
      margin-bottom: 12px;
      text-transform: uppercase;
      letter-spacing: 0.05em;
    }

    .about-content p {
      color: var(--muted);
      line-height: 1.7;
      margin-bottom: 14px;
      font-size: 0.95rem;
    }

    .about-highlight {
      margin-top: 24px;
      padding: 20px;
      background: var(--chip);
      border-left: 4px solid var(--brand);
      border-radius: 12px;
    }

    .about-highlight h4 {
      margin: 0 0 8px;
      font-size: 1rem;
      color: var(--text);
    }

    .about-highlight p {
      margin: 0;
      font-size: 0.9rem;
    }

    .about-images {
      display: flex;
      flex-direction: column;
      gap: 16px;
    }

    .about-images img {
      width: 100%;
      height: auto;
      border-radius: 16px;
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
      object-fit: cover;
    }

    .features {
      margin-top: 80px;
    }

    .features h3 {
      text-align: center;
      font-size: 1.6rem;
      font-weight: 700;
      margin-bottom: 40px;
      color: var(--text);
    }

    .feature-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
      gap: 24px;
    }

    .feature-card {
      background: var(--card);
      padding: 24px;
      border-radius: 16px;
      text-align: center;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.06);
      transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .feature-card:hover {
      transform: translateY(-4px);
      box-shadow: 0 8px 24px rgba(0, 0, 0, 0.12);
    }

    .feature-icon {
      font-size: 2.4rem;
      color: var(--brand);
      margin-bottom: 16px;
    }

    .feature-card h4 {
      margin: 0 0 12px;
      font-size: 1.05rem;
      color: var(--text);
    }

    .feature-card p {
      margin: 0;
      color: var(--muted);
      font-size: 0.9rem;
      line-height: 1.5;
    }

    @media (max-width: 768px) {
      main {
        padding-top: 80px;
        padding-bottom: 40px;
      }

      .about-section {
        grid-template-columns: 1fr;
        gap: 32px;
      }

      .about-content h2 {
        font-size: 1.4rem;
      }

      .features h3 {
        font-size: 1.3rem;
        margin-bottom: 24px;
      }

      .feature-grid {
        grid-template-columns: 1fr;
        gap: 16px;
      }

      .feature-card {
        padding: 20px;
      }
    }
  </style>
</head>

<body>
  <?php
  $contactPhone = getenv('CONTACT_PHONE') ?: (isset($contactPhone) ? $contactPhone : '08123456789');
  $telNormalized = preg_replace('/[^\d+]/', '', $contactPhone);
  $waNormalized = preg_replace('/[^\d]/', '', preg_replace('/^\+/', '', $contactPhone));
  $waMessage = rawurlencode("Halo Kantin G'penk, saya ingin bertanya.");
  $telDisplay = $contactPhone;
  ?>

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
              <li><a href="<?= site_url('/'); ?>">Home</a></li>
              <li><a href="<?= site_url('menu'); ?>">Menu</a></li>
              <li><a href="<?= site_url('about'); ?>" class="active">About</a></li>
              <li><a href="<?= site_url('contact'); ?>">Contact</a></li>
            </ul>
          </nav>
        </div>

        <?php if (session('user')): ?>
          <?php if (session('user.role') === 'admin'): ?>
            <a href="<?= base_url('admin'); ?>" class="btn btn-primary">Dashboard</a>
          <?php else: ?>
            <a href="<?= site_url('p/orders'); ?>" class="icon-btn header-cart" aria-label="Keranjang">
              <i class="fas fa-shopping-bag"></i>
              <span class="badge cart-count">0</span>
            </a>
          <?php endif; ?>
        <?php else: ?>
          <a href="<?= site_url('cart'); ?>" class="icon-btn header-cart" aria-label="Keranjang">
            <i class="fas fa-shopping-bag"></i>
            <span class="badge cart-count">0</span>
          </a>
        <?php endif; ?>

        <button class="hamburger icon-btn d-md-none" id="hamburger" aria-label="Toggle menu">
          <i class="fas fa-bars"></i>
        </button>
      </div>
    </header>

    <main>
      <section class="about-section">
        <div class="about-content">
          <span class="about-badge">Tentang Kami</span>
          <h2>Membawa Makanan Kantin Langsung Ke Lokasimu</h2>

          <p>Kantin G'penk hadir untuk memudahkan mahasiswa dan staf kampus menikmati makanan favorit tanpa harus antre panjang di kantin. Kami memahami kesibukan kamu, itulah mengapa kami ciptakan platform pemesanan yang mudah, cepat, dan reliable.</p>

          <p>Cukup pesan lewat website, pilih diantar atau ambil sendiri, dan kami akan menyiapkan pesananmu dengan bahan yang segar, higienis, dan harga yang tetap ramah di kantong.</p>

          <div class="about-highlight">
            <h4><i class="fas fa-handshake" style="color: var(--brand); margin-right: 8px;"></i> Kolaborasi Langsung</h4>
            <p>Kami bekerja sama langsung dengan pengelola kantin agar menu selalu up-to-date dan proses pemesanan jadi lebih rapi dan terdata.</p>
          </div>
        </div>

        <div class="about-images">
          <img src="<?= base_url('assets/img/suasana-kantin.jpeg'); ?>" alt="Suasana kantin G'penk">
          <img src="<?= base_url('assets/img/makanan.jpg'); ?>" alt="Menu makanan kantin G'penk">
        </div>
      </section>

      <section class="features">
        <h3>Mengapa Pilih Kantin G'penk?</h3>
        <div class="feature-grid">
          <div class="feature-card">
            <div class="feature-icon"><i class="fas fa-bolt"></i></div>
            <h4>Cepat & Mudah</h4>
            <p>Pesan hanya dalam beberapa klik, tanpa perlu antri panjang di kantin.</p>
          </div>

          <div class="feature-card">
            <div class="feature-icon"><i class="fas fa-leaf"></i></div>
            <h4>Segar & Higienis</h4>
            <p>Semua makanan disiapkan dengan bahan berkualitas dan standar kebersihan tinggi.</p>
          </div>

          <div class="feature-card">
            <div class="feature-icon"><i class="fas fa-tag"></i></div>
            <h4>Harga Terjangkau</h4>
            <p>Tetap ramah di kantong dengan menu variatif untuk setiap budget.</p>
          </div>

          <div class="feature-card">
            <div class="feature-icon"><i class="fas fa-box"></i></div>
            <h4>Dua Pilihan Pengambilan</h4>
            <p>Ambil sendiri atau minta diantar sesuai kenyamanan kamu.</p>
          </div>

          <div class="feature-card">
            <div class="feature-icon"><i class="fas fa-calendar"></i></div>
            <h4>Menu Terbarui</h4>
            <p>Daftar menu selalu up-to-date setiap harinya langsung dari kantin.</p>
          </div>

          <div class="feature-card">
            <div class="feature-icon"><i class="fas fa-star"></i></div>
            <h4>Rating Tinggi</h4>
            <p>Dipercaya oleh ribuan mahasiswa dengan rating 4.9/5 dari pelanggan.</p>
          </div>
        </div>
      </section>
    </main>
  </div>

  <script>
    window.APP_BASE = "<?= rtrim(base_url('/'), '/'); ?>/";
  </script>
  <script src="<?= base_url('assets/js/script.js'); ?>"></script>

  <script>
    const hamburger = document.getElementById('hamburger');
    const nav = document.querySelector('header nav');

    hamburger?.addEventListener('click', function() {
      if (nav) {
        nav.classList.toggle('active');
      }
    });

    document.addEventListener('click', function(e) {
      if (!nav || !hamburger) return;
      if (!nav.contains(e.target) && !hamburger.contains(e.target)) {
        nav.classList.remove('active');
      }
    });
  </script>
</body>

</html>