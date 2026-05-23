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
    /* Premium responsive info page */
    body.info-page {
      min-height: 100vh;
      background:
        radial-gradient(circle at 16% 8%, rgba(255, 77, 109, 0.09), transparent 28%),
        radial-gradient(circle at 88% 18%, rgba(255, 183, 3, 0.12), transparent 26%),
        linear-gradient(180deg, #fffdf9 0%, #f8fafc 48%, #ffffff 100%);
    }

    .info-page .container {
      max-width: 1220px;
      padding-inline: clamp(1rem, 3vw, 1.75rem);
    }

    .info-page .page-header {
      min-height: 76px;
      padding: 0.8rem clamp(1rem, 3vw, 1.5rem);
      border-bottom: 1px solid rgba(226, 232, 240, 0.88);
      background: rgba(255, 255, 255, 0.9);
      backdrop-filter: blur(18px);
    }

    .info-page .header-brand,
    .info-page .header-actions {
      min-width: 0;
    }

    .info-page .brand-title,
    .info-page .brand-subtitle {
      display: block;
      white-space: nowrap;
      letter-spacing: 0;
    }

    .info-page main {
      padding-top: 104px;
      padding-bottom: clamp(2.5rem, 6vw, 4.5rem);
    }

    .about-section {
      max-width: 1120px;
      gap: clamp(1.5rem, 5vw, 3.5rem);
      padding: clamp(1.25rem, 3.4vw, 2.4rem);
      border-radius: 30px;
      background:
        linear-gradient(135deg, rgba(255, 255, 255, 0.96), rgba(255, 247, 237, 0.84)),
        radial-gradient(circle at 84% 20%, rgba(255, 183, 3, 0.18), transparent 32%);
      border: 1px solid rgba(255, 255, 255, 0.95);
      box-shadow: 0 26px 70px rgba(15, 23, 42, 0.1);
    }

    .about-badge {
      background: rgba(255, 77, 109, 0.12);
      color: #ff4d6d;
      letter-spacing: 0;
      text-transform: none;
      border-radius: 999px;
    }

    .about-content h2 {
      max-width: 12ch;
      font-size: clamp(2rem, 5vw, 3.8rem);
      line-height: 1.03;
      letter-spacing: 0;
      color: #0f172a;
    }

    .about-content p {
      color: #55657e;
      font-size: clamp(0.95rem, 1.2vw, 1.05rem);
    }

    .about-highlight,
    .feature-card {
      border: 1px solid rgba(226, 232, 240, 0.9);
      background: rgba(255, 255, 255, 0.92);
      box-shadow: 0 18px 40px rgba(15, 23, 42, 0.06);
    }

    .about-images img {
      height: clamp(190px, 24vw, 290px);
      border-radius: 24px;
    }

    .features {
      max-width: 1120px;
      margin-inline: auto;
      margin-top: clamp(2.5rem, 6vw, 4.5rem);
    }

    .features h3 {
      font-size: clamp(1.55rem, 3vw, 2.2rem);
      letter-spacing: 0;
    }

    .feature-grid {
      grid-template-columns: repeat(3, minmax(0, 1fr));
    }

    .feature-card {
      border-radius: 22px;
      text-align: left;
    }

    .feature-icon {
      width: 52px;
      height: 52px;
      display: grid;
      place-items: center;
      border-radius: 18px;
      background: rgba(255, 77, 109, 0.1);
      font-size: 1.25rem;
    }

    @media (max-width: 992px) {
      .info-page header nav {
        display: none;
      }

      .info-page header nav.active {
        display: flex;
        position: absolute;
        top: calc(100% + 0.6rem);
        right: 1rem;
        left: 1rem;
        padding: 0.75rem;
        border: 1px solid rgba(226, 232, 240, 0.9);
        border-radius: 20px;
        background: #ffffff;
        box-shadow: 0 24px 58px rgba(15, 23, 42, 0.16);
      }

      .info-page header nav.active .nav-links {
        width: 100%;
        flex-direction: column;
        align-items: stretch;
        gap: 0.35rem;
      }

      .info-page header nav.active .nav-links a {
        width: 100%;
        padding: 0.85rem 1rem;
      }

      .info-page .hamburger {
        display: inline-grid;
        place-items: center;
      }

      .feature-grid {
        grid-template-columns: repeat(2, minmax(0, 1fr));
      }
    }

    @media (max-width: 760px) {
      .info-page .page-header {
        min-height: 68px;
        padding: 0.7rem 0.9rem;
      }

      .info-page .brand-subtitle {
        display: none;
      }

      .info-page main {
        padding-top: 86px;
      }

      .about-section {
        padding: 1rem;
        border-radius: 24px;
      }

      .about-content h2 {
        max-width: 100%;
        font-size: 2rem;
      }

      .feature-grid {
        grid-template-columns: 1fr;
      }
    }

    @media (max-width: 430px) {
      .info-page .container {
        padding-inline: 0.75rem;
      }

      .info-page .brand-title {
        max-width: 118px;
        overflow: hidden;
        text-overflow: ellipsis;
      }

      .about-images img {
        height: 180px;
      }
    }
  </style>
</head>

<body class="about-page info-page">
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
    const icon = hamburger?.querySelector('i');

    if (hamburger && nav && icon) {
      hamburger.addEventListener('click', function() {
        nav.classList.toggle('active');

        if (nav.classList.contains('active')) {
          icon.classList.remove('fa-bars');
          icon.classList.add('fa-times');
        } else {
          icon.classList.remove('fa-times');
          icon.classList.add('fa-bars');
        }
      });

      nav.querySelectorAll('a').forEach(link => {
        link.addEventListener('click', () => {
          nav.classList.remove('active');
          icon.classList.remove('fa-times');
          icon.classList.add('fa-bars');
        });
      });

      document.addEventListener('click', function(e) {
        if (!nav.contains(e.target) && !hamburger.contains(e.target)) {
          nav.classList.remove('active');
          icon.classList.remove('fa-times');
          icon.classList.add('fa-bars');
        }
      });
    }
  </script>
</body>

</html>
