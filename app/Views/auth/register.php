<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Register - Kantin G'penk</title>
  <link rel="stylesheet" href="<?= base_url('assets/css/style.css'); ?>">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

  <style>
    :root {
      --bg-page: #fdeff0;
      --card-bg: #ffffff;
      --text-dark: #0b2130;
      --muted: #6b7280;
      --accent: #ff4766;
      --accent-dark: #e03f5d;
      --field-border: #e6d6d8;
    }

    body {
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      background-color: var(--bg-page);
      font-family: 'Poppins', sans-serif;
      color: var(--text-dark);
      margin: 0;
    }

    .auth-card {
      background: var(--card-bg);
      border-radius: 15px;
      box-shadow: 0 4px 22px rgba(0, 0, 0, 0.08);
      width: 400px;
      padding: 2rem 2.5rem;
      text-align: center;
    }

    .auth-card h2 {
      margin-bottom: 1.5rem;
      color: var(--accent);
      font-weight: 700;
    }

    form {
      text-align: left;
    }

    label {
      display: block;
      margin-bottom: .3rem;
      font-weight: 500;
      color: var(--text-dark);
    }

    input {
      width: 100%;
      padding: .6rem .8rem;
      margin-bottom: 1rem;
      border: 1px solid var(--field-border);
      border-radius: 8px;
      font-size: 14px;
      background: #fff;
      color: var(--text-dark);
    }

    button {
      width: 100%;
      background: var(--accent);
      border: none;
      color: #fff;
      font-size: 1rem;
      padding: .7rem 0;
      border-radius: 8px;
      cursor: pointer;
      transition: background .25s;
      font-weight: 600;
    }

    button:hover {
      background: var(--accent-dark);
    }

    p {
      margin-top: 1rem;
      font-size: 14px;
      color: var(--muted);
    }

    a {
      color: var(--accent);
      text-decoration: none;
      font-weight: 600;
    }

    a:hover {
      text-decoration: underline;
    }

    .register-success-overlay {
      position: fixed;
      inset: 0;
      background: rgba(0, 0, 0, 0.0);
      display: flex;
      align-items: center;
      justify-content: center;
      z-index: 9999;
      animation: successBackdrop .35s ease forwards;
    }

    .register-success-card {
      background: #fff;
      border-radius: 24px;
      padding: 32px 40px;
      max-width: 420px;
      width: 90%;
      text-align: center;
      box-shadow: 0 20px 60px rgba(0, 0, 0, 0.12);
      opacity: 0;
      transform: translateY(30px) scale(0.96);
      animation: successPopup .45s ease forwards .1s;
    }

    .register-success-icon {
      width: 60px;
      height: 60px;
      border-radius: 50%;
      border: 3px solid #22c55e;
      display: flex;
      align-items: center;
      justify-content: center;
      margin: 0 auto 16px;
      color: #22c55e;
      font-size: 30px;
    }

    .register-success-title {
      font-size: 1.4rem;
      font-weight: 700;
      color: #ff4766;
      margin-bottom: 12px;
    }

    .register-success-msg {
      background: #dcfce7;
      border-radius: 14px;
      padding: 14px 16px;
      font-size: 0.96rem;
      color: #166534;
      margin-bottom: 20px;
    }

    .register-success-btn {
      display: inline-block;
      padding: 10px 22px;
      border-radius: 999px;
      background: #ff4766;
      color: #fff;
      text-decoration: none;
      font-weight: 600;
      border: none;
      cursor: pointer;
    }

    .register-success-btn:hover {
      background: #e03f5d;
    }

    @keyframes successBackdrop {
      from {
        background: rgba(0, 0, 0, 0);
      }

      to {
        background: rgba(0, 0, 0, 0.25);
      }
    }

    @keyframes successPopup {
      from {
        opacity: 0;
        transform: translateY(30px) scale(0.96);
      }

      to {
        opacity: 1;
        transform: translateY(0) scale(1);
      }
    }
  </style>

</head>

<body>
  <div class="auth-card">
    <h2>Daftar Akun Baru</h2>

    <?php if (session()->getFlashdata('error')): ?>
      <p style="color:red;"><?= esc(session('error')); ?></p>
    <?php endif; ?>

    <form method="post" action="<?= base_url('register/save'); ?>">
      <?= csrf_field(); ?>

      <label>Nama Lengkap</label>
      <input type="text" name="name" required value="<?= old('name'); ?>">

      <label for="no_hp">Nomor HP</label>
      <input
        type="tel"
        name="no_hp"
        id="no_hp"
        pattern="\d{12}"
        maxlength="12"
        inputmode="numeric"
        required
        placeholder="Masukkan Nomor HP Anda"
        value="<?= old('no_hp'); ?>">

      <label>Password</label>
      <input type="password" name="password" required>

      <label>Konfirmasi Password</label>
      <input type="password" name="password_confirm" required>

      <button type="submit">Daftar</button>
    </form>

    <p>Sudah punya akun? <a href="<?= base_url('login'); ?>">Sign In di sini</a></p>
  </div>

  <?php if ($msg = session()->getFlashdata('success')): ?>
    <div class="register-success-overlay">
      <div class="register-success-card">
        <div class="register-success-icon">✓</div>
        <div class="register-success-title">Pendaftaran Berhasil</div>
        <div class="register-success-msg">
          <?= esc($msg); ?>
        </div>
        <a href="<?= site_url('login'); ?>" class="register-success-btn">
          Masuk Sekarang
        </a>
      </div>
    </div>
  <?php endif; ?>

</body>

</html>