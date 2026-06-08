<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title ?? 'Kantin'); ?></title>
    <link rel="stylesheet" href="<?= base_url('assets/css/style.css?v=' . filemtime(FCPATH . 'assets/css/style.css')); ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script>
        window.APP_BASE = "<?= rtrim(base_url('/'), '/'); ?>/";
    </script>
    <script defer src="<?= base_url('assets/js/script.js?v=' . filemtime(FCPATH . 'assets/js/script.js')); ?>"></script>
    <script defer src="<?= base_url('assets/js/ajax-actions.js?v=' . filemtime(FCPATH . 'assets/js/ajax-actions.js')); ?>"></script>
</head>
<body>
    <!-- Navbar -->
    <header class="page-header">
        <div class="header-brand">
            <div class="brand-icon"><i class="fas fa-utensils"></i></div>
            <div>
                <span class="brand-title">Kantin G'penk</span>
            </div>
        </div>

        <div class="header-actions">
            <div class="header-nav">
                <nav id="nav" aria-label="Primary navigation">
                    <ul class="nav-links">
                        <li><a href="<?= base_url('/'); ?>">Beranda</a></li>
                        <?php if(session('user')): ?>
                            <?php if(session('user.role')==='admin'): ?>
                                <li><a href="<?= base_url('admin/dashboard'); ?>">Dashboard</a></li>
                            <?php else: ?>
                                <li><a href="<?= base_url('orders'); ?>">Pesanan Saya</a></li>
                                <li>
                                    <a href="<?= site_url('p/orders'); ?>" class="icon-btn header-cart" aria-label="Keranjang">
                                        <i class="fas fa-shopping-bag"></i>
                                        <span class="badge cart-count">0</span>
                                    </a>
                                </li>
                            <?php endif; ?>
                        <?php endif; ?>
                    </ul>
                </nav>
            </div>

            <button class="hamburger icon-btn" id="hamburger" type="button" aria-label="Toggle menu" aria-expanded="false">
                <i class="fas fa-bars"></i>
            </button>
        </div>
    </header>

    <!-- Konten utama -->
    <?= $this->renderSection('content'); ?>

    <script>
        const hamburger = document.getElementById('hamburger');
        const nav = document.getElementById('nav');
        const icon = hamburger?.querySelector('i');

        if (hamburger && nav && icon) {
            hamburger.addEventListener('click', () => {
                nav.classList.toggle('active');
                const opened = nav.classList.contains('active');
                hamburger.classList.toggle('is-open', opened);
                hamburger.setAttribute('aria-expanded', opened ? 'true' : 'false');

                if (opened) {
                    icon.classList.remove('fa-bars');
                    icon.classList.add('fa-times');
                } else {
                    icon.classList.remove('fa-times');
                    icon.classList.add('fa-bars');
                }
            });

            document.querySelectorAll('#nav a').forEach(link => {
                link.addEventListener('click', () => {
                    nav.classList.remove('active');
                    hamburger.classList.remove('is-open');
                    hamburger.setAttribute('aria-expanded', 'false');
                    icon.classList.remove('fa-times');
                    icon.classList.add('fa-bars');
                });
            });
        }
    </script>
</body>
</html>
