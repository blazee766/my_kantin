<?php
$title = 'Buat Pesanan';
include APPPATH . 'Views/admin/partials/head.php';
?>

<style>
  .order-create-card {
    border: 0;
    border-radius: 18px;
    box-shadow: 0 18px 44px rgba(31, 44, 71, 0.08);
    overflow: hidden;
  }

  .order-create-card .card-header {
    background: linear-gradient(135deg, rgba(255, 71, 102, 0.08), rgba(255, 183, 3, 0.12));
    border-bottom: 1px solid #edf0f6;
    padding: 22px 26px;
  }

  .order-create-card .card-header h6 {
    color: var(--primary);
    font-weight: 800;
    margin: 0;
  }

  .form-grid {
    display: grid;
    grid-template-columns: minmax(0, 1fr) minmax(0, 1fr);
    gap: 16px;
  }

  .form-group label {
    color: #657089;
    font-size: 0.78rem;
    font-weight: 800;
    letter-spacing: 0.04em;
    text-transform: uppercase;
  }

  .order-items {
    border: 1px solid #edf0f6;
    border-radius: 14px;
    overflow: hidden;
  }

  .order-items table {
    margin: 0;
  }

  .order-items th {
    border-top: 0;
    color: #657089;
    font-size: 0.78rem;
    letter-spacing: 0.04em;
    text-transform: uppercase;
  }

  .admin-buyer-pill {
    min-height: 48px;
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 10px 14px;
    border-radius: 12px;
    background: #f8fafc;
    border: 1px solid #edf0f6;
    color: #142033;
    font-weight: 800;
  }

  .paid-pill {
    min-height: 48px;
    display: inline-flex;
    align-items: center;
    gap: 10px;
    width: 100%;
    padding: 10px 14px;
    border-radius: 12px;
    background: #dcfce7;
    border: 1px solid #bbf7d0;
    color: #128454;
    font-weight: 800;
    box-sizing: border-box;
  }

  .menu-search {
    min-width: 260px;
  }

  .menu-hint {
    display: block;
    margin-top: 4px;
    color: #7b8496;
    font-size: 0.78rem;
    font-weight: 700;
  }

  .total-box {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 12px;
    margin-top: 16px;
    padding: 16px;
    border-radius: 14px;
    background: #f8fafc;
    border: 1px solid #edf0f6;
    font-weight: 800;
  }

  .total-box strong {
    color: #142033;
    font-size: 1.25rem;
  }

  .btn-soft {
    background: #fff;
    border: 1px solid #edf0f6;
    color: #334155;
  }

  .btn-primary {
    background: linear-gradient(135deg, #ff4766, #ffb703) !important;
    border: 0 !important;
  }

  @media (max-width: 768px) {
    .form-grid {
      grid-template-columns: 1fr;
    }
  }
</style>

<div class="d-sm-flex align-items-center justify-content-between mb-4">
  <div>
    <h1 class="h3 mb-1 text-gray-800">Buat Pesanan Kantin</h1>
    <p class="mb-0 text-muted">Pesanan kasir untuk pembeli yang sedang berada di kantin.</p>
  </div>
  <a href="<?= base_url('admin/orders'); ?>" class="btn btn-sm btn-soft">
    <i class="fas fa-arrow-left"></i>
    Kembali
  </a>
</div>

<?php if (session('error')): ?>
  <div class="alert alert-danger"><?= esc(session('error')); ?></div>
<?php endif; ?>

<form action="<?= base_url('admin/orders/store'); ?>" method="post" class="card order-create-card mb-4" id="adminOrderForm" data-ajax-form data-ajax-action="save-admin-order">
  <?= csrf_field(); ?>
  <div class="card-header">
    <h6>Informasi Pesanan</h6>
  </div>
  <div class="card-body">
    <div class="form-grid">
      <div class="form-group">
        <label>Nama Pesanan</label>
        <div class="admin-buyer-pill">
          <i class="fas fa-user-shield"></i>
          Admin
        </div>
      </div>

      <div class="form-group">
        <label>Pembayaran</label>
        <div class="paid-pill">
          <i class="fas fa-check-circle"></i>
          Lunas
        </div>
      </div>
    </div>

    <div class="form-group">
      <label for="notes">Catatan</label>
      <textarea name="notes" id="notes" class="form-control" rows="2" placeholder="Opsional"><?= esc(old('notes') ?? ''); ?></textarea>
    </div>

    <div class="d-flex justify-content-between align-items-center mt-4 mb-2">
      <h6 class="m-0 font-weight-bold text-primary">Item Pesanan</h6>
      <button type="button" class="btn btn-sm btn-soft" id="addItem">
        <i class="fas fa-plus"></i>
        Tambah Item
      </button>
    </div>

    <div class="order-items table-responsive">
      <datalist id="menuChoices">
        <?php foreach ($menus as $menu): ?>
          <option value="<?= esc($menu['name']); ?>" label="<?= esc($menu['name']); ?> - Rp <?= number_format((int) $menu['price'], 0, ',', '.'); ?> (<?= (int) $menu['stock']; ?> stok)"></option>
        <?php endforeach; ?>
      </datalist>
      <table class="table">
        <thead>
          <tr>
            <th>Menu</th>
            <th style="width: 120px;">Qty</th>
            <th style="width: 150px;">Subtotal</th>
            <th style="width: 80px;">Aksi</th>
          </tr>
        </thead>
        <tbody id="itemRows"></tbody>
      </table>
    </div>

    <div class="total-box">
      <span>Total Pesanan</span>
      <strong id="grandTotal">Rp 0</strong>
    </div>

    <div class="d-flex justify-content-end mt-4">
      <button type="submit" class="btn btn-primary">
        <i class="fas fa-save"></i>
        Simpan Pesanan
      </button>
    </div>
  </div>
</form>

<script>
  const menus = <?= json_encode(array_map(static function ($menu) {
      return [
          'id' => (int) $menu['id'],
          'name' => $menu['name'],
          'price' => (int) $menu['price'],
          'stock' => (int) $menu['stock'],
      ];
  }, $menus ?? [])); ?>;

  const rupiah = new Intl.NumberFormat('id-ID', {
    style: 'currency',
    currency: 'IDR',
    maximumFractionDigits: 0
  });

  const itemRows = document.getElementById('itemRows');
  const addItem = document.getElementById('addItem');
  const grandTotal = document.getElementById('grandTotal');
  const adminOrderForm = document.getElementById('adminOrderForm');

  function findMenuByName(name) {
    return menus.find((menu) => menu.name.toLowerCase() === String(name).trim().toLowerCase()) || null;
  }

  function addRow() {
    const row = document.createElement('tr');
    row.innerHTML = `
      <td>
        <input type="search" class="form-control menu-search" list="menuChoices" placeholder="Cari nama menu..." autocomplete="off" required>
        <input type="hidden" name="menu_id[]" class="menu-id">
      </td>
      <td>
        <input type="number" name="qty[]" class="form-control qty-input" min="1" value="1" required>
      </td>
      <td class="subtotal-cell">Rp 0</td>
      <td>
        <button type="button" class="btn btn-sm btn-danger remove-item">
          <i class="fas fa-trash"></i>
        </button>
      </td>
    `;
    itemRows.appendChild(row);
    updateTotals();
  }

  function updateTotals() {
    let total = 0;
    itemRows.querySelectorAll('tr').forEach((row) => {
      const menuSearch = row.querySelector('.menu-search');
      const menuId = row.querySelector('.menu-id');
      const qtyInput = row.querySelector('.qty-input');
      const menu = findMenuByName(menuSearch.value);
      const price = Number(menu?.price || 0);
      const stock = Number(menu?.stock || 0);
      const qty = Math.max(0, Number(qtyInput.value || 0));

      menuId.value = menu?.id || '';

      if (stock > 0) {
        qtyInput.max = stock;
      }

      const subtotal = price * qty;
      total += subtotal;
      row.querySelector('.subtotal-cell').textContent = rupiah.format(subtotal);
    });

    grandTotal.textContent = rupiah.format(total);
  }

  addItem.addEventListener('click', addRow);

  itemRows.addEventListener('input', (event) => {
    if (event.target.matches('.qty-input, .menu-search')) updateTotals();
  });

  itemRows.addEventListener('click', (event) => {
    const button = event.target.closest('.remove-item');
    if (!button) return;
    button.closest('tr').remove();
    if (!itemRows.children.length) addRow();
    updateTotals();
  });

  adminOrderForm.addEventListener('submit', (event) => {
    updateTotals();

    const invalid = Array.from(itemRows.querySelectorAll('.menu-id')).some((input) => !input.value);
    if (invalid) {
      event.preventDefault();
      alert('Pilih menu dari hasil pencarian terlebih dahulu.');
    }
  });

  addRow();
</script>

<?php include APPPATH . 'Views/admin/partials/foot.php'; ?>
