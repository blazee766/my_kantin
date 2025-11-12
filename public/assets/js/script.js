// ====== Mobile nav toggle ======
(function () {
  const btn = document.getElementById('hamburger');
  const nav = document.getElementById('nav');
  if (btn && nav) {
    btn.addEventListener('click', () => {
      const show = getComputedStyle(nav).display === 'none';
      nav.style.display = show ? 'block' : 'none';
    });
  }
})();

// ====== Hero image swap ketika hover kartu menu ======
(function () {
  const heroImg = document.getElementById('heroImage');
  if (!heroImg) return;
  document.querySelectorAll('.dish').forEach(card => {
    const img = card.getAttribute('data-img');
    if (!img) return;
    card.addEventListener('mouseenter', () => {
      heroImg.dataset.prev = heroImg.src;
      heroImg.src = (window.ASSETS_BASE || '') + 'assets/img/' + img;
    });
    card.addEventListener('mouseleave', () => {
      if (heroImg.dataset.prev) heroImg.src = heroImg.dataset.prev;
    });
  });
})();

// ====== Search UX (kosmetik, tidak sentuh backend) ======
(function () {
  const input = document.getElementById('qsearch');
  if (!input) return;
  input.addEventListener('input', () => {
    const q = input.value.toLowerCase().trim();
    document.querySelectorAll('.dish').forEach(d => {
      const t = (d.querySelector('h3')?.textContent || '').toLowerCase();
      d.style.display = t.includes(q) ? '' : 'none';
    });
  });
})();

// ====== Badge jumlah keranjang ======
async function refreshCartCount() {
  try {
    // gunakan base url dari inline script (lihat “tambahan kecil di HTML”)
    const base = window.APP_BASE || '/';
    const res = await fetch(base + 'cart/count', { credentials: 'same-origin' });
    if (!res.ok) return; // diam saja jika endpoint tidak ada
    const data = await res.json();
    const el = document.querySelector('.cart-count');
    if (el && typeof data.count !== 'undefined') {
      el.textContent = data.count;
      el.style.display = Number(data.count) > 0 ? 'block' : 'none';
    }
  } catch (e) {
    // diam: tidak ganggu halaman jika API tidak tersedia
  }
  // ====== Search (AJAX ke /menu/search) ======
(function () {
  const input = document.getElementById('qsearch');
  const list = document.querySelector('.dishes');
  if (!input || !list) return;

  // debounce helper
  const debounce = (fn, d=300) => {
    let t; return (...a) => { clearTimeout(t); t = setTimeout(() => fn(...a), d); };
  };

  const rupiah = (n) => new Intl.NumberFormat('id-ID').format(n);

  function render(items) {
    list.innerHTML = items.map(m => `
      <div class="dish" data-img="${m.image}">
        <img src="${(window.ASSETS_BASE||'')}assets/img/${m.image}" alt="${m.name}">
        <h3>${m.name}</h3>
        <p>${m.desc ?? ''}</p>
        <span class="price">Rp ${rupiah(m.price)}</span>
        <button class="add-to-cart"
          data-id="${m.id}"
          data-name="${m.name}"
          data-price="${m.price}">
          <i class="fas fa-plus"></i>
        </button>
      </div>
    `).join('');

    // rebind add-to-cart (tetap pakai endpoint lama kamu)
    list.querySelectorAll('.add-to-cart').forEach(btn => {
      btn.addEventListener('click', async () => {
        const payload = new URLSearchParams();
        payload.append('id', btn.dataset.id);
        payload.append('qty', '1');
        const res = await fetch((window.APP_BASE||'/')+'cart/add', {
          method: 'POST',
          headers: {'Content-Type': 'application/x-www-form-urlencoded'},
          body: payload.toString()
        });
        const data = await res.json().catch(() => ({ok:false}));
        if (data.ok) {
          const countEl = document.querySelector('.cart-count');
          if (countEl) countEl.textContent = parseInt(countEl.textContent || '0') + 1;
          alert('✅ Ditambahkan ke keranjang: ' + btn.dataset.name);
        } else {
          alert(data.msg || 'Gagal menambah.');
          if (typeof refreshCartCount === 'function') refreshCartCount();
        }
      });
    });
  }

  async function doSearch(q) {
    try {
      const url = (window.APP_BASE || '/') + 'menu/search?q=' + encodeURIComponent(q || '');
      const res = await fetch(url, {credentials:'same-origin'});
      const data = await res.json();
      if (data && data.ok) render(data.items);
    } catch(e) { /* diam */ }
  }

  // initial: tampilkan default list
  doSearch('');

  input.addEventListener('input', debounce(() => doSearch(input.value.trim()), 350));
})();

}

// panggil sekali saat load
refreshCartCount();
