<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>Nota <?= esc($order['code'] ?? $order['id']) ?></title>
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <style>
    body { font-family: monospace; color:#111; padding:8px; }
    .wrap { max-width:320px; margin:0 auto; text-align:left; }

    .center { text-align:center; }
    .line { border-top:1px dashed #444; margin:6px 0; }

    table { width:100%; border-collapse:collapse; font-size:13px; }

    .subline td { padding: 0 0 6px 0; }

    .right { text-align:right; }
    .bold { font-weight:bold; }
    .mt { margin-top:10px; }

    @media print { .btn-print { display:none; } }
  </style>
</head>
<body>

<div class="wrap">

  <div class="center bold">Kantin G'penk</div>
  <div class="center"><?= date('d M Y H:i', strtotime($order['created_at'])) ?></div>
  <div class="center">Nota: <?= esc($order['code']) ?></div>

  <div class="line"></div>

  <?php
  $group = [];
  foreach ($order['items'] as $i) {
      $key = $i['menu_id'] ?? $i['name'];
      $qty = (int)$i['qty'];
      $price = (int)$i['price'];
      $sub = $qty * $price;

      if (!isset($group[$key])) {
          $group[$key] = [
              'name' => $i['name'],
              'qty' => $qty,
              'price' => $price,
              'sub' => $sub
          ];
      } else {
          $group[$key]['qty'] += $qty;
          $group[$key]['sub'] += $sub;
      }
  }
  ?>

  <?php foreach ($group as $row): ?>
    <div class="bold"><?= esc($row['name']) ?></div>

    <table>
      <tr class="subline">
        <td><?= $row['qty'] ?> x @ <?= number_format($row['price'],0,',','.') ?></td>
        <td class="right"><?= number_format($row['sub'],0,',','.') ?></td>
      </tr>
    </table>
  <?php endforeach; ?>

  <div class="line"></div>

  <table>
    <tr>
      <td>Subtotal</td>
      <td class="right"><?= number_format($order['total_amount'],0,',','.') ?></td>
    </tr>
    <tr class="bold">
      <td>TOTAL</td>
      <td class="right"><?= number_format($order['total_amount'],0,',','.') ?></td>
    </tr>
  </table>

  <div class="line"></div>

  <div>Metode : <?= esc($order['delivery_method'] === 'delivery' ? 'Diantar' : 'Ambil Sendiri') ?></div>
  <div>Nama   : <?= esc($order['customer_name']) ?></div>
</div>

</body>
</html>
