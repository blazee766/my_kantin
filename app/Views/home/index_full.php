<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>KantinKamu - Delightful Food Experience</title>
  <link rel="stylesheet" href="<?= base_url('assets/css/style.css'); ?>">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

</head>

<body>
  <section class="quick-search">
  <div class="searchbar">
    <i class="fas fa-magnifying-glass"></i>
    <input id="qsearch" type="text" placeholder="Lagi mau mamam apa?" aria-label="Cari menu">
    <i class="fas fa-filter"></i>
  </div>
 
</section>

  <?php if ($wel = session()->getFlashdata('welcome')): ?>
    <style>
      .toast {
        position: fixed;
        top: 30px;
        /* tengah atas */
        left: 50%;
        transform: translateX(-50%);
        background: #fff;
        border-left: 6px solid #FF6B35;
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15);
        border-radius: 16px;
        padding: 16px 28px;
        display: flex;
        align-items: center;
        gap: 12px;
        z-index: 9999;
        opacity: 0;
        animation: fadeSlide 0.6s forwards;
      }

      .toast .icon {
        background: #FFE7DE;
        width: 42px;
        height: 42px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
        color: #FF6B35;
      }

      .toast .msg {
        font-weight: 600;
        color: #333;
        font-size: 1rem;
      }

      @keyframes fadeSlide {
        from {
          opacity: 0;
          transform: translate(-50%, -20px);
        }

        to {
          opacity: 1;
          transform: translate(-50%, 0);
        }
      }

      .toast.hide {
        animation: fadeOut 0.5s forwards;
      }

      @keyframes fadeOut {
        to {
          opacity: 0;
          transform: translate(-50%, -20px);
        }
      }
    </style>

    <div class="toast" id="welcomeToast">
      <div class="icon"><i class="fas fa-smile"></i></div>
      <div class="msg"><?= esc($wel) ?></div>
    </div>

    <script>
      // otomatis hilang setelah 3.5 detik
      setTimeout(() => {
        const toast = document.getElementById('welcomeToast');
        if (toast) {
          toast.classList.add('hide');
          setTimeout(() => toast.remove(), 500);
        }
      }, 3600);
    </script>
  <?php endif; ?>


  <div class="container">

    <header>
      <div class="logo"><i class="fas fa-utensils"></i> KantinKamu</div>

      <nav id="nav">
        <ul>
          <li><a href="<?= base_url('/'); ?>">Home</a></li>
          <li><a href="<?= base_url('menu'); ?>">Menu</a></li>
          <li><a href="#">Contact</a></li>
          <li><a href="#">About Us</a></li>
          <li><a href="#">Gallery</a></li>
        </ul>
      </nav>

<?php if (session('user')): ?>
  <div class="address-pill" title="Lokasi pengantaran kamu">
    <i class="fas fa-location-dot"></i>
    <span>
      <?= esc(session('user.building') ?? 'Gedung belum diatur'); ?> 
      <?= esc(session('user.room') ? ' - ' . session('user.room') : ''); ?>
    </span>
  </div>
<?php endif; ?>


      <div class="buttons">

        <?php if (session('user')): ?>
          <a href="<?= base_url('logout'); ?>" class="btn">Logout</a>
          <?php if (session('user.role') === 'admin'): ?>
            <a href="<?= base_url('admin'); ?>" class="btn btn-primary">Dashboard</a>
          <?php else: ?>
            <!-- di dalam <div class="buttons"> ... sebelum hamburger -->
<a href="<?= site_url('p/orders'); ?>" class="btn header-cart" aria-label="Keranjang">
  <i class="fas fa-shopping-bag"></i>
  <span class="cart-count" style="display:none">0</span>
</a>
          <?php endif; ?>
        <?php else: ?>
          <a href="<?= base_url('login'); ?>" class="btn">Sign In</a>
          <a href="<?= base_url('register'); ?>" class="btn btn-primary">Sign Up</a>
        <?php endif; ?>

        <div class="hamburger" id="hamburger">
          <i class="fas fa-bars"></i>
        </div>

      </div>
    </header>

    <main>
      <?php if (session()->getFlashdata('success')): ?>
        <div style="text-align:center;background:#fffae6;color:#333;padding:10px;border-radius:8px;margin-top:10px;">
          <?= esc(session()->getFlashdata('success')); ?>
        </div>
      <?php endif; ?>

      <!-- Hero section sama persis -->
      <section class="hero">
        <div class="hero-text">
          <h1>Temukan Keunggulan Kuliner</h1>
          <p>Rasakan pilihan hidangan terbaik yang dibuat dengan sepenuh hati. Dari bahan-bahan segar dari peternakan hingga kreasi yang menggugah selera, setiap gigitan menceritakan sebuah kisah.
          </p>
          <a href="<?= site_url('menu'); ?>" class="btn btn-primary">Explore Menu</a>
          <button class="btn btn-secondary"><i class="fas fa-phone"></i> Order Now</button>
        </div>

        <div class="hero-image">
          <img src="<?= base_url('assets/img/1.png'); ?>" alt="Gourmet Food Selection" id="heroImage">
        </div>
      </section>

      <!-- Section Popular Menu -->
      <section class="popular-dishes" id="menu">
        <h2>Popular Menu</h2>

        <div class="dishes">
          <?php foreach ($menus as $m): ?>
            <div class="dish" data-img="<?= esc($m['image']); ?>">
              <img src="<?= base_url('assets/img/' . esc($m['image'])); ?>" alt="<?= esc($m['name']); ?>">
              <h3><?= esc(ucwords($m['name'])); ?></h3>
              <p><?= esc($m['description']); ?></p>
              <span class="price">Rp <?= number_format($m['price'], 0, ',', '.'); ?></span>
              <button class="add-to-cart"
                data-id="<?= $m['id']; ?>"
                data-name="<?= esc($m['name']); ?>"
                data-price="<?= $m['price']; ?>">
                <i class="fas fa-plus"></i>
              </button>
            </div>
          <?php endforeach; ?>
        </div>
      </section>
    </main>
  </div>
<!-- letakkan sebelum <script src="assets/js/script.js"></script> -->
<script>
  window.APP_BASE = "<?= rtrim(base_url('/'), '/'); ?>/";
  window.ASSETS_BASE = "<?= rtrim(base_url('/'), '/'); ?>/";
</script>

  <script src="<?= base_url('assets/js/script.js'); ?>"></script>

  <!-- Tambahkan keranjang (tidak mengubah tampilan) -->
  <script>
    document.querySelectorAll('.add-to-cart').forEach(btn => {
      btn.addEventListener('click', async () => {
        const payload = new URLSearchParams();
        payload.append('id', btn.dataset.id);
        payload.append('qty', '1');
        const res = await fetch('<?= base_url('cart/add'); ?>', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
          },
          body: payload.toString()
        });
        const data = await res.json().catch(() => ({
          ok: false
        }));
        if (data.ok) {
          const countEl = document.querySelector('.cart-count');
          if (countEl) countEl.textContent = parseInt(countEl.textContent || '0') + 1;
          alert('✅ Ditambahkan ke keranjang: ' + btn.dataset.name);
        } else {
          alert(data.msg || 'Gagal menambah.');
          refreshCartCount();
        }
      });
    });
  </script>

  <script>
    async function addToCart(id) {
      const payload = new URLSearchParams();
      payload.append('id', id);
      payload.append('qty', '1');

      const res = await fetch('<?= site_url('cart/add'); ?>', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: payload.toString()
      });

      if (res.status === 401) {
        const go = confirm('Anda harus login terlebih dahulu untuk memesan. Buka halaman login sekarang?');
        if (go) window.location.href = '<?= site_url('login'); ?>';
        return;
      }

      const data = await res.json().catch(() => ({
        ok: false
      }));
      alert(data.ok ? 'Ditambahkan ke keranjang' : (data.msg || 'Gagal menambah'));
    }
    refreshCartCount();
  </script>
</body>

</html>