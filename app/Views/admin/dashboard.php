<?= $this->extend('layouts/main'); ?>
<?= $this->section('content'); ?>
<h2>Dashboard Admin</h2>
<p>Selamat datang, <?= esc(session('user.name')); ?>.</p>
<ul>
  <li>Kelola Menu (nanti)</li>
  <li>Laporan Keuangan (tahap 4)</li>
</ul>
<?= $this->endSection(); ?>
