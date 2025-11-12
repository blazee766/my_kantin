<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Pendaftaran Berhasil - KantinKamu</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
  <style>
    body{background:#fff6f1;font-family:'Poppins',sans-serif;margin:0;display:flex;align-items:center;justify-content:center;min-height:100vh}
    .card{background:#fff;border-radius:16px;box-shadow:0 8px 24px rgba(0,0,0,.08);padding:32px;max-width:460px;text-align:center}
    h2{color:#ff6a00;margin:0 0 12px}
    p{color:#555;margin:0 0 20px}
    .actions{display:flex;gap:12px;justify-content:center;flex-wrap:wrap;margin-top:8px}
    .btn{padding:12px 18px;border-radius:10px;border:none;cursor:pointer;font-weight:600}
    .btn-primary{background:#ff6a00;color:#fff}
    .btn-primary:hover{background:#ff8533}
    .btn-ghost{background:#fff;border:1px solid #eee;color:#333}
    .check{font-size:48px;line-height:1;margin-bottom:8px;color:#2ecc71}
    .alert{background:#eaffea;border:1px solid #c6f3c6;color:#207d20;padding:10px 14px;border-radius:10px;margin:12px 0}
  </style>
</head>
<body>
  <div class="card">
    <div class="check">✓</div>
    <h2>Pendaftaran Berhasil</h2>

    <?php if(session()->getFlashdata('success')): ?>
      <div class="alert"><?= esc(session()->getFlashdata('success')); ?></div>
    <?php else: ?>
      <p>Akun kamu sudah dibuat. Silakan masuk untuk mulai memesan.</p>
    <?php endif; ?>

    <div class="actions">
      <a class="btn btn-primary" href="<?= site_url('login'); ?>">Masuk Sekarang</a>
    </div>
  </div>
</body>
</html>
