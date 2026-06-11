<?= $this->extend('layouts/main'); ?>

<?= $this->section('content'); ?>

<?php
$adminPhone = '085808316292';
$adminWa = preg_replace('/[^\d]/', '', $adminPhone);
if (str_starts_with($adminWa, '0')) {
    $adminWa = '62' . substr($adminWa, 1);
}

$name = $user['name'] ?? '-';
$phone = $user['no_hp'] ?? '-';
$message = urlencode(
    "Halo Admin,\n"
    . "Saya ingin verifikasi akun Kantin G'penk\n\n"
    . "Nama: {$name}\n"
    . "No HP: {$phone}"
);
?>

<main class="verify-wa-page">
  <section class="verify-wa-card">
    <div class="verify-wa-icon">
      <i class="fab fa-whatsapp"></i>
    </div>
    <h1>Verifikasi WhatsApp</h1>
    <p>Kirim pesan konfirmasi ke admin agar akun Anda bisa digunakan untuk memesan.</p>
    <a href="https://wa.me/<?= esc($adminWa); ?>?text=<?= $message; ?>" target="_blank" rel="noopener" class="verify-wa-btn">
      <i class="fab fa-whatsapp"></i>
      Verifikasi via WhatsApp
    </a>
  </section>
</main>

<style>
  .verify-wa-page {
    min-height: calc(100vh - 90px);
    display: grid;
    place-items: center;
    padding: 120px 16px 40px;
    background: linear-gradient(180deg, #fff7f2 0%, #f8fafc 100%);
  }

  .verify-wa-card {
    width: min(100%, 460px);
    padding: 28px;
    border: 1px solid #e5e7eb;
    border-radius: 22px;
    background: #ffffff;
    box-shadow: 0 24px 70px rgba(15, 23, 42, 0.1);
    text-align: center;
  }

  .verify-wa-icon {
    width: 58px;
    height: 58px;
    display: grid;
    place-items: center;
    margin: 0 auto 16px;
    border-radius: 18px;
    background: #dcfce7;
    color: #16a34a;
    font-size: 1.8rem;
  }

  .verify-wa-card h1 {
    margin: 0 0 10px;
    color: #111827;
    font-size: 1.75rem;
    font-weight: 800;
  }

  .verify-wa-card p {
    margin: 0 0 22px;
    color: #64748b;
    line-height: 1.6;
  }

  .verify-wa-btn {
    min-height: 48px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    width: 100%;
    border-radius: 14px;
    background: linear-gradient(135deg, #16a34a, #22c55e);
    color: #ffffff;
    font-weight: 800;
    text-decoration: none;
  }
</style>

<?= $this->endSection(); ?>
