<?php $title = 'Kelola Menu';
include APPPATH . 'Views/admin/partials/head.php'; ?>
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
        <th>Aksi</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($menus as $m): ?>
        <tr>
          <td><?php if ($m['image']): ?><img class="thumb" src="<?= base_url('assets/img/' . $m['image']); ?>"><?php endif; ?></td>
          <td><?= esc(ucwords($m['name'])); ?></td>
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