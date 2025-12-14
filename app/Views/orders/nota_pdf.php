<!doctype html>
<html>

<head>
  <meta charset="utf-8">
  <title>Nota <?= esc($order['code'] ?? $order['id']) ?></title>
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <style>
    body {
      font-family: monospace;
      color: #111;
      padding: 8px;
    }

    .wrap {
      max-width: 320px;
      margin: 0 auto;
      text-align: left;
    }

    .center {
      text-align: center;
    }

    .line {
      border-top: 1px dashed #444;
      margin: 6px 0;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      font-size: 13px;
    }

    .subline td {
      padding: 0 0 6px 0;
    }

    .right {
      text-align: right;
    }

    .bold {
      font-weight: bold;
    }

    .mt {
      margin-top: 10px;
    }

    td.name {
      text-align: left;
      padding-right: 8px;
    }

    td.qty {
      text-align: center;
      width: 40px;
    }

    td.price {
      text-align: right;
      width: 90px;
    }

    @media print {
      .btn-print {
        display: none;
      }
    }
  </style>
</head>

<body>

  <div class="wrap">

    <div class="center bold">Kantin G'penk</div>
    <div class="center"><?= date('d M Y H:i', strtotime($order['created_at'] ?? 'now')) ?></div>
    <div class="center">Nota: <?= esc($order['code'] ?? $order['id']) ?></div>

    <?php
    $storeAddress = getenv('STORE_ADDRESS')
    ?>
    <div class="center"><?= esc($storeAddress) ?></div>

    <div class="line"></div>

    <?php
    $group = [];
    foreach ($order['items'] ?? [] as $i) {
      $key = $i['menu_id'] ?? $i['name'];
      $qty = (int)($i['qty'] ?? 0);

      if (isset($i['price'])) {
        $price = (int)$i['price'];
      } elseif (!empty($i['subtotal']) && $qty > 0) {
        $price = (int) round((int)$i['subtotal'] / $qty);
      } else {
        $price = 0;
      }

      $sub = isset($i['subtotal']) ? (int)$i['subtotal'] : ($price * $qty);

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
          <td class="qty"><?= $row['qty'] ?> x @ <?= number_format($row['price'], 0, ',', '.') ?></td>
          <td class="price"><?= number_format($row['sub'], 0, ',', '.') ?></td>
        </tr>
      </table>
    <?php endforeach; ?>

    <div class="line"></div>

    <table>
      <tr>
        <td>Subtotal</td>
        <td class="right"><?= number_format($order['total_amount'] ?? array_sum(array_column($group, 'sub')), 0, ',', '.') ?></td>
      </tr>
      <tr class="bold">
        <td>TOTAL</td>
        <td class="right"><?= number_format($order['total_amount'] ?? array_sum(array_column($group, 'sub')), 0, ',', '.') ?></td>
      </tr>
    </table>

    <div class="line"></div>

    <div class="center">Metode : <?= esc(($order['delivery_method'] ?? 'pickup') === 'delivery' ? 'Diantar' : 'Ambil Sendiri') ?></div>

    <div class="center mt">
      <div class="bold">Terima Kasih</div>
      <div>Selamat Datang Kembali</div>
    </div>

  </div>

</body>

</html>