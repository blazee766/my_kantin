<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login - KantinKamu</title>
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
  }

  .auth-card {
    background: var(--card-bg);
    border-radius: 15px;
    box-shadow: 0 4px 22px rgba(0, 0, 0, 0.08);
    width: 380px;
    padding: 2rem 2.5rem;
    text-align: center;
  }

  .auth-card h2 {
    margin-bottom: 1.5rem;
    color: var(--accent);
    font-weight: 700;
  }

  .auth-card form {
    text-align: left;
  }

  .auth-card label {
    display: block;
    margin-bottom: .3rem;
    font-weight: 500;
    color: var(--text-dark);
  }

  .auth-card input {
    width: 100%;
    padding: .6rem .8rem;
    margin-bottom: 1rem;
    border: 1px solid var(--field-border);
    border-radius: 8px;
    font-size: 14px;
    background: #fff;
    color: var(--text-dark);
  }

  .auth-card button {
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

  .auth-card button:hover {
    background: var(--accent-dark);
  }

  .auth-card p {
    margin-top: 1rem;
    font-size: 14px;
    color: var(--muted);
  }

  .auth-card a {
    color: var(--accent);
    text-decoration: none;
    font-weight: 600;
  }

  .auth-card a:hover {
    text-decoration: underline;
  }
</style>

</head>

<body>
  <div class="auth-card">
    <h2>Masuk ke KantinKamu</h2>

    <?php if (session()->getFlashdata('error')): ?>
      <p style="color:red;"><?= esc(session('error')); ?></p>
    <?php endif; ?>

    <form method="post" action="<?= base_url('login'); ?>">
      <?= csrf_field(); ?>
      <label for="npm">NPM</label>
      <input type="text" name="npm" id="npm" maxlength="10" pattern="\d{10}" placeholder="Masukkan NPM Anda" required>


      <label>Password</label>
      <input type="password" name="password" placeholder="••••••" required>

      <button type="submit">Masuk</button>
    </form>

    <p>Belum punya akun? <a href="<?= base_url('register'); ?>">Daftar di sini</a></p>
  </div>
</body>

</html>