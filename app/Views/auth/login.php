<?= $this->extend('layouts/main'); ?>

<?= $this->section('content'); ?>

<div class="login-wrapper">
  <div class="auth-visual" aria-hidden="true">
    <span class="auth-kicker">Kantin Kampus</span>
    <h1>Masuk dan pesan menu favoritmu lagi.</h1>
    <p>Hidangan hangat, harga ramah mahasiswa, dan proses pesan yang tetap simpel.</p>

    <div class="auth-preview">
      <div class="auth-preview-icon"><i class="fas fa-utensils"></i></div>
      <div>
        <strong>Menu hari ini siap</strong>
        <span>Pesan cepat dari kantin G'penk</span>
      </div>
    </div>
  </div>

  <div class="auth-card">

    <span class="auth-eyebrow">Selamat datang</span>
    <h2>Masuk ke Kantin G'penk</h2>

    <?php
    $successMessage = session()->getFlashdata('success');
    if (service('request')->getGet('registered')) {
      $successMessage = 'Akun berhasil didaftarkan. Silakan login untuk mulai memesan.';
    }
    ?>

    <?php if ($successMessage): ?>
      <div class="auth-alert auth-alert-success" id="registerSuccessAlert"><?= esc($successMessage); ?></div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('error')): ?>
      <div class="auth-alert"><?= esc(session('error')); ?></div>
    <?php endif; ?>

    <form method="post" action="<?= base_url('login'); ?>" id="loginForm">
      <?= csrf_field(); ?>

      <label for="no_hp">Nomor HP</label>

      <input
        type="tel"
        name="no_hp"
        id="no_hp"
        maxlength="13"
        pattern="\d{12,13}"
        inputmode="numeric"
        placeholder="Masukkan Nomor HP Anda"
        required
        value="<?= old('no_hp'); ?>">

      <label>Password</label>

      <div class="password-wrapper">
        <input
          type="password"
          name="password"
          id="password"
          placeholder="••••••"
          required>

        <span class="toggle-password" onclick="togglePassword('password', this)">
          <i class="fas fa-eye"></i>
        </span>
      </div>

      <button type="submit">Masuk</button>
    </form>

    <p>
      Belum punya akun?
      <a href="<?= base_url('register'); ?>">Daftar di sini</a>
    </p>

  </div>
</div>

<style>
  body {
    background:
      radial-gradient(circle at top left, rgba(255, 71, 102, 0.1), transparent 32%),
      linear-gradient(180deg, #f8fafc 0%, #fff6f7 100%);
    margin: 0;
    padding: 0;
  }

  .login-wrapper {
    width: min(1180px, calc(100% - 48px));
    min-height: calc(100vh - 120px);
    margin: 78px auto 0;
    display: grid;
    grid-template-columns: minmax(0, 1fr) minmax(360px, 460px);
    gap: clamp(2rem, 6vw, 5rem);
    align-items: center;
    padding: clamp(1.25rem, 3vh, 2.5rem) 0 2rem;
  }

  .auth-visual {
    max-width: 560px;
  }

  .auth-kicker,
  .auth-eyebrow {
    display: inline-flex;
    align-items: center;
    width: fit-content;
    margin-bottom: 1rem;
    padding: 0.55rem 1rem;
    border-radius: 999px;
    background: rgba(255, 71, 102, 0.12);
    color: #ff4766;
    font-size: 0.86rem;
    font-weight: 700;
  }

  .auth-visual h1 {
    margin: 0 0 1rem;
    color: #111827;
    font-size: clamp(2.4rem, 5vw, 4.7rem);
    line-height: 1.05;
    font-weight: 800;
  }

  .auth-visual p {
    max-width: 540px;
    margin: 0;
    color: #64748b;
    font-size: clamp(1rem, 1.3vw, 1.35rem);
    line-height: 1.8;
  }

  .auth-preview {
    display: flex;
    align-items: center;
    gap: 1rem;
    width: fit-content;
    margin-top: 2rem;
    padding: 1rem 1.2rem;
    border: 1px solid rgba(226, 232, 240, 0.9);
    border-radius: 22px;
    background: rgba(255, 255, 255, 0.85);
    box-shadow: 0 18px 48px rgba(15, 23, 42, 0.08);
  }

  .auth-preview-icon {
    width: 48px;
    height: 48px;
    display: grid;
    place-items: center;
    border-radius: 16px;
    color: #ffffff;
    background: linear-gradient(135deg, #ff6b35, #ffb62e);
  }

  .auth-preview strong,
  .auth-preview span {
    display: block;
  }

  .auth-preview strong {
    color: #111827;
    font-size: 0.98rem;
  }

  .auth-preview span {
    color: #64748b;
    font-size: 0.86rem;
  }

  .auth-card {
    width: 100%;
    padding: clamp(1.5rem, 3vw, 2.4rem);
    border: 1px solid rgba(226, 232, 240, 0.9);
    border-radius: 28px;
    background: rgba(255, 255, 255, 0.96);
    box-shadow: 0 24px 70px rgba(15, 23, 42, 0.1);
    text-align: left;
  }

  .auth-card h2 {
    margin: 0 0 1.5rem;
    color: #ff4766;
    font-size: clamp(1.7rem, 3vw, 2.15rem);
    font-weight: 700;
  }

  .auth-eyebrow {
    margin-bottom: 0.75rem;
    padding: 0;
    background: transparent;
  }

  .auth-card label {
    display: block;
    margin-bottom: 0.45rem;
    font-weight: 600;
    color: #0b2130;
  }

  .auth-card input {
    width: 100%;
    min-height: 56px;
    padding: 0.85rem 1rem;
    margin-bottom: 1.1rem;
    border: 1px solid rgba(226, 214, 216, 0.95);
    border-radius: 14px;
    font-size: 0.96rem;
    background: #f8fafc;
    color: #0b2130;
    box-sizing: border-box;
    transition: border-color 0.2s ease, box-shadow 0.2s ease, background 0.2s ease;
  }

  .auth-card input:focus {
    border-color: rgba(255, 71, 102, 0.55);
    background: #ffffff;
    box-shadow: 0 0 0 5px rgba(255, 71, 102, 0.1);
    outline: none;
  }

  .auth-alert {
    margin-bottom: 1rem;
    padding: 0.8rem 1rem;
    border-radius: 14px;
    background: #fff1f2;
    color: #be123c;
    font-size: 0.92rem;
    font-weight: 600;
    transition: opacity 0.35s ease, transform 0.35s ease, margin 0.35s ease, padding 0.35s ease;
  }

  .auth-alert-success {
    background: #ecfdf5;
    color: #047857;
    border: 1px solid rgba(16, 185, 129, 0.18);
  }

  .auth-alert.is-hiding {
    opacity: 0;
    transform: translateY(-6px);
    margin-top: 0;
    margin-bottom: 0;
    padding-top: 0;
    padding-bottom: 0;
    border-width: 0;
    overflow: hidden;
  }

  /* PASSWORD */

  .password-wrapper {
    position: relative;
    margin-bottom: 1.25rem;
  }

  .password-wrapper input {
    padding-right: 3.2rem;
    margin-bottom: 0;
  }

  .toggle-password {
    position: absolute;
    top: 50%;
    right: 14px;
    transform: translateY(-50%);
    cursor: pointer;
    color: #6b7280;
    font-size: 16px;
    display: flex;
    align-items: center;
    justify-content: center;
  }

  .toggle-password:hover {
    color: #ff4766;
  }

  .auth-card button {
    width: 100%;
    min-height: 56px;
    background: linear-gradient(135deg, #ff4766, #ff2d55);
    border: none;
    color: #fff;
    font-size: 1rem;
    padding: 0.85rem 0;
    border-radius: 14px;
    cursor: pointer;
    transition: transform 0.2s ease, box-shadow 0.2s ease;
    font-weight: 700;
    box-shadow: 0 18px 34px rgba(255, 71, 102, 0.22);
  }

  .auth-card button:hover {
    transform: translateY(-1px);
    box-shadow: 0 22px 42px rgba(255, 71, 102, 0.3);
  }

  .auth-card p {
    margin: 1.3rem 0 0;
    font-size: 0.95rem;
    color: #6b7280;
    text-align: center;
  }

  .auth-card a {
    color: #ff4766;
    text-decoration: none;
    font-weight: 600;
  }

  .auth-card a:hover {
    text-decoration: underline;
  }

  @media (max-width: 900px) {
    .login-wrapper {
      grid-template-columns: 1fr;
      width: min(560px, calc(100% - 32px));
      min-height: calc(100vh - 108px);
      margin-top: 76px;
    }

    .auth-visual {
      display: none;
    }
  }

  @media (max-width: 520px) {
    .login-wrapper {
      min-height: calc(100vh - 84px);
      margin-top: 72px;
      padding: 1rem 0 1.5rem;
    }

    .auth-card {
      border-radius: 22px;
    }
  }
</style>

<script>
  document.getElementById('no_hp')?.addEventListener('input', function() {
    this.value = (this.value || '')
      .replace(/\D/g, '')
      .slice(0, 13);
  });

  document.getElementById('loginForm')?.addEventListener('submit', function(e) {
    const phone = document.getElementById('no_hp').value.trim();

    if (!/^\d{12,13}$/.test(phone)) {
      e.preventDefault();
      alert('Nomor HP harus 12 atau 13 angka.');
    }
  });

  function togglePassword(id, el) {
    const input = document.getElementById(id);
    const icon = el.querySelector('i');

    if (input.type === 'password') {
      input.type = 'text';
      icon.classList.remove('fa-eye');
      icon.classList.add('fa-eye-slash');
    } else {
      input.type = 'password';
      icon.classList.remove('fa-eye-slash');
      icon.classList.add('fa-eye');
    }
  }

  const registerSuccessAlert = document.getElementById('registerSuccessAlert');
  if (registerSuccessAlert) {
    setTimeout(() => {
      registerSuccessAlert.classList.add('is-hiding');
      setTimeout(() => registerSuccessAlert.remove(), 400);
    }, 3500);
  }
</script>

<?= $this->endSection(); ?>
