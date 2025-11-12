<form action="<?= site_url('user/update_address'); ?>" method="post" class="form-campus-address">
  <label>Gedung / Fakultas</label>
  <select name="building" required>
    <option value="">-- Pilih Gedung --</option>
    <option value="Gedung A" <?= session('user.building')=='Gedung A'?'selected':''; ?>>Gedung A</option>
    <option value="Gedung B">Gedung B</option>
    <option value="Perpustakaan">Perpustakaan</option>
    <option value="Kantin Utama">Kantin Utama</option>
    <option value="Lab Komputer">Lab Komputer</option>
  </select>

  <label>Ruangan / Lantai</label>
  <input type="text" name="room" value="<?= esc(session('user.room') ?? ''); ?>" placeholder="contoh: Ruang 204 / Lt.2" required>

  <label>Catatan (opsional)</label>
  <input type="text" name="note" value="<?= esc(session('user.note') ?? ''); ?>" placeholder="contoh: dekat tangga">

  <button type="submit" class="btn btn-primary">Simpan Alamat</button>
</form>
