<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
  <title>Pembayaran QRIS</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">
  <style>
  body {
    margin: 0;
    min-height: 100vh;
    background:
      radial-gradient(circle at 14% 8%, rgba(255, 77, 109, 0.12), transparent 28%),
      radial-gradient(circle at 88% 18%, rgba(255, 183, 3, 0.14), transparent 26%),
      linear-gradient(180deg, #fffdf9 0%, #f8fafc 54%, #ffffff 100%);
    font-family: 'Poppins', sans-serif;
    color: #0f172a;
    padding: clamp(16px, 4vw, 36px);
    box-sizing: border-box;
  }

  .payment-shell {
    width: 100%;
    max-width: 1120px;
    min-height: calc(100vh - clamp(32px, 8vw, 72px));
    margin: 0 auto;
    display: grid;
    grid-template-columns: minmax(0, 0.95fr) minmax(340px, 440px);
    gap: clamp(1.25rem, 5vw, 3rem);
    align-items: center;
  }

  .payment-hero,
  .card {
    border: 1px solid rgba(226, 232, 240, 0.9);
    background: rgba(255, 255, 255, 0.94);
    box-shadow: 0 26px 70px rgba(15, 23, 42, 0.1);
    backdrop-filter: blur(16px);
  }

  .payment-hero {
    min-height: 540px;
    border-radius: 32px;
    padding: clamp(1.25rem, 4vw, 2.5rem);
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    background:
      linear-gradient(135deg, rgba(255, 255, 255, 0.96), rgba(255, 247, 237, 0.84)),
      radial-gradient(circle at 84% 20%, rgba(255, 183, 3, 0.18), transparent 32%);
  }

  .brand-pill,
  .status-pill {
    display: inline-flex;
    align-items: center;
    width: fit-content;
    border-radius: 999px;
    font-size: 0.86rem;
    font-weight: 700;
  }

  .brand-pill {
    padding: 0.55rem 0.9rem;
    background: rgba(255, 77, 109, 0.12);
    color: #ff4d6d;
  }

  .payment-hero h1 {
    max-width: 11ch;
    margin: 1.1rem 0 1rem;
    font-size: clamp(2.45rem, 6vw, 4.8rem);
    line-height: 1.02;
    letter-spacing: 0;
  }

  .payment-hero p {
    max-width: 54ch;
    margin: 0;
    color: #55657e;
    font-size: clamp(0.98rem, 1.4vw, 1.12rem);
    line-height: 1.75;
  }

  .payment-steps {
    display: grid;
    grid-template-columns: repeat(3, minmax(0, 1fr));
    gap: 0.75rem;
    margin-top: 2rem;
  }

  .payment-step {
    min-height: 96px;
    padding: 0.9rem;
    border-radius: 18px;
    background: rgba(255, 255, 255, 0.86);
    border: 1px solid rgba(226, 232, 240, 0.9);
  }

  .payment-step strong,
  .payment-step span {
    display: block;
  }

  .payment-step strong {
    color: #0f172a;
    font-size: 0.95rem;
  }

  .payment-step span {
    margin-top: 0.35rem;
    color: #64748b;
    font-size: 0.8rem;
    line-height: 1.45;
  }

  .card {
    width: 100%;
    border-radius: 30px;
    padding: clamp(1.15rem, 3vw, 1.8rem);
    box-sizing: border-box;
  }

  .card h1 {
    margin: 0 0 8px;
    font-size: clamp(1.45rem, 3vw, 1.9rem);
    font-weight: 700;
    color: #0f172a;
    letter-spacing: 0;
  }

  .card p {
    margin: 8px 0;
    line-height: 1.6;
    color: #5b5b68;
  }

  .meta {
    display: grid;
    grid-template-columns: repeat(2, minmax(0, 1fr));
    gap: 0.75rem;
    margin: 1.25rem 0;
  }

  .meta span {
    display: block;
    padding: 0.85rem;
    border-radius: 16px;
    background: #f8fafc;
    border: 1px solid rgba(226, 232, 240, 0.9);
    font-size: 0.78rem;
    color: #64748b;
  }

  .meta strong {
    display: block;
    margin-top: 4px;
    font-size: 0.95rem;
    color: #0f172a;
    font-weight: 700;
    word-break: break-word;
  }

  .meta span:nth-child(2) {
    grid-column: 1 / -1;
  }

  .meta span:nth-child(2) strong {
    font-size: clamp(1.35rem, 5vw, 1.85rem);
    color: #ff4d6d;
  }

  .qr-box {
    width: 100%;
    padding: clamp(0.8rem, 3vw, 1rem);
    border: 1px solid rgba(226, 232, 240, 0.95);
    border-radius: 24px;
    background: linear-gradient(180deg, #ffffff, #f8fafc);
    text-align: center;
    margin-bottom: 1rem;
    box-sizing: border-box;
  }

  .qr-label {
    margin-bottom: 0.85rem;
    font-size: 0.92rem;
    font-weight: 600;
    color: #4b5563;
  }

  .qr-image-frame {
    width: min(100%, 310px);
    aspect-ratio: 1 / 1;
    margin: 0 auto;
    padding: 0.75rem;
    border-radius: 22px;
    background: #ffffff;
    border: 1px solid rgba(226, 232, 240, 0.92);
    box-shadow: 0 18px 40px rgba(15, 23, 42, 0.08);
    box-sizing: border-box;
  }

  .qr-code {
    width: 100%;
    height: 100%;
    margin: 0 auto;
    display: block;
    object-fit: contain;
    image-rendering: crisp-edges;
  }

  .note {
    margin: 1rem auto 0;
    transform: translateX(8px);
    width: min(100%, 310px);
    max-width: 310px;
    font-size: 0.82rem;
    line-height: 1.6;
    color: #71717a;
    text-align: center;
  }

  .btn-row {
    display: grid;
    grid-template-columns: 1fr;
    gap: 14px;
  }

  .btn {
    border: none;
    width: 100%;
    height: 50px;
    min-height: 50px;
    border-radius: 16px;
    padding: 0 1rem;
    font-weight: 600;
    font-size: 0.95rem;
    cursor: pointer;
    transition: all .25s ease;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    box-sizing: border-box;
    line-height: 1;
  }

  .btn-primary {
    background: linear-gradient(135deg, #ff4d6d, #ffb703);
    color: #fff;
    box-shadow: 0 8px 20px rgba(255, 77, 109, 0.25);
  }

  .btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 24px rgba(255, 77, 109, 0.35);
  }

  .btn-secondary {
    background: #e5e7eb;
    color: #4b5563;
    border: 1px solid rgba(226, 232, 240, 0.9);
    text-decoration: none;
    box-shadow: 0 8px 20px rgba(15, 23, 42, 0.06);
  }

  .btn-secondary:hover,
  .btn-secondary:focus {
    background: #d9dde3;
    color: #334155;
    transform: translateY(-2px);
    box-shadow: 0 10px 24px rgba(15, 23, 42, 0.1);
    outline: none;
  }

  .btn-secondary:active {
    background: #cfd5dd;
    transform: translateY(0);
    box-shadow: 0 4px 12px rgba(15, 23, 42, 0.08);
  }

  .flash {
    margin: 0 0 1rem;
    padding: 0.85rem 1rem;
    border-radius: 14px;
    border: 1px solid rgba(248, 113, 113, 0.35);
    background: #fff1f2;
    color: #be123c;
    font-size: 0.86rem;
    font-weight: 600;
  }

  .proof-modal {
    position: fixed;
    inset: 0;
    z-index: 50;
    display: none;
    place-items: center;
    padding: 1rem;
    background: rgba(15, 23, 42, 0.5);
  }

  .proof-modal.is-open {
    display: grid;
  }

  .proof-dialog {
    width: min(100%, 430px);
    border-radius: 24px;
    background: #ffffff;
    border: 1px solid rgba(226, 232, 240, 0.95);
    box-shadow: 0 30px 80px rgba(15, 23, 42, 0.22);
    padding: 1.2rem;
    box-sizing: border-box;
  }

  .proof-dialog h2 {
    margin: 0;
    color: #0f172a;
    font-size: 1.25rem;
    line-height: 1.3;
  }

  .proof-dialog p {
    margin: 0.5rem 0 1rem;
    color: #64748b;
    font-size: 0.88rem;
    line-height: 1.6;
  }

  .proof-input {
    width: 100%;
    padding: 0.9rem;
    border-radius: 16px;
    border: 1px dashed #cbd5e1;
    background: #f8fafc;
    box-sizing: border-box;
    color: #334155;
  }

  .proof-preview {
    display: none;
    width: 100%;
    max-height: 240px;
    margin-top: 0.85rem;
    border-radius: 16px;
    object-fit: contain;
    background: #f8fafc;
    border: 1px solid rgba(226, 232, 240, 0.95);
  }

  .proof-preview.is-visible {
    display: block;
  }

  .modal-actions {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 0.75rem;
    margin-top: 1rem;
  }

  form {
    margin: 0;
  }

  @media (max-width: 900px) {
    .payment-shell {
      max-width: 560px;
      min-height: auto;
      grid-template-columns: 1fr;
      align-items: start;
    }

    .payment-hero {
      min-height: auto;
      padding: 1.25rem;
      border-radius: 26px;
    }

    .payment-hero h1 {
      max-width: 100%;
      font-size: clamp(2rem, 9vw, 3rem);
    }

    .payment-steps {
      grid-template-columns: 1fr;
      margin-top: 1.4rem;
    }
  }

  @media (max-width: 480px) {
    body {
      padding: 12px;
    }

    .payment-hero {
      display: none;
    }

    .card {
      padding: 1rem;
      border-radius: 24px;
    }

    .meta {
      grid-template-columns: 1fr;
    }

    .qr-image-frame {
      width: min(100%, 280px);
    }

    .note {
      width: min(100%, 280px);
      max-width: 280px;
      transform: translateX(0);
      font-size: 0.78rem;
    }

    .modal-actions {
      grid-template-columns: 1fr;
    }
  }
</style>
</head>
<body>
  <?php
  $formattedTotal = 'Rp ' . number_format((int)$order['total_amount'], 0, ',', '.');
  $localQrisPath = FCPATH . 'assets/img/qris.png';
  $qrisImage = is_file($localQrisPath)
    ? base_url('assets/img/qris.png')
    : 'https://api.qrserver.com/v1/create-qr-code/?size=420x420&margin=16&data=' . rawurlencode("Kantin G'penk\nPesanan: #{$order['code']}\nTotal: {$formattedTotal}\nMetode: QRIS");
  ?>

  <main class="payment-shell">
    <section class="payment-hero" aria-label="Panduan pembayaran">
      <div>
        <span class="brand-pill">QRIS Pembayaran</span>
        <h1>Scan, bayar, lalu konfirmasi.</h1>
        <p>Pembayaran QRIS dibuat lebih rapi agar mudah discan dari ponsel. Pastikan nominal sudah sesuai dengan total pesanan sebelum menekan tombol konfirmasi.</p>
      </div>

      <div class="payment-steps">
        <div class="payment-step">
          <strong>1. Buka e-wallet</strong>
          <span>Pilih fitur scan QRIS di aplikasi pembayaran favoritmu.</span>
        </div>
        <div class="payment-step">
          <strong>2. Scan QR</strong>
          <span>Arahkan kamera ke gambar QR pembayaran di samping.</span>
        </div>
        <div class="payment-step">
          <strong>3. Konfirmasi</strong>
          <span>Tekan tombol sudah bayar setelah transaksi berhasil.</span>
        </div>
      </div>
    </section>

    <section class="card" aria-label="Detail pembayaran QRIS">
    <h1>QRIS Pembayaran</h1>
    <p>Scan gambar QR berikut untuk melakukan pembayaran pesanan.</p>

    <?php if ($msg = session()->getFlashdata('error')): ?>
      <div class="flash"><?= esc($msg); ?></div>
    <?php endif; ?>

    <div class="meta">
      <span>Kode Pesanan <strong>#<?= esc($order['code']); ?></strong></span>
      <span>Total Tagihan <strong><?= esc($formattedTotal); ?></strong></span>
      <span>Metode <strong>QRIS</strong></span>
    </div>

    <div class="qr-box">
      <div class="qr-label">Scan QRIS</div>
      <div class="qr-image-frame">
        <img class="qr-code" src="<?= esc($qrisImage); ?>" alt="QRIS pembayaran pesanan #<?= esc($order['code']); ?>">
      </div>
      <p class="note">Gunakan aplikasi e-wallet atau mobile banking yang mendukung QRIS, lalu pastikan nominalnya sesuai.</p>
    </div>

    <div class="btn-row">
      <a href="<?= site_url('p/orders/' . $order['id']); ?>" class="btn btn-secondary">Kembali ke Pesanan</a>
      <button type="button" class="btn btn-primary" id="openProofModal">Saya Sudah Bayar</button>
    </div>
    </section>
  </main>

  <div class="proof-modal" id="proofModal" aria-hidden="true">
    <form
      class="proof-dialog"
      action="<?= site_url('p/payment/' . $order['id'] . '/confirm'); ?>"
      method="post"
      enctype="multipart/form-data">
      <?= csrf_field(); ?>
      <h2>Upload Bukti Pembayaran</h2>
      <p>Pilih screenshot atau foto bukti transfer QRIS agar admin bisa memverifikasi pembayaranmu.</p>
      <input
        class="proof-input"
        type="file"
        name="payment_proof"
        id="paymentProofInput"
        accept="image/png,image/jpeg,image/webp"
        required>
      <img class="proof-preview" id="paymentProofPreview" alt="Preview bukti pembayaran">
      <div class="modal-actions">
        <button type="button" class="btn btn-secondary" id="closeProofModal">Batal</button>
        <button type="submit" class="btn btn-primary">Kirim Bukti</button>
      </div>
    </form>
  </div>

  <script>
    const proofModal = document.getElementById('proofModal');
    const openProofModal = document.getElementById('openProofModal');
    const closeProofModal = document.getElementById('closeProofModal');
    const paymentProofInput = document.getElementById('paymentProofInput');
    const paymentProofPreview = document.getElementById('paymentProofPreview');

    function setProofModal(open) {
      proofModal.classList.toggle('is-open', open);
      proofModal.setAttribute('aria-hidden', open ? 'false' : 'true');
    }

    openProofModal?.addEventListener('click', () => setProofModal(true));
    closeProofModal?.addEventListener('click', () => setProofModal(false));
    proofModal?.addEventListener('click', (event) => {
      if (event.target === proofModal) setProofModal(false);
    });

    paymentProofInput?.addEventListener('change', () => {
      const file = paymentProofInput.files?.[0];
      if (!file) {
        paymentProofPreview.classList.remove('is-visible');
        paymentProofPreview.removeAttribute('src');
        return;
      }

      paymentProofPreview.src = URL.createObjectURL(file);
      paymentProofPreview.classList.add('is-visible');
    });
  </script>
</body>
</html>
