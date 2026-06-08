<?php
$title = 'Kelola Menu';
include APPPATH . 'Views/admin/partials/head.php';
?>

<style>
  /* theme variables moved to admin partial head.php */
  .img-thumb {
    width: 72px;
    height: 72px;
    object-fit: cover;
    border-radius: 12px;
    border: 1px solid rgba(0,0,0,0.06);
    box-shadow: 0 6px 18px rgba(0,0,0,0.04);
  }

  /* Card and header */
  .card {
    border-radius: 16px;
    border: none;
    background: var(--card);
    box-shadow: 0 12px 30px rgba(0,0,0,0.06);
  }
  .card-header {
    background: transparent;
    border-bottom: none;
    padding: 18px 24px;
  }
  .card-header h6 {
    color: var(--primary);
    font-weight:700;
    margin:0;
  }

  /* Table style */
  .table {
    border-collapse: separate;
    border-spacing: 0 10px;
  }
  .table thead th {
    background: transparent;
    border: none;
    color: var(--muted);
    font-weight:600;
    padding: 12px 18px;
  }
  .table tbody tr {
    background: var(--card);
    border-radius: 12px;
    box-shadow: 0 6px 14px rgba(0,0,0,0.03);
  }
  .table td {
    vertical-align: middle;
    border: none !important;
    padding: 14px 18px;
  }

  /* Badges */
  .table .badge {
    padding: 6px 10px;
    border-radius: 999px;
    font-weight:600;
  }
  .badge-success { background:#1b7a2e; color:#fff; }
  .badge-warning { background:#ffb020; color:#fff; }
  .badge-secondary { background:#e9ecef; color:#4a4a57; }
  .badge-light { background:#f7f7fb; color:#6b6b75; border:1px solid rgba(0,0,0,0.03); }

  /* Buttons consistent with theme */
  .btn-primary, .btn.btn-sm.btn-primary {
    background: var(--primary) !important;
    border-color: var(--primary) !important;
    color: #fff !important;
    box-shadow: 0 8px 20px rgba(255,71,102,0.12);
  }
  .btn-edit { background: #2b8cff; color:#fff; border:none; }
  .btn-delete { background: #ff5566; color:#fff; border:none; }
  .btn-edit, .btn-delete { padding:6px 10px; border-radius:8px; font-weight:600; }

  /* Pagination */
  .pagination li { display:inline-block; margin:0 4px; }
  .pagination li a, .pagination li span {
    padding:8px 12px; border-radius:8px; border:1px solid transparent; background:#fff; color:#555;
  }
  .pagination li.active span { background: var(--primary); color:#fff; border-color:var(--primary); }
  /* Button text visibility for small screens */
  .btn-text { margin-left:8px; display:inline-block; }
  @media (max-width:576px) {
    .img-thumb { width:48px; height:48px; }
    .table thead th { font-size:0.86rem; }
    .btn-text { display:none; }
    .table td { padding:10px 12px; }
    .card { padding:12px; }
  }

  .admin-menu-table .menu-actions {
    display: flex;
    gap: 0.5rem;
    flex-wrap: wrap;
  }

  @media (max-width: 991.98px) {
    .admin-menu-card .card-header .d-flex.align-items-center {
      align-items: stretch !important;
      flex-direction: column;
      gap: 0.75rem;
    }

    .admin-menu-card .card-header .form-inline {
      margin-right: 0 !important;
    }

    .admin-menu-card .card-body {
      padding: 0.85rem !important;
    }

    .admin-menu-card .table-responsive {
      overflow: visible !important;
      border-radius: 0;
    }

    .admin-menu-table {
      min-width: 0 !important;
      border-spacing: 0 !important;
    }

    .admin-menu-table thead {
      display: none;
    }

    .admin-menu-table,
    .admin-menu-table tbody,
    .admin-menu-table tr,
    .admin-menu-table td {
      display: block;
      width: 100%;
    }

    .admin-menu-table tbody tr {
      margin-bottom: 0.9rem;
      padding: 0.9rem;
      border: 1px solid #eef2f7;
      border-radius: 18px;
      box-shadow: 0 10px 24px rgba(15, 23, 42, 0.06) !important;
    }

    .admin-menu-table tbody td,
    .admin-menu-table tbody td:first-child,
    .admin-menu-table tbody td:last-child {
      display: grid;
      grid-template-columns: minmax(86px, 34%) minmax(0, 1fr);
      gap: 0.75rem;
      align-items: center;
      padding: 0.55rem 0 !important;
      border: 0 !important;
      border-radius: 0;
      word-break: break-word;
    }

    .admin-menu-table tbody td::before {
      content: attr(data-label);
      color: var(--admin-muted);
      font-size: 0.72rem;
      font-weight: 800;
      text-transform: uppercase;
      letter-spacing: 0.04em;
    }

    .admin-menu-table .menu-image-cell {
      grid-template-columns: 1fr;
      gap: 0.4rem;
      padding-top: 0 !important;
    }

    .admin-menu-table .menu-image-cell::before {
      display: none;
    }

    .admin-menu-table .img-thumb {
      width: 72px !important;
      height: 72px !important;
    }

    .admin-menu-table .menu-name-cell {
      color: #111827;
      font-size: 1.02rem;
      font-weight: 800;
    }

    .admin-menu-table .menu-actions {
      justify-content: flex-start;
    }

    .admin-menu-table .menu-actions .btn {
      flex: 1 1 112px;
      min-width: 0;
    }
  }

  @media (max-width: 420px) {
    .admin-menu-table tbody td,
    .admin-menu-table tbody td:first-child,
    .admin-menu-table tbody td:last-child {
      grid-template-columns: 1fr;
      gap: 0.35rem;
    }

    .admin-menu-table .menu-actions {
      display: grid;
      grid-template-columns: 1fr;
    }

    .admin-menu-table .menu-actions form,
    .admin-menu-table .menu-actions .btn {
      width: 100%;
    }
  }
</style>

<h1 class="h3 mb-4 text-gray-800">Kelola Menu</h1>

<div class="card shadow mb-4 admin-menu-card">

  <div class="card-header py-3 d-flex justify-content-between align-items-center">
    <h6 class="m-0 font-weight-bold text-primary">Daftar Menu</h6>

    <div class="d-flex align-items-center">
      <form method="get" class="form-inline mr-2">
        <label class="mr-2 mb-0 small text-muted">Filter:</label>
        <select name="jenis" class="form-control form-control-sm" onchange="this.form.submit()">
          <option value="">Semua</option>
          <option value="makanan" <?= isset($jenis) && $jenis === 'makanan' ? 'selected' : '' ?>>Makanan</option>
          <option value="minuman" <?= isset($jenis) && $jenis === 'minuman' ? 'selected' : '' ?>>Minuman</option>
        </select>
      </form>

      <a class="btn btn-sm btn-primary" href="<?= base_url('admin/menus/create'); ?>">
        <i class="fas fa-plus"></i> Tambah Menu
      </a>
    </div>
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
      <table class="table table-bordered table-hover admin-menu-table" width="100%" cellspacing="0">
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
              <td class="menu-image-cell" data-label="Gambar">
                <?php if ($m['image']): ?>
                  <img class="img-thumb" src="<?= base_url('assets/img/' . $m['image']); ?>" alt="">
                <?php endif; ?>
              </td>

              <td class="menu-name-cell" data-label="Nama"><?= esc(ucwords($m['name'])); ?></td>

              <td data-label="Kategori"><?= esc(ucwords($m['category_name'] ?? '-')); ?></td>

              <td data-label="Harga">Rp <?= number_format($m['price'], 0, ',', '.'); ?></td>

              <td data-label="Stok"><?= (int)($m['stock'] ?? 0); ?></td>

              <td data-label="Aktif">
                <?php if ($m['is_active']): ?>
                  <span class="badge badge-success"><i class="fas fa-check-circle"></i> <span class="badge-text">Ya</span></span>
                <?php else: ?>
                  <span class="badge badge-secondary"><i class="fas fa-times-circle"></i> <span class="badge-text">Tidak</span></span>
                <?php endif; ?>
              </td>

              <td data-label="Populer">
                <?php if (!empty($m['is_popular'])): ?>
                  <span class="badge badge-warning"><i class="fas fa-star"></i> <span class="badge-text">Ya</span></span>
                <?php else: ?>
                  <span class="badge badge-light"><i class="far fa-star"></i> <span class="badge-text">Tidak</span></span>
                <?php endif; ?>
              </td>

              <td class="text-nowrap" data-label="Aksi">
                <div class="menu-actions">
                <a class="btn btn-sm btn-edit" href="<?= base_url('admin/menus/' . $m['id'] . '/edit'); ?>" title="Edit">
                  <i class="fas fa-pen"></i><span class="btn-text">Edit</span>
                </a>

                <form action="<?= base_url('admin/menus/' . $m['id'] . '/delete'); ?>"
                  method="post"
                  style="display:inline"
                  data-ajax-form
                  data-ajax-action="remove-row"
                  data-confirm="Hapus menu ini?">
                  <?= csrf_field(); ?>
                  <button type="submit" class="btn btn-sm btn-delete" title="Hapus">
                    <i class="fas fa-trash"></i><span class="btn-text">Hapus</span>
                  </button>
                </form>
                </div>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
      <?php if (isset($pager)): ?>
        <div class="d-flex justify-content-center mt-3">
          <?= $pager->links('default', 'arrows'); ?>
        </div>
      <?php endif; ?>
    </div>

  </div>
</div>

<?php include APPPATH . 'Views/admin/partials/foot.php'; ?>
