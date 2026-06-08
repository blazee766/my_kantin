(function () {
  const rupiah = (value) => 'Rp ' + new Intl.NumberFormat('id-ID').format(Number(value) || 0);

  function flash(message, type = 'success', near = null) {
    if (!message) return;

    const host = document.querySelector('[data-ajax-flash]') || near?.closest('.card, .section, .container, .card-body') || document.body;
    let box = host.querySelector(':scope > .ajax-flash');

    if (!box) {
      box = document.createElement('div');
      box.className = 'ajax-flash';
      host.prepend(box);
    }

    box.className = 'ajax-flash alert ' + (type === 'error' ? 'alert-danger error' : 'alert-success success');
    box.textContent = message;
    window.clearTimeout(box._timer);
    box._timer = window.setTimeout(() => box.remove(), 4500);
  }

  function setBusy(form, busy) {
    form.querySelectorAll('button, input, select, textarea').forEach((el) => {
      if (busy) {
        el.dataset.wasDisabled = el.disabled ? '1' : '0';
        el.disabled = true;
      } else if (el.dataset.wasDisabled !== '1') {
        el.disabled = false;
      }
    });
  }

  function updateCsrf(data) {
    if (!data || !data.csrfTokenName || !data.csrfHash) return;

    document.querySelectorAll(`input[name="${data.csrfTokenName}"]`).forEach((input) => {
      input.value = data.csrfHash;
    });
  }

  function statusHtml(data) {
    const icon = data.statusIcon || 'fas fa-info-circle';
    const label = data.statusLabel || data.status || '';
    return `<i class="${icon}"></i><span class="badge-text"> ${label}</span>`;
  }

  function paymentHtml(data) {
    const icon = data.paymentIcon || 'fas fa-wallet';
    const label = data.paymentLabel || data.paymentStatus || '';
    return `<i class="${icon}"></i><span class="badge-text"> ${label}</span>`;
  }

  function updateStatusBadges(orderId, data) {
    document.querySelectorAll(`[data-order-status-badge][data-order-id="${orderId}"]`).forEach((badge) => {
      const cls = data.statusClass || 'wait';
      if (badge.classList.contains('order-pill')) {
        badge.className = `badge order-pill badge-${cls}`;
      } else {
        badge.className = `badge ${cls}`;
      }
      badge.dataset.status = data.status || '';
      badge.innerHTML = statusHtml(data);
    });
  }

  function updatePaymentBadges(orderId, data) {
    document.querySelectorAll(`[data-order-payment-badge][data-order-id="${orderId}"]`).forEach((badge) => {
      const cls = data.paymentClass || 'wait';
      if (badge.classList.contains('order-pill')) {
        const map = { wait: 'badge-pay-unpaid', done: 'badge-pay-paid', cancel: 'badge-pay-failed' };
        badge.className = `order-pill ${map[cls] || 'badge-pay-unpaid'}`;
      } else {
        badge.className = `badge ${cls}`;
      }
      badge.dataset.paymentStatus = data.paymentStatus || '';
      badge.innerHTML = paymentHtml(data);
    });
  }

  function handleBuyerItem(form, data) {
    const row = form.closest('[data-order-item-row]');
    if (!row) return;

    if (data.rowRemoved) {
      row.remove();
    } else {
      row.querySelector('[data-item-qty]')?.replaceChildren(document.createTextNode(String(data.qty || 0)));
      row.querySelector('[data-item-subtotal]')?.replaceChildren(document.createTextNode(rupiah(data.lineSubtotal)));
    }

    const total = document.querySelector('[data-order-total]');
    if (total && typeof data.totalAmount !== 'undefined') {
      total.textContent = rupiah(data.totalAmount);
    }

    if (window.refreshCartCount) window.refreshCartCount();
  }

  function handleRemovedOrder(data) {
    if (!data.removedOrder) return false;

    const container = document.querySelector('.container, .container-fluid') || document.body;
    container.innerHTML = `
      <div class="section card shadow mb-4" style="padding:24px">
        <div class="alert alert-success">${data.message || 'Data berhasil dihapus.'}</div>
        <a class="btn btn-primary" href="${data.redirect || (window.APP_BASE || '/') + 'p/orders'}">Kembali</a>
      </div>
    `;

    if (window.refreshCartCount) window.refreshCartCount();
    return true;
  }

  function handleSuccess(form, data) {
    if (handleRemovedOrder(data)) return;

    if (form.dataset.ajaxAction === 'remove-order-item') {
      handleBuyerItem(form, data);
    }

    if (form.dataset.ajaxAction === 'remove-row') {
      form.closest('tr')?.remove();
    }

    if (form.dataset.ajaxAction === 'admin-status' && data.orderId) {
      updateStatusBadges(data.orderId, data);
    }

    if (form.dataset.ajaxAction === 'admin-paid' && data.orderId) {
      updatePaymentBadges(data.orderId, data);
      form.remove();
    }

    if (form.dataset.ajaxAction === 'save-menu' && form.dataset.resetOnSuccess === '1') {
      form.reset();
      document.getElementById('imgPreview')?.setAttribute('style', 'display:none');
    }

    if (form.dataset.ajaxAction === 'save-admin-order') {
      form.reset();
      const rows = document.getElementById('itemRows');
      if (rows) rows.innerHTML = '';
      if (typeof window.addRow === 'function') window.addRow();
      const total = document.getElementById('grandTotal');
      if (total) total.textContent = rupiah(0);
    }
  }

  document.addEventListener('submit', async (event) => {
    const form = event.target.closest('form[data-ajax-form]');
    if (!form) return;
    if (event.defaultPrevented) return;

    event.preventDefault();

    const message = form.dataset.confirm;
    if (message && !window.confirm(message)) return;

    setBusy(form, true);

    try {
      const response = await fetch(form.action, {
        method: form.method || 'POST',
        body: new FormData(form),
        credentials: 'same-origin',
        headers: {
          'Accept': 'application/json',
          'X-Requested-With': 'XMLHttpRequest',
        },
      });

      const data = await response.json().catch(() => ({
        ok: false,
        message: 'Server tidak mengirim response JSON.',
      }));
      updateCsrf(data);

      if (!response.ok || data.ok === false) {
        flash(data.message || data.msg || 'Aksi gagal diproses.', 'error', form);
        return;
      }

      handleSuccess(form, data);
      flash(data.message || data.msg || 'Berhasil diperbarui.', 'success', form);
    } catch (error) {
      flash('Koneksi bermasalah. Coba lagi sebentar.', 'error', form);
    } finally {
      setBusy(form, false);
    }
  });

  document.addEventListener('DOMContentLoaded', () => {
    const pollHost = document.querySelector('[data-admin-orders-poll]');
    if (!pollHost) return;

    const url = pollHost.dataset.adminOrdersPoll;
    if (!url) return;

    async function pollOrders() {
      const ids = [...document.querySelectorAll('[data-order-status-badge][data-order-id]')]
        .map((el) => el.dataset.orderId)
        .filter(Boolean);

      if (!ids.length) return;

      try {
        const response = await fetch(url + '?ids=' + encodeURIComponent([...new Set(ids)].join(',')), {
          cache: 'no-store',
          credentials: 'same-origin',
          headers: { 'Accept': 'application/json' },
        });
        const data = await response.json();
        if (!data.ok || !Array.isArray(data.orders)) return;

        data.orders.forEach((order) => {
          updateStatusBadges(order.orderId, order);
          updatePaymentBadges(order.orderId, order);
        });
      } catch (error) {
        // Polling hanya peningkatan UX; halaman tetap bisa dipakai saat gagal.
      }
    }

    pollOrders();
    window.setInterval(pollOrders, 15000);
  });
})();
