<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <title>Pembayaran QRIS</title>
  <style>
  body {
    margin: 0;
    min-height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
    background: #f6f0f4;
    font-family: 'Poppins', sans-serif;
    color: #2b2b34;
    padding: 20px;
    box-sizing: border-box;
  }

  .card {
    width: 100%;
    max-width: 430px;
    background: #ffffff;
    border-radius: 28px;
    box-shadow: 0 18px 45px rgba(0, 0, 0, 0.08);
    padding: 30px;
    box-sizing: border-box;
  }

  .card h1 {
    margin-top: 0;
    margin-bottom: 10px;
    font-size: 28px;
    font-weight: 700;
    color: #ff4d6d;
  }

  .card p {
    margin: 8px 0;
    line-height: 1.6;
    color: #5b5b68;
  }

  .meta {
    display: grid;
    gap: 16px;
    margin: 26px 0;
  }

  .meta span {
    display: block;
    font-size: 0.95rem;
    color: #666674;
  }

  .meta strong {
    display: block;
    margin-top: 4px;
    font-size: 1.1rem;
    color: #1f1f27;
    font-weight: 700;
  }

  .qr-box {
    width: 100%;
    padding: 24px;
    border: 1px solid rgba(0,0,0,.06);
    border-radius: 24px;
    background: #fafafa;
    text-align: center;
    margin-bottom: 28px;
    box-sizing: border-box;
  }

  .qr-label {
    margin-bottom: 16px;
    font-size: 1rem;
    font-weight: 600;
    color: #4b5563;
  }

  .qr-code {
    width: 240px;
    height: 240px;
    margin: 0 auto;
    display: block;
  }

  .note {
    margin-top: 18px;
    font-size: 0.9rem;
    line-height: 1.6;
    color: #71717a;
  }

  .btn-row {
    display: flex;
    gap: 14px;
    justify-content: center;
    align-items: center;
    flex-wrap: wrap;
  }

  .btn {
    border: none;
    border-radius: 999px;
    padding: 14px 24px;
    font-weight: 600;
    font-size: 0.95rem;
    cursor: pointer;
    transition: all .25s ease;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    justify-content: center;
  }

  .btn-primary {
    background: linear-gradient(135deg, #ff5f6d, #ff3d57);
    color: #fff;
    box-shadow: 0 8px 20px rgba(255, 77, 109, 0.25);
  }

  .btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 24px rgba(255, 77, 109, 0.35);
  }

  .btn-secondary {
    background: #f3f4f6;
    color: #4b5563;
    text-decoration: none;
  }

  .btn-secondary:hover {
    background: #e5e7eb;
    transform: translateY(-2px);
  }

  form {
    margin: 0;
  }

  @media (max-width: 480px) {
    .card {
      padding: 24px;
      border-radius: 24px;
    }

    .btn-row {
      flex-direction: column;
    }

    .btn {
      width: 100%;
    }

    .qr-code {
      width: 210px;
      height: 210px;
    }
  }
</style>
</head>
<body>
  <div class="card">
    <h1>QRIS Pembayaran</h1>
    <p>Scan QR berikut untuk melakukan pembayaran pesanan.</p>

    <div class="meta">
      <span>Kode Pesanan <strong>#<?= esc($order['code']); ?></strong></span>
      <span>Total Tagihan <strong>Rp <?= number_format((int)$order['total_amount'], 0, ',', '.'); ?></strong></span>
      <span>Metode <strong>QRIS</strong></span>
    </div>

    <div class="qr-box">
      <div class="qr-label">QRIS</div>
      <svg class="qr-code" viewBox="0 0 260 260" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="QRIS Simulasi">
        <rect width="260" height="260" fill="#fff"/>
        <g fill="#111">
          <rect x="12" y="12" width="76" height="76" rx="6"/>
          <rect x="172" y="12" width="76" height="76" rx="6"/>
          <rect x="12" y="172" width="76" height="76" rx="6"/>
          <rect x="28" y="28" width="40" height="40" rx="4" fill="#fff"/>
          <rect x="188" y="28" width="40" height="40" rx="4" fill="#fff"/>
          <rect x="28" y="188" width="40" height="40" rx="4" fill="#fff"/>
          <rect x="98" y="52" width="18" height="18"/>
          <rect x="128" y="28" width="18" height="18"/>
          <rect x="158" y="52" width="18" height="18"/>
          <rect x="52" y="98" width="18" height="18"/>
          <rect x="82" y="98" width="18" height="18"/>
          <rect x="112" y="98" width="18" height="18"/>
          <rect x="142" y="98" width="18" height="18"/>
          <rect x="172" y="98" width="18" height="18"/>
          <rect x="28" y="128" width="18" height="18"/>
          <rect x="58" y="128" width="18" height="18"/>
          <rect x="88" y="128" width="18" height="18"/>
          <rect x="118" y="128" width="18" height="18"/>
          <rect x="148" y="128" width="18" height="18"/>
          <rect x="178" y="128" width="18" height="18"/>
          <rect x="28" y="158" width="18" height="18"/>
          <rect x="58" y="158" width="18" height="18"/>
          <rect x="88" y="158" width="18" height="18"/>
          <rect x="118" y="158" width="18" height="18"/>
          <rect x="148" y="158" width="18" height="18"/>
          <rect x="178" y="158" width="18" height="18"/>
          <rect x="98" y="188" width="18" height="18"/>
          <rect x="128" y="188" width="18" height="18"/>
          <rect x="158" y="188" width="18" height="18"/>
          <rect x="172" y="172" width="18" height="18"/>
          <rect x="142" y="142" width="18" height="18"/>
        </g>
      </svg>
      <p class="note">Ini hanya simulasi. Gunakan aplikasi e-wallet atau QRIS untuk melakukan scan di implementasi sebenarnya.</p>
    </div>

    <div class="btn-row">
      <a href="<?= site_url('p/orders/' . $order['id']); ?>" class="btn btn-secondary">Kembali ke Pesanan</a>
      <form action="<?= site_url('p/payment/' . $order['id'] . '/confirm'); ?>" method="post" style="margin:0;">
        <?= csrf_field(); ?>
        <button type="submit" class="btn btn-primary">Saya Sudah Bayar</button>
      </form>
    </div>
  </div>
</body>
</html>
