<?php
$title = 'Kelola Menu';
include APPPATH . 'Views/admin/partials/head.php';
?>

<style>
  .img-thumb {
    width: 56px;
    height: 56px;
    object-fit: cover;
    border-radius: .35rem;
    border: 1px solid #e3e6f0;
  }

  .pagination li {
    display: inline-block;
    margin: 0 3px;
  }

  .pagination li a,
  .pagination li span {
    padding: 8px 12px;
    border-radius: 6px;
    border: 1px solid #ddd;
    background: #fff;
    color: #555;
  }

  .pagination li.active span {
    background: #ff4766;
    color: #fff;
    border-color: #ff4766;
  }
</style>

<h1 class="h3 mb-4 text-gray-800">Kelola Menu</h1>

<div class="card shadow mb-4">
  <div class="card-header py-3 d-flex justify-content-between align-items-center">
    <h6 class="m-0 font-weight-bold text-primary">Daftar Menu</h6>
    <a class="btn btn-sm btn-primary" href="<?= base_url('admin/menus/create'); ?>">
      <i class="fas fa-plus"></i> Tambah Menu
    </a>
  </div>

  <div class="card-body">

    <?php if (session('success')): ?>
      <div class="alert alert-success" role="alert">
        <?= esc(session('success')); ?>
      </div>
    <?php endif; ?>

    <?php if (session('error')): ?>
      <div class="alert alert-danger" role="alert">
        <?= esc(session('error')); ?>
      </div>
    <?php endif; ?>

    <div class="table-responsive">
      <table class="table table-bordered table-hover" width="100%" cellspacing="0">
        <thead class="thead-light">
          <tr>
            <th>Gambar</th>
            <th>Nama</th>
            <th>Kategori</th>
            <th>Harga</th>
            <th>Stok</th>
            <th>Aktif</th>
            <th>Populer</th>
            <th style="width: 180px;">Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($menus as $m): ?>
            <tr>
              <td>
                <?php if ($m['image']): ?>
                  <img class="img-thumb" src="<?= base_url('assets/img/' . $m['image']); ?>" alt="">
                <?php endif; ?>
              </td>

              <td><?= esc(ucwords($m['name'])); ?></td>

              <td><?= esc(ucwords($m['category_name'] ?? '-')); ?></td>

              <td>Rp <?= number_format($m['price'], 0, ',', '.'); ?></td>

              <td><?= (int)($m['stock'] ?? 0); ?></td>

              <td>
                <?php if ($m['is_active']): ?>
                  <span class="badge badge-success">Ya</span>
                <?php else: ?>
                  <span class="badge badge-secondary">Tidak</span>
                <?php endif; ?>
              </td>

              <td>
                <?php if (!empty($m['is_popular'])): ?>
                  <span class="badge badge-warning">Ya</span>
                <?php else: ?>
                  <span class="badge badge-light">Tidak</span>
                <?php endif; ?>
              </td>

              <td class="text-nowrap">
                <a class="btn btn-sm btn-info" href="<?= base_url('admin/menus/' . $m['id'] . '/edit'); ?>">
                  <i class="fas fa-pen"></i> Edit
                </a>

                <form action="<?= base_url('admin/menus/' . $m['id'] . '/delete'); ?>"
                  method="post"
                  style="display:inline"
                  onsubmit="return confirm('Hapus menu ini?')">
                  <?= csrf_field(); ?>
                  <button type="submit" class="btn btn-sm btn-danger">
                    <i class="fas fa-trash"></i> Hapus
                  </button>
                </form>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
      <?php if (isset($pager)): ?>
        <div class="d-flex justify-content-center mt-3">
          <?= $pager->links(); ?>
        </div>
      <?php endif; ?>
    </div>

  </div>
</div>
<?php include APPPATH . 'Views/admin/partials/foot.php'; ?>