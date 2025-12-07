<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title><?= esc($title ?? 'Admin'); ?></title>
  <link href="<?= base_url('assets/sbadmin2/vendor/fontawesome-free/css/all.min.css'); ?>" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@200;300;400;600;700;800;900&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
  <link href="<?= base_url('assets/sbadmin2/css/sb-admin-2.min.css'); ?>" rel="stylesheet">
  <link href="<?= base_url('assets/sbadmin2/css/custom.css'); ?>" rel="stylesheet">
</head>

<body id="page-top">

  <div id="wrapper">

    <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

      <a class="sidebar-brand d-flex align-items-center justify-content-center" href="<?= base_url('/'); ?>">
        <div class="sidebar-brand-icon rotate-n-10">
          <i class="fas fa-utensils"></i>
        </div>
        <div class="sidebar-brand-text mx-1">Kantin G'penk</div>
      </a>

      <hr class="sidebar-divider my-0">
      <li class="nav-item">
        <a class="nav-link" href="<?= base_url('/'); ?>">
          <i class="fas fa-fw fa-home"></i>
          <span>Beranda</span>
        </a>
      </li>

      <hr class="sidebar-divider">

      <div class="sidebar-heading">
        Navigasi
      </div>

      <li class="nav-item">
        <a class="nav-link" href="<?= base_url('admin/menus'); ?>">
          <i class="fas fa-fw fa-list"></i>
          <span>Kelola Menu</span>
        </a>
      </li>

      <li class="nav-item">
        <a class="nav-link" href="<?= base_url('admin/orders'); ?>">
          <i class="fas fa-fw fa-shopping-cart"></i>
          <span>Proses Menu</span>
        </a>
      </li>

      <li class="nav-item">
        <a class="nav-link" href="<?= base_url('admin/reports'); ?>">
          <i class="fas fa-fw fa-chart-area"></i>
          <span>Laporan</span>
        </a>
      </li>

      <hr class="sidebar-divider d-none d-md-block">

      <li class="nav-item">
        <a class="nav-link" href="<?= base_url('logout'); ?>">
          <i class="fas fa-fw fa-sign-out-alt"></i>
          <span>Logout</span>
        </a>
      </li>

      <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
      </div>

    </ul>

    <div id="content-wrapper" class="d-flex flex-column">

      <div id="content">

        <nav class="navbar navbar-expand navbar-light bg-white topbar fixed-top shadow">

          <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
            <i class="fa fa-bars"></i>
          </button>

          <ul class="navbar-nav ml-auto">

            <li class="nav-item dropdown no-arrow">
              <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown">
                <span class="mr-2 d-none d-lg-inline text-gray-600 small">Admin</span>
                <i class="fas fa-user-circle fa-lg text-gray-400"></i>
              </a>
              <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                <a class="dropdown-item" href="<?= base_url('logout'); ?>">
                  <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                  Logout
                </a>
              </div>
            </li>

          </ul>
        </nav>
        <div class="container-fluid">
