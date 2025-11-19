<?php
/** @var string $mode */
/** @var array|null $menu */
/** @var array $cats */
$title = ($mode === 'create' ? 'Tambah' : 'Edit') . ' Menu';
include APPPATH . 'Views/admin/partials/head.php';
?>

<style>
  :root{
    --bg-page: #fdeff0;     /* latar lembut */
    --card-bg: #fff;
    --text-dark: #0b2130;   /* navy gelap */
    --muted: #6b7280;
    --accent: #ff4766;      /* coral/pink */
    --accent-dark: #e03f5d;
    --border: #e9e6e8;
    --shadow: rgba(10,25,40,0.06);
    --success: #1f7d1f;
  }

  /* pastikan background menyeluruh */
  html,body{height:100%;margin:0}
  body{
    min-height:100vh;
    background:var(--bg-page);
    font-family:'Poppins',sans-serif;
    color:var(--text-dark);
    -webkit-font-smoothing:antialiased;
    -moz-osx-font-smoothing:grayscale;
  }

  /* card utama */
  .card{
    max-width:1100px;
    margin:28px auto;
    background:var(--card-bg);
    border-radius:16px;
    box-shadow:0 12px 30px var(--shadow);
    padding:20px;
    box-sizing:border-box;
  }

  .page-head{
    display:flex;
    align-items:center;
    justify-content:space-between;
    gap:12px;
    margin:4px 0 18px;
  }
  .page-head h1{margin:0;font-size:1.25rem;color:var(--text-dark)}
  .page-head .btn{padding:8px 12px;border-radius:10px;background:#fff;border:1px solid var(--border);color:var(--text-dark);text-decoration:none}

  /* grid form */
  .form-grid{display:grid;grid-template-columns:1.1fr .9fr;gap:28px}
  @media (max-width:900px){ .form-grid{grid-template-columns:1fr} }

  .field{margin-bottom:14px}
  .field label{display:block;font-weight:700;margin-bottom:8px;color:var(--text-dark)}
  .help{font-size:.88rem;color:var(--muted);margin-top:6px}

  /* input, textarea, select */
  input[type="text"],
  input[type="number"],
  input[type="file"],
  select,
  textarea {
    width:100%;
    padding:10px 12px;
    border-radius:10px;
    border:1px solid var(--border);
    background:#fff;
    color:var(--text-dark);
    font-size:0.95rem;
    box-sizing:border-box;
    transition: box-shadow .18s, border-color .18s;
  }
  input:focus, textarea:focus, select:focus{
    outline:none;
    border-color:var(--accent);
    box-shadow:0 6px 18px rgba(255,71,102,0.08);
  }
  textarea{min-height:120px;resize:vertical;padding-top:10px}

  /* thumb preview */
  .thumb{
    display:block;
    width:180px;height:180px;object-fit:cover;border-radius:12px;
    box-shadow:0 6px 18px rgba(10,25,40,0.06);border:1px solid var(--border);
    margin-top:10px;
    background:#fff;
  }

  /* row helper */
  .row{display:grid;grid-template-columns:1fr 180px;gap:12px}
  @media (max-width:900px){ .row{grid-template-columns:1fr} }

  /* switches (checkbox labels) */
  .switch{display:flex;align-items:center;gap:10px;margin-top:10px}
  .switch input[type="checkbox"]{width:16px;height:16px;accent-color:var(--accent)}

  /* actions/footer */
  .actions{
    display:flex;
    gap:10px;
    justify-content:flex-end;
    margin-top:18px;
    padding-top:12px;
    border-top:1px solid rgba(14,14,14,0.03);
  }
  .actions .btn{padding:10px 14px;border-radius:10px;border:1px solid var(--border);background:#fff;color:var(--text-dark);text-decoration:none;font-weight:600}
  .actions .btn.btn-primary{background:var(--accent);color:#fff;border:none;box-shadow:0 8px 20px rgba(224,63,93,0.08)}
  .actions .btn.btn-primary:hover{background:var(--accent-dark)}

  /* alert */
  .alert{padding:12px 14px;border-radius:10px;background:#fff6f5;border:1px solid #ffdede;color:#8a2b2b;font-weight:600}

  /* tiny helpers */
  .help.small{font-size:.82rem;color:var(--muted)}
  .field small{color:var(--muted)}

  /* responsive tweaks */
  @media (max-width:520px){
    .card{padding:14px;margin:14px}
    .thumb{width:140px;height:140px}
    .row{grid-template-columns:1fr}
    .form-grid{gap:18px}
  }
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
