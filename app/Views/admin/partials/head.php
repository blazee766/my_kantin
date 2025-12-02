<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title><?= esc($title ?? 'Admin'); ?></title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
  <style>
    :root {
      --primary: #ff6a00
    }

    html,
    body {
      margin: 0;
      padding: 0;
      max-width: 100%;
      overflow-x: hidden;
    }

    body {
      font-family: Poppins, system-ui, Arial;
      background: #fff6f1;
      margin: 0
    }

    .wrap {
      max-width: 1000px;
      margin: 24px auto;
      padding: 16px
    }

    .card {
      background: #fff;
      border-radius: 16px;
      box-shadow: 0 8px 20px rgba(0, 0, 0, .06);
      padding: 18px
    }

    h1 {
      margin: .2rem 0 1rem;
      font-size: 1.5rem;
      color: #222
    }

    .topbar {
      display: flex;
      gap: 8px;
      align-items: center;
      margin-bottom: 12px
    }

    .topbar a {
      color: #555;
      text-decoration: none
    }

    .btn {
      display: inline-flex;
      align-items: center;
      gap: .4rem;
      padding: .55rem .9rem;
      border-radius: 10px;
      border: 1px solid #ddd;
      background: #fff;
      cursor: pointer;
      text-decoration: none
    }

    .btn:hover {
      background: #f7f7f7
    }

    .btn-primary {
      background: var(--primary);
      color: #fff;
      border-color: var(--primary)
    }

    .btn-danger {
      background: #e03131;
      color: #fff;
      border-color: #e03131
    }

    table {
      width: 100%;
      border-collapse: collapse
    }

    th,
    td {
      border-bottom: 1px solid #eee;
      padding: .65rem;
      text-align: left;
      font-size: .95rem
    }

    .grid {
      display: grid;
      gap: 12px
    }

    .grid-2 {
      grid-template-columns: repeat(2, minmax(0, 1fr))
    }

    .mb-1 {
      margin-bottom: 10px
    }

    .mb-2 {
      margin-bottom: 16px
    }

    .mt-1 {
      margin-top: 10px
    }

    input[type=text],
    input[type=number],
    textarea {
      width: 100%;
      padding: .6rem .8rem;
      border: 1px solid #ddd;
      border-radius: 10px
    }

    .badge {
      background: #e9ecef;
      border-radius: 999px;
      padding: .15rem .6rem;
      font-size: .78rem
    }

    img.thumb {
      width: 64px;
      height: 64px;
      object-fit: cover;
      border-radius: 10px;
      border: 1px solid #eee
    }

    .alert {
      padding: .6rem .8rem;
      border-radius: 10px;
      margin-bottom: .8rem
    }

    .alert-success {
      background: #e6f4ea
    }

    .alert-error {
      background: #fdecea
    }
  </style>
</head>

<body>
  <div class="wrap">
    <div class="topbar">
      <a href="<?= base_url('/'); ?>"><i class="fa fa-home"></i> Beranda</a>
      <span>·</span>
      <a href="<?= base_url('admin/menus'); ?>">Menu</a>
      <span>·</span>
      <a href="<?= base_url('admin/orders'); ?>">Proses Menu</a>
      <span>·</span>
      <a href="<?= base_url('admin/reports'); ?>">Laporan</a>
      <span style="margin-left:auto"></span>
      <a href="<?= base_url('logout'); ?>">Logout</a>
    </div>