<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title ?? 'Kantin'); ?></title>
    <link rel="stylesheet" href="<?= base_url('assets/css/style.css'); ?>">
    <script defer src="<?= base_url('assets/js/script.js'); ?>"></script>
</head>
<body>
    <!-- Navbar -->
    <header>
        <a href="<?= base_url('/'); ?>" class="logo">Kantin</a>
        <nav class="navbar">
            <a href="<?= base_url('/'); ?>">Beranda</a>
            <?php if(session('user')): ?>
                <?php if(session('user.role')==='admin'): ?>
                    <a href="<?= base_url('admin/dashboard'); ?>">Dashboard</a>
                <?php else: ?>
                    <a href="<?= base_url('orders'); ?>">Pesanan Saya</a>
                <?php endif; ?>
                <a href="<?= base_url('logout'); ?>">Logout</a>
            <?php else: ?>
                <a href="<?= base_url('login'); ?>">Login</a>
            <?php endif; ?>
        </nav>
    </header>

    <!-- Konten utama -->
    <?= $this->renderSection('content'); ?>

    <!-- Footer -->
    <footer>
        <p>&copy; <?= date('Y'); ?> Kantin - Semua Hak Dilindungi</p>
    </footer>
</body>
</html>
