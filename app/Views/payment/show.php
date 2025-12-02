<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <title>Bayar Pesanan</title>

  <!-- Ganti ke app.midtrans.com kalau sudah production -->
  <script src="https://app.sandbox.midtrans.com/snap/snap.js"
          data-client-key="<?= esc($clientKey); ?>"></script>

  <style>
    body {
      font-family: 'Poppins', sans-serif;
      background: #fdeff0;
      display:flex;
      align-items:center;
      justify-content:center;
      min-height:100vh;
      margin:0;
    }
    .card {
      background:#fff;
      padding:20px 22px;
      border-radius:16px;
      box-shadow:0 10px 30px rgba(0,0,0,.08);
      max-width:360px;
      width:90%;
      text-align:center;
    }
    .btn {
      margin-top:14px;
      padding:10px 16px;
      border-radius:999px;
      border:none;
      cursor:pointer;
      font-weight:600;
      background:#ff4766;
      color:#fff;
    }
  </style>
</head>
<body>

<div class="card">
  <h2>Bayar Pesanan</h2>
  <p>#<?= esc($order['code']); ?></p>
  <p>Total: <strong>Rp <?= number_format((int)$order['total_amount'],0,',','.'); ?></strong></p>

  <button id="pay-button" class="btn">Bayar Sekarang</button>
  <p style="font-size:0.85rem;color:#666;margin-top:8px;">
    Kamu akan dialihkan ke halaman pembayaran Midtrans.
  </p>
</div>

<script>
  document.getElementById('pay-button').addEventListener('click', function () {
    window.snap.pay('<?= esc($snapToken); ?>', {
      onSuccess: function(result){
        alert('Pembayaran berhasil!');
        window.location.href = "<?= site_url('p/orders/'.$order['id']); ?>";
      },
      onPending: function(result){
        alert('Pembayaran tertunda. Silakan selesaikan pembayaran.');
      },
      onError: function(result){
        alert('Terjadi kesalahan pembayaran.');
      },
      onClose: function(){
        alert('Kamu menutup jendela pembayaran.');
      }
    });
  });
</script>

</body>
</html>
