<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Detail Pesanan - KantinKamu</title>
  <link rel="stylesheet" href="<?= base_url('assets/css/style.css'); ?>">
  <style>
  :root{
    --bg-page: #fdeff0;       /* pink lembut */
    --card-bg: #ffffff;
    --text-dark: #0b2130;     /* navy gelap */
    --muted: #6b7280;
    --accent: #ff4766;        /* coral/pink */
    --accent-dark: #e03f5d;
    --shadow: rgba(10,25,40,0.06);
    --table-border: #f3f2f4;
    --danger: #ff4d4f;
    --ghost-border: #eee;
  }

  body{
    background: var(--bg-page);
    margin:0;
    font-family: 'Poppins', sans-serif;
    color: var(--text-dark);
    min-height: 100vh;       /* memastikan latar belakang memenuhi seluruh layar */
    padding: 0;
}

.container{
    max-width: 1100px;
    margin: 0 auto;          /* hilangkan jarak atas */
    padding: 20px 16px;      /* beri padding agar konten tidak mepet */
}

  .section{
    background: var(--card-bg);
    border-radius: 16px;
    box-shadow: 0 6px 16px var(--shadow);
    padding: 16px;
    margin: 16px 0;
  }

  .section h2, .section h3{
    margin:0 0 8px 0;
    color: var(--accent);
    font-weight:700;
  }

  p{
    color: var(--muted);
    margin:6px 0;
  }

  table{
    width:100%;
    border-collapse: collapse;
    margin-top:8px;
    background: transparent;
  }

  th, td{
    padding: 12px 10px;
    border-bottom: 1px solid var(--table-border);
    text-align: left;
    color: var(--text-dark);
    font-size: 0.95rem;
  }

  thead th{
    font-weight:700;
    color: var(--text-dark);
    background: transparent;
  }

  /* Tombol */
  .btn{
    padding: 10px 14px;
    border-radius: 10px;
    text-decoration: none;
    display: inline-block;
    font-weight:600;
    cursor:pointer;
  }

  .btn-primary{
    background: var(--accent);
    color: #fff;
    border: none;
  }

  .btn-primary:hover{
    background: var(--accent-dark);
  }

  .btn-ghost{
    background: #fff;
    border: 1px solid var(--ghost-border);
    color: var(--text-dark);
  }

  .btn-danger{
    background: var(--danger);
    color: #fff;
    border: none;
  }

  .btn-inline{
    display:inline-flex;
    gap:8px;
    flex-wrap:wrap;
  }

  /* responsive tweak */
  @media (max-width:720px){
    th, td{padding:10px 8px;font-size:0.92rem}
    .section{padding:14px}
  }
</style>

</head>

<body>
  <div class="container">
    <div class="section">
      <h2>Detail Pesanan #<?= esc($order['code'] ?? $order['id']); ?></h2>
      <p>Tanggal: <?= date('d M Y H:i', strtotime($order['created_at'] ?? 'now')); ?></p>
      <p>Total: <b>Rp <?= number_format((int)($order['total_amount'] ?? 0), 0, ',', '.'); ?></b></p>
      <p>Status: <b><?= esc($order['status'] ?? 'pending'); ?></b></p>
    </div>

    <div class="section">
      <h3>Item</h3>
      <table>
        <thead>
          <tr>
            <th>Menu</th>
            <th>Qty</th>
            <th>Harga</th>
            <th>Subtotal</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach (($order['items'] ?? []) as $it): ?>
            <tr>
              <td><?= esc($it['name'] ?? ''); ?></td>
              <td><?= (int)($it['qty'] ?? 0); ?></td>
              <td>Rp <?= number_format((int)($it['price'] ?? 0), 0, ',', '.'); ?></td>
              <td>Rp <?= number_format((int)($it['subtotal'] ?? 0), 0, ',', '.'); ?></td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>

      <div class="btn-inline" style="margin-top:12px">
        <a href="<?= site_url('p/orders'); ?>" class="btn btn-ghost">Kembali</a>
        <a href="<?= site_url('menu'); ?>" class="btn btn-primary">Tambah Pesanan</a>

        <?php if (($order['status'] ?? '') !== 'paid'): ?>
          <!-- Hapus/Batalkan pesanan -->
          <form action="<?= site_url('p/orders/' . $order['id'] . '/delete'); ?>"
            method="post"
            onsubmit="return confirm('Yakin ingin membatalkan pesanan?');"
            style="display:inline">
            <?= csrf_field(); ?>
            <button type="submit" class="btn btn-danger">Hapus / Batalkan</button>
          </form>

        <?php endif; ?>
      </div>
    </div>
  </div>
</body>

</html>