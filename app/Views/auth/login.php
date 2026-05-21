<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <title>Login - Kantin G'penk</title>

  <link rel="stylesheet" href="<?= base_url('assets/css/style.css'); ?>">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>

<?= $this->extend('layouts/main'); ?>

<?= $this->section('content'); ?>

<div class="login-wrapper">
  <div class="auth-card">

    <h2>Masuk ke Kantin G'penk</h2>

    <?php if (session()->getFlashdata('error')): ?>
      <p style="color:red;"><?= esc(session('error')); ?></p>
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
    width: 380px;
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
</script>

<?= $this->endSection(); ?>