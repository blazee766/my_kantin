<?php

/** @var string $mode */
/** @var array|null $menu */
/** @var array $cats */
$title = ($mode === 'create' ? 'Tambah' : 'Edit') . ' Menu';
include APPPATH . 'Views/admin/partials/head.php';
?>

<style>
  .img-thumb-preview {
    width: 180px;
    height: 180px;
    object-fit: cover;
    border-radius: .35rem;
  }
</style>

<h1 class="h3 mb-4 text-gray-800"><?= esc($title); ?></h1>

<?php if (session('error')): ?>
  <div class="alert alert-danger" role="alert">
    <?= esc(session('error')); ?>
  </div>
<?php endif; ?>

<div class="card shadow mb-4">
  <div class="card-header py-3 d-flex justify-content-between align-items-center">
    <h6 class="m-0 font-weight-bold text-primary"><?= esc($title); ?></h6>
    <a href="<?= base_url('admin/menus'); ?>" class="btn btn-sm btn-secondary">
      <i class="fas fa-arrow-left"></i> Kembali
    </a>
  </div>

  <div class="card-body">
    <form
      action="<?= $mode === 'create'
                ? base_url('admin/menus/store')
                : base_url('admin/menus/' . $menu['id'] . '/update'); ?>"
      method="post" enctype="multipart/form-data">

      <?= csrf_field(); ?>

      <div class="row">
        <div class="col-lg-7">

          <div class="form-group">
            <label for="name">Nama Menu</label>
            <input type="text"
                   class="form-control"
                   id="name"
                   name="name"
                   required
                   value="<?= old('name', $menu['name'] ?? ''); ?>">
          </div>

          <div class="form-group">
            <label>Kategori / Harga (Rp)</label>
            <div class="form-row">
              <div class="col-md-7 mb-2 mb-md-0">
                <select name="category_id" class="form-control" required>
                  <option value="">-- Pilih Kategori --</option>
                  <?php foreach ($cats as $c): ?>
                    <option value="<?= $c['id']; ?>"
                      <?= (int)old('category_id', $menu['category_id'] ?? 0) === (int)$c['id'] ? 'selected' : ''; ?>>
                      <?= esc($c['name']); ?>
                    </option>
                  <?php endforeach; ?>
                </select>
              </div>
              <div class="col-md-5">
                <input type="number"
                       class="form-control"
                       name="price"
                       min="0"
                       step="1"
                       required
                       value="<?= old('price', $menu['price'] ?? ''); ?>">
              </div>
            </div>
          </div>

          <div class="form-group">
            <label for="stock">Stok</label>
            <input type="number"
                   class="form-control"
                   id="stock"
                   name="stock"
                   min="0"
                   value="<?= old('stock', $menu['stock'] ?? 0); ?>">
            <small class="form-text text-muted">
              Stok akan otomatis berkurang saat ada pesanan.
            </small>
          </div>

          <div class="form-group">
            <label for="description">Deskripsi</label>
            <textarea class="form-control"
                      id="description"
                      name="description"
                      rows="4"
                      placeholder="Tulis deskripsi singkat menu (opsional)"><?= old('description', $menu['description'] ?? ''); ?></textarea>
          </div>
        </div>

        <div class="col-lg-5">

          <div class="form-group">
            <label for="imgInput">Gambar</label>
            <input type="file"
                   class="form-control-file"
                   name="image"
                   accept="image/*"
                   id="imgInput">
            <?php
            $currentImg = old('image', $menu['image'] ?? '');
            $src = $currentImg ? base_url('assets/img/' . $currentImg) : '';
            ?>
            <div class="mt-2">
              <img id="imgPreview"
                   class="img-thumbnail img-thumb-preview"
                   src="<?= $src; ?>"
                   alt="<?= $src ? 'Preview' : ''; ?>"
                   style="<?= $src ? '' : 'display:none'; ?>">
            </div>
            <small class="form-text text-muted">
              Format disarankan: JPG/PNG, rasio persegi.
            </small>
          </div>

          <div class="form-group">
            <div class="custom-control custom-checkbox">
              <input type="checkbox"
                     class="custom-control-input"
                     id="is_active"
                     name="is_active"
                     value="1"
                     <?= old('is_active', $menu['is_active'] ?? 1) ? 'checked' : ''; ?>>
              <label class="custom-control-label" for="is_active">Aktif</label>
            </div>
          </div>

          <div class="form-group">
            <div class="custom-control custom-checkbox">
              <input type="checkbox"
                     class="custom-control-input"
                     id="is_popular"
                     name="is_popular"
                     value="1"
                     <?= old('is_popular', $menu['is_popular'] ?? 0) ? 'checked' : ''; ?>>
              <label class="custom-control-label" for="is_popular">Tandai sebagai Populer</label>
            </div>
          </div>

        </div>
      </div>

      <div class="mt-4 text-right">
        <a class="btn btn-light border" href="<?= base_url('admin/menus'); ?>">Batal</a>
        <button class="btn btn-primary" type="submit">
          <i class="fas fa-check"></i> Simpan
        </button>
      </div>

    </form>
  </div>
</div>

<script>
  const imgInput = document.getElementById('imgInput');
  const imgPreview = document.getElementById('imgPreview');
  if (imgInput) {
    imgInput.addEventListener('change', (e) => {
      const file = e.target.files && e.target.files[0];
      if (!file) return;
      const url = URL.createObjectURL(file);
      imgPreview.src = url;
      imgPreview.style.display = 'block';
    });
  }
</script>
<?php include APPPATH . 'Views/admin/partials/foot.php'; ?>
