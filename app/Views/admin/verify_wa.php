<?php
$title = 'Verifikasi WhatsApp';
include APPPATH . 'Views/admin/partials/head.php';
?>

<style>
  .verify-admin-card {
    border: 1px solid rgba(226, 232, 240, 0.9);
    border-radius: 18px;
    background: #ffffff;
    box-shadow: 0 18px 44px rgba(31, 44, 71, 0.08);
    overflow: hidden;
  }

  .verify-admin-card .card-header {
    padding: 20px 24px;
    background: linear-gradient(135deg, rgba(255, 77, 109, 0.06), rgba(255, 183, 3, 0.08));
    border-bottom: 1px solid #edf0f6;
  }

  .verify-admin-card h6 {
    margin: 0;
    color: #ff4766;
    font-weight: 800;
  }

  .verify-empty {
    padding: 18px;
    border-radius: 14px;
    background: #f8fafc;
    color: #64748b;
    font-weight: 700;
  }
</style>

<div class="d-sm-flex align-items-center justify-content-between mb-4">
  <div>
    <h1 class="h3 mb-1 text-gray-800">Verifikasi WhatsApp</h1>
    <p class="mb-0 text-muted">Kelola akun pembeli yang menunggu verifikasi.</p>
  </div>
</div>

<?php if (session('success')): ?>
  <div class="alert alert-success"><?= esc(session('success')); ?></div>
<?php endif; ?>

<div class="card verify-admin-card mb-4">
  <div class="card-header">
    <h6>Daftar Menunggu Verifikasi</h6>
  </div>
  <div class="card-body">
    <?php if (empty($users)): ?>
      <div class="verify-empty">Tidak ada user yang menunggu verifikasi.</div>
    <?php else: ?>
      <div class="table-responsive">
        <table class="table table-bordered mb-0">
          <thead>
            <tr>
              <th>Nama</th>
              <th>No HP</th>
              <th style="width: 150px;">Aksi</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($users as $user): ?>
              <tr>
                <td><?= esc($user['name'] ?? '-'); ?></td>
                <td><?= esc($user['no_hp'] ?? '-'); ?></td>
                <td>
                  <form action="<?= base_url('admin/verify-wa/' . (int) $user['id']); ?>" method="post">
                    <?= csrf_field(); ?>
                    <button type="submit" class="btn btn-success btn-sm">
                      <i class="fas fa-check"></i>
                      Verifikasi
                    </button>
                  </form>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    <?php endif; ?>
  </div>
</div>

<?php include APPPATH . 'Views/admin/partials/foot.php'; ?>
