<?php
/** @var string $mode */
/** @var array|null $menu */
/** @var array $cats */
$title = ($mode === 'create' ? 'Tambah' : 'Edit') . ' Menu';
include APPPATH . 'Views/admin/partials/head.php';
?>

<style>
  /* scoped styling – aman tidak mengganggu halaman lain */
  .page-head{display:flex;align-items:center;justify-content:space-between;gap:12px;margin:4px 0 18px}
  .form-grid{display:grid;grid-template-columns:1.1fr .9fr;gap:28px}
  .field{margin-bottom:14px}
  .field label{display:block;font-weight:600;margin-bottom:6px}
  .row{display:grid;grid-template-columns:1fr 180px;gap:12px}
  .help{font-size:.85rem;color:#777;margin-top:6px}
  .thumb{display:block;width:180px;height:180px;object-fit:cover;border-radius:12px;
         box-shadow:0 4px 12px rgba(0,0,0,.08);border:1px solid #eee;margin-top:10px}
  .switch{display:flex;align-items:center;gap:10px;margin-top:10px}
  .actions{display:flex;gap:10px;justify-content:flex-end;margin-top:8px;padding-top:12px;border-top:1px solid #f1f1f1}
  @media (max-width:900px){ .form-grid{grid-template-columns:1fr} .row{grid-template-columns:1fr} }
</style>

<div class="card">
  <div class="page-head">
    <h1 style="margin:0"><?= esc($title); ?></h1>
    <a class="btn" href="<?= base_url('admin/menus'); ?>">Kembali</a>
  </div>

  <?php if (session('error')): ?>
    <div class="alert alert-error"><?= esc(session('error')); ?></div>
  <?php endif; ?>

  <form
    action="<?= $mode === 'create'
                ? base_url('admin/menus/store')
                : base_url('admin/menus/' . $menu['id'] . '/update'); ?>"
    method="post" enctype="multipart/form-data">
    <?= csrf_field(); ?>

    <div class="form-grid">

      <!-- KIRI -->
      <div>
        <div class="field">
          <label>Nama Menu</label>
          <input type="text" name="name" required
                 value="<?= old('name', $menu['name'] ?? ''); ?>">
        </div>

        <div class="field">
          <label>Kategori &nbsp;<span class="help">/ Harga (Rp)</span></label>
          <div class="row">
            <select name="category_id" required>
              <option value="">-- Pilih Kategori --</option>
              <?php foreach ($cats as $c): ?>
                <option value="<?= $c['id']; ?>"
                  <?= (int)old('category_id', $menu['category_id'] ?? 0) === (int)$c['id'] ? 'selected' : ''; ?>>
                  <?= esc($c['name']); ?>
                </option>
              <?php endforeach; ?>
            </select>
            <input type="number" name="price" min="0" step="1" required
                   value="<?= old('price', $menu['price'] ?? ''); ?>">
          </div>
        </div>

        <div class="field">
          <label>Stok</label>
          <input type="number" name="stock" min="0"
                 value="<?= old('stock', $menu['stock'] ?? 0); ?>">
          <div class="help">Stok akan otomatis berkurang saat ada pesanan.</div>
        </div>

        <div class="field">
          <label>Deskripsi</label>
          <textarea name="description" rows="5"
            placeholder="Tulis deskripsi singkat menu (opsional)"><?= old('description', $menu['description'] ?? ''); ?></textarea>
        </div>
      </div>

      <!-- KANAN -->
      <div>
        <div class="field">
          <label>Gambar</label>
          <input type="file" name="image" accept="image/*" id="imgInput">
          <?php
            $currentImg = old('image', $menu['image'] ?? '');
            $src = $currentImg ? base_url('assets/img/' . $currentImg) : '';
          ?>
          <img id="imgPreview" class="thumb" src="<?= $src; ?>" alt="<?= $src ? 'Preview' : ''; ?>"
               style="<?= $src ? '' : 'display:none'; ?>">
          <div class="help">Format disarankan: JPG/PNG, rasio persegi.</div>
        </div>

        <div class="switch">
          <label><input type="checkbox" name="is_active" value="1"
            <?= old('is_active', $menu['is_active'] ?? 1) ? 'checked' : ''; ?>> Aktif</label>
        </div>
        <div class="switch">
          <label><input type="checkbox" name="is_popular" value="1"
            <?= old('is_popular', $menu['is_popular'] ?? 0) ? 'checked' : ''; ?>> Tandai sebagai Populer</label>
        </div>
      </div>

    </div>

    <div class="actions">
      <a class="btn" href="<?= base_url('admin/menus'); ?>">Batal</a>
      <button class="btn btn-primary" type="submit">
        <i class="fa fa-check"></i> Simpan
      </button>
    </div>
  </form>
</div>

<script>
  // preview gambar langsung
  const imgInput   = document.getElementById('imgInput');
  const imgPreview = document.getElementById('imgPreview');
  if (imgInput) {
    imgInput.addEventListener('change', (e) => {
      const file = e.target.files?.[0];
      if (!file) return;
      const url = URL.createObjectURL(file);
      imgPreview.src = url;
      imgPreview.style.display = 'block';
    });
  }
</script>
</body>
</html>
