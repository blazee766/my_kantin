<?= $this->extend('layouts/main'); ?>

<?= $this->section('content'); ?>

<div class="login-wrapper">
  <div class="auth-visual" aria-hidden="true">
    <span class="auth-kicker">Mulai Pesan</span>
    <h1>Buat akun untuk pesan lebih cepat.</h1>
    <p>Simpan data pelangganmu dan lanjutkan pemesanan menu kantin tanpa ribet.</p>

    <div class="auth-preview">
      <div class="auth-preview-icon"><i class="fas fa-user-plus"></i></div>
      <div>
        <strong>Daftar sekali saja</strong>
        <span>Langsung siap pesan menu favorit</span>
      </div>
    </div>
  </div>

  <div class="auth-card" id="registerCard">
    <span class="auth-eyebrow">Akun baru</span>
    <h2>Daftar Akun</h2>

    <?php if ($errors = session()->getFlashdata('errors')): ?>
      <div class="auth-alert">
        <?php foreach ($errors as $e): ?>
          <div><?= esc($e) ?></div>
        <?php endforeach; ?>
      </div>
    <?php elseif (session()->getFlashdata('error')): ?>
      <div class="auth-alert"><?= esc(session('error')); ?></div>
    <?php endif; ?>

    <form method="post" action="<?= base_url('register/save'); ?>" id="registerForm">
      <?= csrf_field(); ?>

      <label>Nama Lengkap</label>
      <input
        type="text"
        name="name"
        required
        placeholder="Masukkan Nama Anda"
        value="<?= old('name'); ?>">

      <label for="no_hp">Nomor HP</label>
      <input
        type="tel"
        name="no_hp"
        id="no_hp"
        pattern="08\d{10,11}"
        maxlength="13"
        inputmode="numeric"
        required
        placeholder="Masukkan Nomor HP Anda"
        value="<?= old('no_hp'); ?>">

      <label>Password</label>
      <div class="password-wrapper">
        <input
          type="password"
          name="password"
          id="password"
          required
          placeholder="Password">

        <span class="toggle-password" onclick="togglePassword('password', this)">
          <i class="fas fa-eye"></i>
        </span>
      </div>

      <label>Konfirmasi Password</label>
      <div class="password-wrapper">
        <input
          type="password"
          name="password_confirm"
          id="password_confirm"
          required
          placeholder="Konfirmasi Password">

        <span class="toggle-password" onclick="togglePassword('password_confirm', this)">
          <i class="fas fa-eye"></i>
        </span>
      </div>

      <button type="submit">Daftar</button>
    </form>

    <p>
      Sudah punya akun?
      <a href="<?= base_url('login'); ?>">Sign In di sini</a>
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
    min-height: calc(100vh - 86px);
    margin: 86px auto 0;
    display: grid;
    grid-template-columns: minmax(0, 1fr) minmax(380px, 480px);
    gap: clamp(2rem, 6vw, 5rem);
    align-items: center;
    padding: clamp(0.75rem, 2vh, 1.75rem) 0 2rem;
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

  /* SUCCESS POPUP */

  .register-success-overlay {
    position: fixed;
    inset: 0;
    background: rgba(15, 23, 42, 0.42);
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 24px;
    z-index: 9999;
    backdrop-filter: blur(6px);
  }

  .register-success-card {
    background: #fff;
    border: 1px solid rgba(226, 232, 240, 0.95);
    border-radius: 20px;
    padding: 24px;
    max-width: 440px;
    width: min(100%, 440px);
    text-align: left;
    box-shadow: 0 24px 70px rgba(15, 23, 42, 0.22);
    animation: successPopup .35s ease;
  }

  .register-success-icon {
    width: 52px;
    height: 52px;
    display: grid;
    place-items: center;
    margin-bottom: 16px;
    border-radius: 16px;
    background: #ecfdf5;
    color: #059669;
    font-size: 1.45rem;
  }

  .register-success-card p {
    margin: 0 0 18px;
    color: #64748b;
    line-height: 1.6;
    font-size: 0.98rem;
  }

  .register-success-title {
    margin: 0 0 8px;
    font-size: 1.35rem;
    line-height: 1.25;
    font-weight: 700;
    color: #111827;
  }

  .register-success-btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 0.55rem;
    width: 100%;
    min-height: 48px;
    padding: 12px 18px;
    border-radius: 14px;
    background: linear-gradient(135deg, #ff4766, #ff2d55);
    color: #fff !important;
    text-decoration: none;
    font-weight: 700;
    border: none;
    cursor: pointer;
    transition: transform 0.2s ease, box-shadow 0.2s ease;
  }

  .register-login-btn {
    display: none;
    align-items: center;
    justify-content: center;
    width: 100%;
    min-height: 48px;
    margin-top: 12px;
    padding: 12px 18px;
    border-radius: 14px;
    background: #111827;
    color: #fff !important;
    text-decoration: none;
    font-weight: 700;
  }

  .register-login-btn.is-visible {
    display: inline-flex;
  }

  .register-initial-content.is-hidden {
    display: none;
  }

  .register-after-wa {
    display: none;
  }

  .register-after-wa.is-visible {
    display: block;
  }

  .register-wa-note {
    display: none;
    margin: 14px 0 0;
    padding: 0.85rem 1rem;
    border-radius: 14px;
    background: #ecfdf5;
    color: #047857;
    font-size: 0.92rem;
    font-weight: 600;
    line-height: 1.5;
  }

  .register-wa-note.is-visible {
    display: block;
  }

  .register-success-btn:hover {
    text-decoration: none;
    transform: translateY(-1px);
    box-shadow: 0 14px 30px rgba(255, 71, 102, 0.24);
  }

  .register-success-btn.is-hidden {
    display: none;
  }

  .register-login-btn:hover {
    text-decoration: none;
    box-shadow: 0 14px 30px rgba(15, 23, 42, 0.16);
  }

  @media (max-width: 900px) {
    .login-wrapper {
      grid-template-columns: 1fr;
      width: min(560px, calc(100% - 32px));
      min-height: calc(100vh - 82px);
      margin-top: 82px;
    }

    .auth-visual {
      display: none;
    }
  }

  @media (max-width: 520px) {
    .login-wrapper {
      min-height: calc(100vh - 78px);
      margin-top: 78px;
      padding: 1rem 0 1.5rem;
    }

    .auth-card {
      border-radius: 22px;
    }
  }

  /* Premium responsive auth layout */
  body {
    min-height: 100vh;
    background:
      radial-gradient(circle at 14% 8%, rgba(255, 77, 109, 0.12), transparent 28%),
      radial-gradient(circle at 88% 18%, rgba(255, 183, 3, 0.14), transparent 26%),
      linear-gradient(180deg, #fffdf9 0%, #f8fafc 54%, #ffffff 100%);
  }

  .login-wrapper {
    width: min(1160px, calc(100% - 40px));
    min-height: calc(100vh - 92px);
    margin-top: 86px;
    gap: clamp(1.5rem, 5vw, 4.5rem);
  }

  .auth-visual {
    position: relative;
    padding: clamp(1.25rem, 3vw, 2rem);
    border-radius: 30px;
    background:
      linear-gradient(135deg, rgba(255, 255, 255, 0.82), rgba(255, 247, 237, 0.72)),
      radial-gradient(circle at 88% 18%, rgba(255, 183, 3, 0.18), transparent 34%);
    border: 1px solid rgba(255, 255, 255, 0.92);
    box-shadow: 0 26px 70px rgba(15, 23, 42, 0.08);
  }

  .auth-visual h1 {
    max-width: 12ch;
    letter-spacing: 0;
  }

  .auth-card {
    border-radius: 30px;
    background: rgba(255, 255, 255, 0.94);
    backdrop-filter: blur(16px);
    box-shadow: 0 26px 70px rgba(15, 23, 42, 0.11);
  }

  .auth-card h2 {
    color: #0f172a;
    letter-spacing: 0;
  }

  .auth-eyebrow {
    padding: 0.45rem 0.8rem;
    background: rgba(255, 77, 109, 0.1);
  }

  .auth-card input {
    min-height: 54px;
    border-radius: 16px;
    background: #ffffff;
  }

  .auth-card button {
    background: linear-gradient(135deg, #ff4d6d, #ffb703);
  }

  @media (max-width: 900px) {
    .login-wrapper {
      width: min(600px, calc(100% - 28px));
      min-height: calc(100vh - 82px);
      margin-top: 82px;
      align-items: start;
    }
  }

  @media (max-width: 520px) {
    .login-wrapper {
      width: calc(100% - 24px);
      margin-top: 78px;
      padding: 0.75rem 0 1.25rem;
    }

    .auth-card {
      padding: 1.15rem;
      border-radius: 22px;
    }

    .auth-card h2 {
      margin-bottom: 1.15rem;
      font-size: 1.55rem;
    }

    .auth-card input,
    .auth-card button {
      min-height: 50px;
    }

    .register-success-card {
      padding: 1.25rem;
      border-radius: 22px;
    }
  }

  @keyframes successPopup {
    from {
      opacity: 0;
      transform: translateY(30px) scale(.96);
    }

    to {
      opacity: 1;
      transform: translateY(0) scale(1);
    }
  }
</style>

<?php if ($data = (session()->getTempdata('verify_popup') ?: session()->getFlashdata('verify_popup'))): ?>
  <div class="register-success-overlay">
    <div class="register-success-card">
      <div class="register-initial-content" id="registerInitialContent">
        <div class="register-success-icon">
          <i class="fas fa-check"></i>
        </div>

        <div class="register-success-title">
          Pendaftaran berhasil
        </div>

        <p>
          Akun Anda sudah dibuat. Kirim pesan konfirmasi ke admin melalui WhatsApp agar akun dapat diverifikasi.
        </p>
      </div>

      <?php
      $adminWa = '6285707559188';

      $msg = urlencode(
        "Halo Admin,\n"
          . "Saya ingin verifikasi akun Kantin G'penk\n\n"
          . "Nama: {$data['name']}\n"
          . "No HP: {$data['no_hp']}"
      );
      ?>

      <a
        href="https://wa.me/<?= $adminWa ?>?text=<?= $msg ?>"
        target="_blank"
        class="register-success-btn"
        id="verifyWaButton">
        <i class="fab fa-whatsapp"></i> Verifikasi via WhatsApp
      </a>

      <div class="register-after-wa" id="registerAfterWa">
        <div class="register-success-icon">
          <i class="fab fa-whatsapp"></i>
        </div>

        <div class="register-success-title">
          Lanjut setelah konfirmasi
        </div>

        <div class="register-wa-note is-visible">
          WhatsApp sudah dibuka. Setelah pesan konfirmasi terkirim, lanjut ke halaman login.
        </div>

        <a href="<?= site_url('login') ?>?registered=1" class="register-login-btn is-visible" id="continueLoginButton">
          Saya sudah konfirmasi, lanjut login
        </a>
      </div>
    </div>
  </div>
<?php endif; ?>

<script>
  document.getElementById('no_hp')?.addEventListener('input', function() {
    this.value = (this.value || '')
      .replace(/\D/g, '')
      .slice(0, 13);
  });

  document.getElementById('registerForm')?.addEventListener('submit', function(e) {
    const phone = document.getElementById('no_hp').value.trim();

    if (!/^08\d{10,11}$/.test(phone)) {
      e.preventDefault();
      alert('Nomor HP harus diawali 08 dan terdiri dari 12 atau 13 angka.');
    }
  });

  window.addEventListener('load', function() {
    const registerCard = document.getElementById('registerCard');
    const hasVerifyPopup = document.querySelector('.register-success-overlay');

    if (registerCard && !hasVerifyPopup) {
      setTimeout(() => {
        registerCard.scrollIntoView({
          block: 'center',
          inline: 'nearest',
          behavior: 'auto'
        });
      }, 80);
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

  document.getElementById('verifyWaButton')?.addEventListener('click', function(e) {
    e.preventDefault();
    window.open(this.href, '_blank');
    this.classList.add('is-hidden');
    document.getElementById('registerInitialContent')?.classList.add('is-hidden');
    document.getElementById('registerAfterWa')?.classList.add('is-visible');
  });

  document.getElementById('continueLoginButton')?.addEventListener('click', function(e) {
    e.preventDefault();
    this.textContent = 'Mengarahkan ke login...';
    this.style.pointerEvents = 'none';

    setTimeout(() => {
      window.location.href = this.href;
    }, 900);
  });
</script>

<?= $this->endSection(); ?>
