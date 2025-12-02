<?php $title = 'Kelola Menu';
include APPPATH . 'Views/admin/partials/head.php'; ?>

<style>
  :root {
    --bg-page: #fdeff0;
    --card-bg: #fff;
    --text-dark: #0b2130;
    --muted: #6b7280;
    --accent: #ff4766;
    --accent-dark: #e03f5d;
    --border: #e9e6e8;
    --shadow: rgba(10, 25, 40, 0.06);
    --danger: #ff4d4f;
  }

  html,
  body {
    margin: 0;
    padding: 0;
    max-width: 100%;
    overflow-x: hidden;
  }

  html,
  body {
    height: 100%;
    margin: 0
  }

  body {
    min-height: 100vh;
    background: var(--bg-page);
    font-family: 'Poppins', sans-serif;
    color: var(--text-dark);
    -webkit-font-smoothing: antialiased;
    -moz-osx-font-smoothing: grayscale;
  }

  .card {
    max-width: 1200px;
    margin: 28px auto;
    background: var(--card-bg);
    border-radius: 14px;
    box-shadow: 0 12px 30px var(--shadow);
    padding: 20px;
    box-sizing: border-box;
  }

  .card h1 {
    margin: 0 0 12px;
    color: var(--text-dark);
    font-size: 1.25rem
  }

  .mb-2 {
    margin-bottom: 12px
  }

  .btn {
    display: inline-flex;
    gap: 8px;
    align-items: center;
    padding: 8px 12px;
    border-radius: 10px;
    border: 1px solid var(--border);
    background: #fff;
    color: var(--text-dark);
    text-decoration: none;
    font-weight: 600;
    cursor: pointer;
  }

  .btn:hover {
    box-shadow: 0 8px 20px rgba(10, 25, 40, 0.06)
  }

  .btn.btn-primary {
    background: var(--accent);
    color: #fff;
    border: none;
    box-shadow: 0 8px 20px rgba(224, 63, 93, 0.08)
  }

  .btn.btn-danger {
    background: var(--danger);
    color: #fff;
    border: none
  }

  table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 10px;
    background: transparent;
  }

  thead th {
    text-align: left;
    padding: 12px 10px;
    color: var(--text-dark);
    font-weight: 700;
    border-bottom: 1px solid var(--border);
    vertical-align: middle;
  }

  tbody td {
    padding: 12px 10px;
    border-bottom: 1px solid #f4f3f4;
    vertical-align: middle;
    color: var(--text-dark);
  }

  .thumb {
    width: 56px;
    height: 56px;
    object-fit: cover;
    border-radius: 8px;
    border: 1px solid var(--border);
    box-shadow: 0 6px 16px rgba(10, 25, 40, 0.04);
    display: inline-block;
  }

  .badge {
    display: inline-block;
    padding: 6px 10px;
    border-radius: 999px;
    font-weight: 700;
    font-size: .85rem;
    background: #fff;
    border: 1px solid var(--border);
    color: var(--text-dark)
  }

  td[style*="white-space:nowrap"] {
    white-space: nowrap
  }

  td .btn {
    padding: 6px 10px;
    font-size: .92rem
  }

  .alert {
    padding: 12px 14px;
    border-radius: 10px;
    background: #fff6f5;
    border: 1px solid #ffdede;
    color: #8a2b2b;
    font-weight: 600;
    margin-bottom: 12px
  }

  @media (max-width:880px) {
    .card {
      padding: 16px
    }

    thead th,
    tbody td {
      padding: 10px 8px
    }

    .thumb {
      width: 48px;
      height: 48px
    }
  }

  @media (max-width:520px) {
    .card {
      margin: 12px;
      padding: 12px
    }

    table {
      font-size: .95rem
    }

    .btn {
      padding: 7px 10px
    }
  }
</style>

<div class="card">
  <h1>Kelola Menu</h1>

  <?php if (session('success')): ?><div class="alert alert-success"><?= esc(session('success')); ?></div><?php endif; ?>
  <?php if (session('error')): ?><div class="alert alert-error"><?= esc(session('error')); ?></div><?php endif; ?>

  <div class="mb-2">
    <a class="btn btn-primary" href="<?= base_url('admin/menus/create'); ?>"><i class="fa fa-plus"></i> Tambah Menu</a>
  </div>

  <table>
    <thead>
      <tr>
        <th>Gambar</th>
        <th>Nama</th>
        <th>Kategori</th>
        <th>Harga</th>
        <th>Stok</th>
        <th>Aktif</th>
        <th>Populer</th>
        <th>Aksi</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($menus as $m): ?>
        <tr>
          <td>
            <?php if ($m['image']): ?>
              <img class="thumb" src="<?= base_url('assets/img/' . $m['image']); ?>">
            <?php endif; ?>
          </td>

          <td><?= esc(ucwords($m['name'])); ?></td>

          <td><?= esc(ucwords($m['category_name'] ?? '-')); ?></td>

          <td>Rp <?= number_format($m['price'], 0, ',', '.'); ?></td>

          <td><?= (int)($m['stock'] ?? 0); ?></td>

          <td><?= $m['is_active'] ? '<span class="badge">Ya</span>' : '<span class="badge">Tidak</span>'; ?></td>

          <td><?= !empty($m['is_popular']) ? '<span class="badge">Ya</span>' : '<span class="badge">Tidak</span>'; ?></td>

          <td style="white-space:nowrap">
            <a class="btn" href="<?= base_url('admin/menus/' . $m['id'] . '/edit'); ?>"><i class="fa fa-pen"></i> Edit</a>
            <form action="<?= base_url('admin/menus/' . $m['id'] . '/delete'); ?>" method="post" style="display:inline"
              onsubmit="return confirm('Hapus menu ini?')">
              <?= csrf_field(); ?>
              <button class="btn btn-danger"><i class="fa fa-trash"></i> Hapus</button>
            </form>
          </td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>
</div>
</body>
</html>