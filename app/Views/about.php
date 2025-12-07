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
    :root {
      --bg-page: #fdeff0;
      --text-dark: #0b2130;
      --muted: #6b7280;
      --accent: #ff4766;
      --accent-dark: #e03f5d;
      --card-bg: #ffffff;
      --shadow-soft: 0 10px 30px rgba(10, 25, 40, 0.06);
    }

    /* NAVBAR – sama seperti menu.php */
    nav ul {
      list-style: none;
      display: flex;
      gap: 18px;
      margin: 0;
      padding: 0;
      align-items: center;
    }

    nav a {
      text-decoration: none;
      color: var(--text-dark);
      font-weight: 500;
    }

    nav a.active {
      color: var(--text-dark);
      border-bottom: none;
    }

    nav a:hover {
      color: var(--accent);
      border-bottom: 2px solid var(--accent);
    }

    body {
      margin: 0;
      padding: 0;
      background: var(--bg-page);
      font-family: 'Poppins', sans-serif;
      color: var(--text-dark);
      overflow-x: hidden;
    }

    .about-wrapper {
      max-width: 1150px;
      margin: 0 auto;
      padding: 130px 32px 72px;
    }

    .about-two-col {
      display: grid;
      grid-template-columns: minmax(0, 3fr) minmax(0, 2fr);
      gap: 60px;
      align-items: center;
    }

    .about-label {
      font-size: .9rem;
      font-weight: 600;
      letter-spacing: .06em;
      text-transform: uppercase;
      color: var(--accent);
      margin-bottom: 10px;
    }

    .about-title {
      font-size: 2.6rem;
      line-height: 1.2;
      font-weight: 800;
      margin-bottom: 16px;
    }

    .about-title span {
      color: var(--accent);
    }

    .about-text p {
      margin-bottom: 10px;
      font-size: .97rem;
      line-height: 1.7;
      color: var(--muted);
      max-width: 480px;
    }

    .about-images {
      position: relative;
      width: 420px;
      height: 380px;
    }

    .suasana-kantin-img {
      width: 100%;
      height: auto;
      border-radius: 18px;
      overflow: hidden;
      box-shadow: 0 18px 40px rgba(15, 23, 42, 0.15);
    }

    .makanan-img {
      position: absolute;
      left: -40px;
      top: 140px;
      width: 300px;
      border-radius: 18px;
      overflow: hidden;
      box-shadow: 0 22px 50px rgba(15, 23, 42, 0.22);
    }

    .suasana-kantin-img img,
    .makanan-img img {
      width: 100%;
      height: 100%;
      object-fit: cover;
    }

    @media(max-width: 900px) {
      .about-images {
        width: 300px;
        height: 300px;
      }

      .makanan-img {
        width: 200px;
        top: 110px;
        left: -30px;
      }
    }

    @media(max-width: 600px) {
      .about-images {
        margin: 0 auto;
      }

      .makanan-img {
        left: 10px;
        top: 120px;
      }
    }

    header {
      position: fixed;
      top: 0;
      width: 100%;
      padding: 18px 52px;
      background: var(--bg-page);
      display: flex;
      justify-content: space-between;
      align-items: center;
      box-shadow: 0 4px 16px rgba(0, 0, 0, 0.04);
      z-index: 999;
    }
  </style>
</head>

<body>

  <header>
    <div class="logo"><i class="fas fa-utensils"></i> Kantin G'penk</div>
    <nav>
      <ul>
        <li><a href="<?= site_url('/'); ?>">Home</a></li>
        <li><a href="<?= site_url('menu'); ?>">Menu</a></li>
        <li><a href="<?= site_url('about'); ?>" class="active">About Us</a></li>
      </ul>
    </nav>
  </header>

  <main class="about-wrapper">
    <section class="about-two-col">

      <div class="about-text">
        <div class="about-label">About Us</div>
        <h1 class="about-title">Membawa makanan kantin<br><span>langsung ke lokasimu</span></h1>

        <p>Kantin G'penk hadir untuk memudahkan mahasiswa dan staf kampus menikmati makanan favorit tanpa harus antre panjang di kantin.</p>
        <p>Cukup pesan lewat website, pilih diantar atau ambil sendiri, dan kami akan menyiapkan pesananmu dengan bahan yang segar, higienis, dan harga yang tetap ramah di kantong.</p>
        <p>Kami bekerja sama langsung dengan pengelola kantin agar menu selalu up-to-date dan proses pemesanan jadi lebih rapi dan terdata.</p>
      </div>

      <div class="about-images">
        <div class="suasana-kantin-img">
          <img src="<?= base_url('assets/img/suasana-kantin.jpeg'); ?>" alt="Suasana kantin">
        </div>

        <div class="makanan-img">
          <img src="<?= base_url('assets/img/makanan.jpg'); ?>" alt="Menu makanan kantin">
        </div>
      </div>
    </section>
  </main>

</body>
</html>