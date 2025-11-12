<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Register - KantinKamu</title>
  <link rel="stylesheet" href="<?= base_url('assets/css/style.css'); ?>">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

  <style>
    body {
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      background-color: #fff6f1;
      font-family: 'Poppins', sans-serif;
    }

    .auth-card {
      background: #fff;
      border-radius: 15px;
      box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
      width: 400px;
      padding: 2rem 2.5rem;
      text-align: center;
    }

    .auth-card h2 {
      margin-bottom: 1.5rem;
      color: #ff6a00;
      font-weight: 700;
    }

    form {
      text-align: left;
    }

    label {
      display: block;
      margin-bottom: .3rem;
      font-weight: 500;
      color: #444;
    }

    input {
      width: 100%;
      padding: .6rem .8rem;
      margin-bottom: 1rem;
      border: 1px solid #ddd;
      border-radius: 8px;
      font-size: 14px;
    }

    button {
      width: 100%;
      background: #ff6a00;
      border: none;
      color: #fff;
      font-size: 1rem;
      padding: .7rem 0;
      border-radius: 8px;
      cursor: pointer;
      transition: background .3s;
    }

    button:hover {
      background: #e95d00;
    }

    p {
      margin-top: 1rem;
      font-size: 14px;
    }

    a {
      color: #ff6a00;
      text-decoration: none;
      font-weight: 500;
    }

    a:hover {
      text-decoration: underline;
    }
  </style>
</head>

<body>
  <div class="auth-card">
    <h2>Daftar Akun Baru</h2>

    <?php if (session()->getFlashdata('error')): ?>
      <p style="color:red;"><?= esc(session('error')); ?></p>
    <?php endif; ?>
    <?php if (session()->getFlashdata('success')): ?>
      <p style="color:green;"><?= esc(session('success')); ?></p>
    <?php endif; ?>

    <form method="post" action="<?= base_url('register/save'); ?>">
      <?= csrf_field(); ?>
      <label>Nama Lengkap</label>
      <input type="text" name="name" required value="<?= old('name'); ?>">

      <label for="npm">NPM</label>
      <input type="text" name="npm" id="npm" pattern="\d{10}" maxlength="10" required placeholder="Masukkan NPM Anda">

      <label>Password</label>
      <input type="password" name="password" required>

      <label>Konfirmasi Password</label>
      <input type="password" name="password_confirm" required>

      <button type="submit">Daftar</button>
    </form>

    <p>Sudah punya akun? <a href="<?= base_url('login'); ?>">Sign In di sini</a></p>
  </div>
</body>

</html>