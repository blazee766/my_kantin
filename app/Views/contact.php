<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Hubungi Kami - Kantin G'penk</title>

  <link rel="stylesheet" href="<?= base_url('assets/css/style.css?v=' . filemtime(FCPATH . 'assets/css/style.css')); ?>">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

  <style>
    main {
      padding-top: 100px;
      padding-bottom: 60px;
    }

    .contact-header {
      text-align: center;
      margin-bottom: 60px;
    }

    .contact-header h1 {
      font-size: 1.8rem;
      font-weight: 700;
      margin: 0 0 12px;
      color: var(--text);
    }

    .contact-header p {
      color: var(--muted);
      font-size: 1rem;
      margin: 0;
    }

    .contact-container {
      max-width: 1000px;
      margin: 0 auto;
      display: grid;
      grid-template-columns: 1.2fr 1fr;
      gap: 48px;
      align-items: start;
    }

    .contact-form {
      background: var(--card);
      padding: 32px;
      border-radius: 16px;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.06);
    }

    .contact-form h3 {
      margin: 0 0 24px;
      font-size: 1.3rem;
      color: var(--text);
    }

    .form-group {
      margin-bottom: 20px;
    }

    .form-group label {
      display: block;
      margin-bottom: 8px;
      font-weight: 600;
      color: var(--text);
      font-size: 0.9rem;
    }

    .form-group input,
    .form-group textarea {
      width: 100%;
      padding: 12px 14px;
      border: 1px solid #e5e7eb;
      border-radius: 10px;
      font-family: 'Poppins', sans-serif;
      font-size: 0.95rem;
      color: var(--text);
      transition: border-color 0.2s ease;
    }

    .form-group input:focus,
    .form-group textarea:focus {
      outline: none;
      border-color: var(--brand);
      box-shadow: 0 0 0 3px rgba(255, 45, 85, 0.1);
    }

    .form-group textarea {
      resize: vertical;
      min-height: 120px;
    }

    .form-submit {
      width: 100%;
      padding: 14px 20px;
      background: var(--brand);
      color: white;
      border: none;
      border-radius: 10px;
      font-weight: 600;
      font-size: 0.95rem;
      cursor: pointer;
      transition: background 0.2s ease;
      font-family: 'Poppins', sans-serif;
    }

    .form-submit:hover {
      background: var(--brand-dark);
    }

    .contact-info {
      display: flex;
      flex-direction: column;
      gap: 24px;
    }

    .info-box {
      background: var(--card);
      padding: 24px;
      border-radius: 16px;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.06);
    }

    .info-box h4 {
      margin: 0 0 12px;
      font-size: 1.05rem;
      color: var(--text);
      display: flex;
      align-items: center;
      gap: 10px;
    }

    .info-box .icon {
      display: flex;
      align-items: center;
      justify-content: center;
      width: 36px;
      height: 36px;
      background: rgba(255, 45, 85, 0.1);
      border-radius: 10px;
      color: var(--brand);
      font-size: 1.2rem;
    }

    .info-box p {
      margin: 0;
      color: var(--muted);
      font-size: 0.9rem;
      line-height: 1.6;
    }

    .info-box a {
      color: var(--brand);
      text-decoration: none;
      font-weight: 600;
      transition: opacity 0.2s ease;
    }

    .info-box a:hover {
      opacity: 0.8;
    }

    .social-links {
      display: flex;
      gap: 12px;
      margin-top: 12px;
    }

    .social-link {
      display: inline-flex;
      align-items: center;
      justify-content: center;
      width: 40px;
      height: 40px;
      background: var(--chip);
      border-radius: 10px;
      color: var(--brand);
      text-decoration: none;
      font-size: 1.1rem;
      transition: background 0.2s ease;
    }

    .social-link:hover {
      background: rgba(255, 45, 85, 0.1);
    }

    .faq-section {
      margin-top: 80px;
      background: var(--chip);
      padding: 48px;
      border-radius: 16px;
    }

    .faq-section h3 {
      text-align: center;
      font-size: 1.6rem;
      font-weight: 700;
      margin: 0 0 40px;
      color: var(--text);
    }

    .faq-list {
      max-width: 800px;
      margin: 0 auto;
    }

    .faq-item {
      margin-bottom: 20px;
      padding: 20px;
      background: var(--card);
      border-radius: 12px;
      border-left: 4px solid var(--brand);
    }

    .faq-item h5 {
      margin: 0 0 10px;
      font-size: 1rem;
      color: var(--text);
      cursor: pointer;
      display: flex;
      align-items: center;
      justify-content: space-between;
    }

    .faq-item p {
      margin: 0;
      color: var(--muted);
      font-size: 0.9rem;
      line-height: 1.6;
      display: none;
    }

    .faq-item.active p {
      display: block;
    }

    .faq-toggle {
      color: var(--brand);
      font-size: 1.2rem;
      transition: transform 0.2s ease;
    }

    .faq-item.active .faq-toggle {
      transform: rotate(180deg);
    }

    .info-box .btn-primary {
      color: #fff !important;
    }

    .info-box .btn-primary i {
      color: #fff !important;
    }

    @media (max-width: 768px) {
      main {
        padding-top: 80px;
        padding-bottom: 40px;
      }

      .contact-header h1 {
        font-size: 1.4rem;
      }

      .contact-container {
        grid-template-columns: 1fr;
        gap: 32px;
      }

      .contact-form {
        padding: 24px;
      }

      .faq-section {
        padding: 32px 20px;
      }

      .faq-section h3 {
        font-size: 1.3rem;
      }

      .faq-item {
        padding: 16px;
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

    .contact-header {
      max-width: 720px;
      margin-inline: auto;
      margin-bottom: clamp(1.5rem, 5vw, 3rem);
    }

    .contact-header h1 {
      font-size: clamp(2rem, 5vw, 3.6rem);
      line-height: 1.05;
      letter-spacing: 0;
      color: #0f172a;
    }

    .contact-header p {
      color: #55657e;
      line-height: 1.75;
    }

    .contact-container {
      max-width: 1120px;
      gap: clamp(1.25rem, 4vw, 2.5rem);
      align-items: stretch;
    }

    .contact-form,
    .info-box,
    .faq-section {
      border: 1px solid rgba(226, 232, 240, 0.9);
      background: rgba(255, 255, 255, 0.94);
      box-shadow: 0 22px 58px rgba(15, 23, 42, 0.08);
    }

    .contact-form {
      border-radius: 28px;
      padding: clamp(1.25rem, 3vw, 2rem);
    }

    .contact-form h3,
    .faq-section h3 {
      letter-spacing: 0;
      color: #0f172a;
    }

    .form-group input,
    .form-group textarea {
      min-height: 52px;
      border-radius: 16px;
      background: #ffffff;
    }

    .form-submit {
      min-height: 52px;
      border-radius: 16px;
      background: linear-gradient(135deg, #ff4d6d, #ffb703);
      box-shadow: 0 16px 34px rgba(255, 77, 109, 0.2);
    }

    .contact-info {
      gap: 1rem;
    }

    .info-box {
      border-radius: 22px;
    }

    .info-box .icon {
      flex: 0 0 auto;
      border-radius: 14px;
      background: rgba(255, 77, 109, 0.1);
    }

    .faq-section {
      max-width: 1120px;
      margin-inline: auto;
      margin-top: clamp(2.5rem, 6vw, 4.5rem);
      border-radius: 28px;
      padding: clamp(1.25rem, 4vw, 3rem);
    }

    .faq-item {
      border: 1px solid rgba(226, 232, 240, 0.9);
      border-left: 4px solid #ff4d6d;
      border-radius: 18px;
      background: #ffffff;
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

      .contact-header {
        text-align: left;
      }

      .contact-container {
        grid-template-columns: 1fr;
      }

      .contact-form,
      .faq-section {
        border-radius: 24px;
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

      .contact-form,
      .info-box,
      .faq-section {
        padding: 1rem;
      }
    }
  </style>
</head>

<body class="contact-page info-page">
  <?php
  $contactPhone = getenv('CONTACT_PHONE') ?: (isset($contactPhone) ? $contactPhone : '085707559188');
  $telNormalized = preg_replace('/[^\d+]/', '', $contactPhone);
  $waNormalized = preg_replace('/[^\d]/', '', preg_replace('/^\+/', '', $contactPhone));
  $waMessage = rawurlencode("Halo Kantin G'penk, saya ingin menghubungi.");
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
              <li><a href="<?= site_url('about'); ?>">About</a></li>
              <li><a href="<?= site_url('contact'); ?>" class="active">Contact</a></li>
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
      <div class="contact-header">
        <h1>Hubungi Kami</h1>
        <p>Punya pertanyaan atau saran? Kami siap membantu. Hubungi kami melalui form di bawah atau langsung via WhatsApp.</p>
      </div>

      <div class="contact-container">
        <form class="contact-form" id="contactForm">
          <h3>Kirim Pesan</h3>

          <div class="form-group">
            <label for="name">Nama Lengkap</label>
            <input type="text" id="name" name="name" required placeholder="Nama kamu">
          </div>

          <div class="form-group">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" required placeholder="email@example.com">
          </div>

          <div class="form-group">
            <label for="subject">Subjek</label>
            <input type="text" id="subject" name="subject" required placeholder="Topik pertanyaan">
          </div>

          <div class="form-group">
            <label for="message">Pesan</label>
            <textarea id="message" name="message" required placeholder="Tuliskan pesan kamu di sini..."></textarea>
          </div>

          <button type="submit" class="form-submit">Kirim Pesan</button>
        </form>

        <div class="contact-info">
          <div class="info-box">
            <h4>
              <div class="icon"><i class="fas fa-phone"></i></div>
              <span>Hubungi Kami</span>
            </h4>
            <p>
              Telepon: <a href="tel:<?= esc($telNormalized); ?>"><?= esc($telDisplay); ?></a><br>
              Respons waktu: 08:00 - 16:00 WIB
            </p>
          </div>

          <div class="info-box">
            <h4>
              <div class="icon"><i class="fab fa-whatsapp"></i></div>
              <span>WhatsApp</span>
            </h4>
            <p>Chat langsung dengan kami untuk order dan pertanyaan cepat.</p>
            <a href="https://wa.me/<?= esc($waNormalized); ?>?text=<?= esc($waMessage); ?>" target="_blank" rel="noopener" class="btn btn-primary" style="display: inline-block; margin-top: 10px; padding: 10px 16px; font-size: 0.9rem;">
              <i class="fab fa-whatsapp"></i> Buka WhatsApp
            </a>
          </div>

          <div class="info-box">
            <h4>
              <div class="icon"><i class="fas fa-clock"></i></div>
              <span>Jam Operasional</span>
            </h4>
            <p>
              Senin - Kamis: 08:00 - 15:00 WIB<br>
              Jumat - Minggu: Libur<br>
              Libur Nasional: Tutup
            </p>
          </div>

          <div class="info-box">
            <h4>
              <div class="icon"><i class="fas fa-map-marker-alt"></i></div>
              <span>Lokasi</span>
            </h4>
            <p>Kampus 2<br>Universitas Nusantara PGRI Kediri</p>
          </div>
        </div>
      </div>

      <section class="faq-section">
        <h3>Pertanyaan yang Sering Diajukan</h3>
        <div class="faq-list">
          <div class="faq-item active">
            <h5>
              <span>Bagaimana cara melakukan pemesanan?</span>
              <span class="faq-toggle"><i class="fas fa-chevron-down"></i></span>
            </h5>
            <p>Langkah-langkahnya sangat mudah: 1. Buat akun atau login 2. Pilih menu favorit 3. Tentukan jumlah 4. Pilih metode pengambilan (ambil sendiri atau diantar) 5. Lakukan pembayaran 6. Tunggu konfirmasi pesanan</p>
          </div>

          <div class="faq-item">
            <h5>
              <span>Berapa lama waktu untuk pesanan siap?</span>
              <span class="faq-toggle"><i class="fas fa-chevron-down"></i></span>
            </h5>
            <p>Pesanan biasanya siap dalam 15-30 menit setelah dikonfirmasi. Untuk pengiriman, tambahan waktu 10-20 menit tergantung jarak lokasi.</p>
          </div>

          <div class="faq-item">
            <h5>
              <span>Apakah ada biaya tambahan untuk pengiriman?</span>
              <span class="faq-toggle"><i class="fas fa-chevron-down"></i></span>
            </h5>
            <p>Biaya pengiriman tergantung lokasi (dalam kampus / di luar kampus). Biaya akan ditampilkan sebelum checkout, sehingga kamu bisa melihat jumlah pastinya.</p>
          </div>

          <div class="faq-item">
            <h5>
              <span>Metode pembayaran apa saja yang tersedia?</span>
              <span class="faq-toggle"><i class="fas fa-chevron-down"></i></span>
            </h5>
            <p>Kami menerima transfer bank, e-wallet (GCash, OVO, DANA), dan pembayaran tunai saat pengambilan (tergantung pilihan pembayaran yang tersedia).</p>
          </div>

          <div class="faq-item">
            <h5>
              <span>Bisakah saya membatalkan pesanan?</span>
              <span class="faq-toggle"><i class="fas fa-chevron-down"></i></span>
            </h5>
            <p>Pesanan dapat dibatalkan sebelum proses persiapan makanan dimulai (biasanya dalam 5 menit pertama). Hubungi kami via WhatsApp untuk pembatalan.</p>
          </div>

          <div class="faq-item">
            <h5>
              <span>Bagaimana jika ada masalah dengan pesanan?</span>
              <span class="faq-toggle"><i class="fas fa-chevron-down"></i></span>
            </h5>
            <p>Hubungi kami segera via WhatsApp atau telepon. Kami siap membantu dan memberikan solusi terbaik untuk setiap keluhan.</p>
          </div>
        </div>
      </section>
    </main>
  </div>

  <script>
    window.APP_BASE = "<?= rtrim(base_url('/'), '/'); ?>/";
  </script>
  <script src="<?= base_url('assets/js/script.js?v=' . filemtime(FCPATH . 'assets/js/script.js')); ?>"></script>

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

    // FAQ toggle
    document.querySelectorAll('.faq-item h5').forEach(item => {
      item.addEventListener('click', () => {
        const faqItem = item.parentElement;
        faqItem.classList.toggle('active');
      });
    });

    // Contact form submission
    const contactForm = document.getElementById('contactForm');
    if (contactForm) {
      contactForm.addEventListener('submit', function(e) {
        e.preventDefault();

        const formData = new FormData(this);
        const data = {
          name: formData.get('name'),
          email: formData.get('email'),
          subject: formData.get('subject'),
          message: formData.get('message')
        };

        console.log('Form data:', data);
        // Here you would normally send the data to your backend
        // For now, just show a success message
        alert('Terima kasih! Pesan Anda telah dikirim. Kami akan menghubungi Anda segera.');
        this.reset();
      });
    }
  </script>
</body>

</html>
