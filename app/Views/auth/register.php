<?= $this->extend('layouts/main'); ?>

<?= $this->section('content'); ?>

<div class="login-wrapper">
  <div class="auth-card">
    <h2>Daftar Akun</h2>

    <?php if ($errors = session()->getFlashdata('errors')): ?>
      <div style="color:#c0392b;margin-bottom:12px;">
        <?php foreach ($errors as $e): ?>
          <div><?= esc($e) ?></div>
        <?php endforeach; ?>
      </div>
    <?php elseif (session()->getFlashdata('error')): ?>
      <p style="color:red;"><?= esc(session('error')); ?></p>
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
    background: linear-gradient(180deg, #f8fafc 0%, #fdeff0 100%);
    margin: 0;
    padding: 0;
  }

  .login-wrapper {
    min-height: 100vh;
    display: flex;
    justify-content: center;
    align-items: center;
    background: transparent;
  }

  .auth-card {
    background: #fff;
    border-radius: 15px;
    box-shadow: 0 4px 22px rgba(0, 0, 0, 0.08);
    width: 400px;
    padding: 2rem 2.5rem;
    text-align: center;
  }

  .auth-card h2 {
    margin-bottom: 1.5rem;
    color: #ff4766;
    font-weight: 700;
  }

  .auth-card form {
    text-align: left;
  }

  .auth-card label {
    display: block;
    margin-bottom: .3rem;
    font-weight: 500;
    color: #0b2130;
  }

  .auth-card input {
    width: 100%;
    padding: .6rem .8rem;
    margin-bottom: 1rem;
    border: 1px solid #e6d6d8;
    border-radius: 8px;
    font-size: 14px;
    background: #f3f6fa;
    color: #0b2130;
    box-sizing: border-box;
  }

  .auth-card button {
    width: 100%;
    background: #ff4766;
    border: none;
    color: #fff;
    font-size: 1rem;
    padding: .7rem 0;
    border-radius: 8px;
    cursor: pointer;
    transition: background .25s;
    font-weight: 600;
  }

  .auth-card button:hover {
    background: #e03f5d;
  }

  .auth-card p {
    margin-top: 1rem;
    font-size: 14px;
    color: #6b7280;
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
    margin-bottom: 1rem;
  }

  .password-wrapper input {
    padding-right: 45px;
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
    background: rgba(0, 0, 0, 0.25);
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 9999;
  }

  .register-success-card {
    background: #fff;
    border-radius: 24px;
    padding: 32px 40px;
    max-width: 420px;
    width: 90%;
    text-align: center;
    box-shadow: 0 20px 60px rgba(0, 0, 0, 0.12);
    animation: successPopup .35s ease;
  }

  .register-success-title {
    font-size: 1.4rem;
    font-weight: 700;
    color: #ff4766;
    margin-bottom: 12px;
  }

  .register-success-btn {
    display: inline-block;
    padding: 10px 22px;
    border-radius: 999px;
    background: #ff4766;
    color: #fff !important;
    text-decoration: none;
    font-weight: 600;
    border: none;
    cursor: pointer;
  }

  .register-success-btn:hover {
    background: #e03f5d;
    text-decoration: none;
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

<?php if ($data = session()->getFlashdata('verify_popup')): ?>
  <div class="register-success-overlay">
    <div class="register-success-card">

      <div class="register-success-title">
        Verifikasi WhatsApp
      </div>

      <p>
        Silakan klik tombol di bawah untuk verifikasi akun Anda.
      </p>

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
        onclick="setTimeout(() => window.location.href='<?= site_url('login') ?>', 2000)">
        📲 Verifikasi via WhatsApp
      </a>

      <small style="display:block;margin-top:10px;color:#666">
        Setelah mengirim pesan, silakan login.
      </small>
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
</script>

<?= $this->endSection(); ?>