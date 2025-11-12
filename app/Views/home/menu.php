<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Menu - KantinKamu</title>
  <link rel="stylesheet" href="<?= base_url('assets/css/style.css'); ?>">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
  <style>
    body{background:#fff6f1;font-family:'Poppins',sans-serif;margin:0}
    header{display:flex;justify-content:space-between;align-items:center;padding:20px 50px;background:#fff6f1}
    nav ul{list-style:none;display:flex;gap:30px;margin:0;padding:0}
    nav a{text-decoration:none;color:#333;font-weight:500}
    nav a.active{color:#ff6a00;border-bottom:2px solid #ff6a00}

    .container{max-width:1200px;margin:20px auto;padding:0 16px}
    h2{text-align:center;margin:10px 0 18px}

    .tabs{display:flex;gap:8px;justify-content:center;flex-wrap:wrap;margin:6px 0 18px}
    .tab{padding:.5rem .9rem;border-radius:999px;background:#fff;border:1px solid #eee;text-decoration:none;color:#333;margin:.2rem;transition:.2s}
    .tab.active,.tab:hover{background:#ff6a00;color:#fff;border-color:#ff6a00}

    .grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(250px,1fr));gap:24px}

    .card{
      background:#fff;border-radius:16px;padding:16px;box-shadow:0 4px 12px rgba(0,0,0,.08);
      text-align:center;display:flex;flex-direction:column
    }

    /* ===== gambar + tombol mengambang ===== */
    .thumb{position:relative;border-radius:12px;overflow:hidden}
    .thumb img{width:100%;height:200px;object-fit:cover;display:block}
    .fab{
      position:absolute;right:12px;bottom:12px;width:44px;height:44px;border-radius:50%;
      background:#ff6a00;color:#fff;border:none;display:flex;align-items:center;justify-content:center;
      font-size:1.1rem;cursor:pointer;box-shadow:0 6px 14px rgba(0,0,0,.18);transition:.2s;z-index:2
    }
    .fab:hover{background:#e55b00}
    .fab:disabled{background:rgba(0,0,0,.35);cursor:not-allowed}

    /* kecilkan icon X saat habis */
    .fab i{pointer-events:none}

    .card-body{flex:1 1 auto}
    .card h3{margin:12px 0 6px}
    .card p.desc{
      color:#777;font-size:.9rem;line-height:1.35;
      display:-webkit-box;-webkit-line-clamp:2;line-clamp:2;-webkit-box-orient:vertical;overflow:hidden;min-height:38px
    }
    .price{display:block;color:#ff6a00;font-weight:700;margin-top:8px}

    .stock{margin-top:8px;font-size:.85rem;color:#666}
    .stock.out{color:#c0392b}

    .skeleton{background:#f1f1f1;height:260px;border-radius:16px;animation:pulse 1.2s infinite}
    @keyframes pulse{0%{opacity:.6}50%{opacity:1}100%{opacity:.6}}
  </style>
</head>

<body>

  <header>
    <div class="logo"><i class="fas fa-utensils"></i> KantinKamu</div>
    <nav>
      <ul>
        <li><a href="<?= site_url('/'); ?>">Home</a></li>
        <li><a href="<?= site_url('menu'); ?>" class="active">Menu</a></li>
        <li><a href="#">Contact</a></li>
        <li><a href="#">About Us</a></li>
        <li><a href="#">Gallery</a></li>
      </ul>
    </nav>
  </header>

  <div class="container">
    <h2>Daftar Menu Lengkap</h2>

    <!-- Tabs -->
    <div class="tabs" id="tabs">
      <a href="#" data-slug="" class="tab">Semua</a>
      <?php foreach ($categories as $c): ?>
        <a href="#" data-slug="<?= esc($c['slug']); ?>" class="tab"><?= esc($c['name']); ?></a>
      <?php endforeach; ?>
    </div>

    <!-- Grid menu -->
    <div id="menuGrid" class="grid" aria-live="polite"></div>
  </div>

  <script>
    (function() {
      const grid = document.getElementById('menuGrid');
      const tabs = Array.from(document.querySelectorAll('#tabs .tab'));

      const app = {
        api: '<?= rtrim(site_url(),  '/'); ?>',
        asset: '<?= rtrim(base_url(), '/'); ?>'
      };
      const prettyBase = '<?= rtrim(base_url(), '/'); ?>';
      const activeInitial = '<?= esc($activeSlug ?? ''); ?>';

      function setActive(slug){ tabs.forEach(a=>a.classList.toggle('active', a.dataset.slug===slug)); }
      function money(x){ return new Intl.NumberFormat('id-ID').format(x); }

      // ====== kartu dengan tombol di atas gambar ======
      function cardTemplate(m){
        const img = m.image ? `${app.asset}/assets/img/${m.image}` : `${app.asset}/assets/img/placeholder.png`;
        const disabled = !(m.stock > 0);

        return `
          <div class="card">
            <div class="thumb">
              <img src="${img}" alt="${m.name}">
              ${disabled
                ? `<button class="fab" disabled title="Habis"><i class="fas fa-times"></i></button>`
                : `<button class="fab add-to-cart" data-id="${m.id}" title="Tambah ke keranjang"><i class="fas fa-plus"></i></button>`
              }
            </div>

            <div class="card-body">
              <h3>${m.name}</h3>
              <p class="desc">${m.description || ''}</p>
              <span class="price">Rp ${money(m.price)}</span>
              <div class="stock ${disabled ? 'out':''}">${disabled ? 'Habis' : 'Stok: '+m.stock}</div>
            </div>
          </div>
        `;
      }

      function showSkeleton(n=8){ grid.innerHTML = Array.from({length:n}).map(()=>`<div class="skeleton"></div>`).join(''); }

      async function loadMenus(slug=''){
        setActive(slug);
        showSkeleton();
        const url = slug ? `${app.api}/menu/json?cat=${encodeURIComponent(slug)}` : `${app.api}/menu/json`;
        const res = await fetch(url);
        const js = await res.json();
        const rows = js.data || [];
        grid.innerHTML = rows.map(cardTemplate).join('') || '<p style="text-align:center;color:#777">Belum ada menu.</p>';
        bindAddButtons();
      }

      function bindAddButtons(){
        document.querySelectorAll('.add-to-cart').forEach(btn=>{
          btn.addEventListener('click', async ()=>{
            const payload = new URLSearchParams();
            payload.append('id', btn.dataset.id);
            payload.append('qty', '1');

            const res = await fetch(`${app.api}/cart/add`, {
              method: 'POST',
              headers: {'Content-Type':'application/x-www-form-urlencoded'},
              body: payload.toString()
            });

            if (res.status === 401) {
              const go = confirm('Anda harus login terlebih dahulu untuk memesan. Buka halaman login sekarang?');
              if (go) window.location.href = '<?= site_url('login'); ?>';
              return;
            }

            const data = await res.json().catch(()=>({ok:false}));
            if (data.ok) {
              alert('✅ Item ditambahkan ke keranjang!');
              if (data.redirect) window.location.href = data.redirect;
            } else {
              alert(data.msg || 'Gagal menambahkan item.');
            }
          });
        });
      }

      // klik tab
      tabs.forEach(a=>{
        a.addEventListener('click', e=>{
          e.preventDefault();
          const slug = a.dataset.slug || '';
          loadMenus(slug);
          history.replaceState(null, '', slug ? `${prettyBase}/menu?cat=${slug}` : `${prettyBase}/menu`);
        });
      });

      // initial load
      loadMenus(activeInitial);
    })();
  </script>
</body>
</html>
