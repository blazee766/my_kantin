(function () {
  const rupiah = (value) => 'Rp ' + new Intl.NumberFormat('id-ID').format(Number(value) || 0);

  function ensureToastStyles() {
    if (document.getElementById('app-toast-styles')) return;

    const style = document.createElement('style');
    style.id = 'app-toast-styles';
    style.textContent = `
      .app-toast-host {
        position: fixed;
        top: 92px;
        left: 50%;
        z-index: 99999;
        display: grid;
        gap: 10px;
        width: min(360px, calc(100vw - 28px));
        transform: translateX(-50%);
        pointer-events: none;
      }

      .app-toast {
        display: flex;
        align-items: flex-start;
        gap: 12px;
        padding: 14px 16px;
        border-radius: 16px;
        background: #ffffff;
        color: #172033;
        border: 1px solid #e5e7eb;
        box-shadow: 0 22px 54px rgba(15, 23, 42, 0.16);
        font: 700 0.92rem/1.45 Poppins, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
        pointer-events: auto;
        overflow-wrap: anywhere;
        animation: appToastIn 0.24s ease both;
      }

      .app-toast::before {
        content: "";
        flex: 0 0 10px;
        width: 10px;
        height: 10px;
        margin-top: 5px;
        border-radius: 999px;
        background: #ff4766;
        box-shadow: 0 0 0 5px rgba(255, 71, 102, 0.13);
      }

      .app-toast.success::before {
        background: #10b981;
        box-shadow: 0 0 0 5px rgba(16, 185, 129, 0.14);
      }

      .app-toast.warning::before {
        background: #f59e0b;
        box-shadow: 0 0 0 5px rgba(245, 158, 11, 0.16);
      }

      .app-toast.is-hiding {
        animation: appToastOut 0.24s ease both;
      }

      @keyframes appToastIn {
        from { opacity: 0; transform: translateY(-8px) scale(0.98); }
        to { opacity: 1; transform: translateY(0) scale(1); }
      }

      @keyframes appToastOut {
        from { opacity: 1; transform: translateY(0) scale(1); }
        to { opacity: 0; transform: translateY(-8px) scale(0.98); }
      }

      @media (max-width: 575.98px) {
        .app-toast-host {
          top: 76px;
          width: min(360px, calc(100vw - 20px));
        }
      }
    `;
    document.head.appendChild(style);
  }

  function ensureToastHost() {
    ensureToastStyles();

    let host = document.querySelector('.app-toast-host');
    if (!host) {
      host = document.createElement('div');
      host.className = 'app-toast-host';
      host.setAttribute('aria-live', 'polite');
      host.setAttribute('aria-atomic', 'true');
      document.body.appendChild(host);
    }

    return host;
  }

  function showToast(message, type = 'success', timeout = 3600) {
    if (!message) return null;

    const toast = document.createElement('div');
    toast.className = 'app-toast ' + type;
    toast.textContent = message;
    ensureToastHost().appendChild(toast);

    window.setTimeout(() => {
      toast.classList.add('is-hiding');
      window.setTimeout(() => toast.remove(), 260);
    }, timeout);

    return toast;
  }

  window.showToast = showToast;
  window.alert = function (message) {
    const text = String(message || '');
    const isError = /gagal|maaf|error|salah|tidak|harus|kosong|kurang|kesalahan/i.test(text);
    showToast(text, isError ? 'error' : 'success');
  };

  function alertTypeFromElement(el) {
    if (el.classList.contains('alert-success') || el.classList.contains('auth-alert-success') || el.classList.contains('success')) {
      return 'success';
    }

    if (el.classList.contains('alert-warning') || el.classList.contains('warning')) {
      return 'warning';
    }

    return 'error';
  }

  function flash(message, type = 'success', near = null) {
    if (!message) return;
    showToast(message, type === 'error' ? 'error' : 'success');
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

  function formDataWithSubmitter(form, submitter) {
    const data = new FormData(form);

    if (submitter?.name) {
      data.set(submitter.name, submitter.value);
    }

    return data;
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
        <a class="btn btn-primary" href="${data.redirect || (window.APP_BASE || '/') + 'p/orders'}">Kembali</a>
      </div>
    `;

    showToast(data.message || 'Data berhasil dihapus.', 'success');

    if (window.refreshCartCount) window.refreshCartCount();
    return true;
  }

  function handleSuccess(form, data) {
    if (handleRemovedOrder(data)) return false;

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

    return true;
  }

  document.addEventListener('submit', async (event) => {
    const form = event.target.closest('form[data-ajax-form]');
    if (!form) return;
    if (event.defaultPrevented) return;

    event.preventDefault();

    const submitter = event.submitter;
    const message = form.dataset.confirm;
    if (message && !window.confirm(message)) return;

    const formData = formDataWithSubmitter(form, submitter);
    setBusy(form, true);

    try {
      const response = await fetch(form.action, {
        method: form.method || 'POST',
        body: formData,
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

      if (handleSuccess(form, data) !== false) {
        flash(data.message || data.msg || 'Berhasil diperbarui.', 'success', form);
      }
    } catch (error) {
      flash('Koneksi bermasalah. Coba lagi sebentar.', 'error', form);
    } finally {
      setBusy(form, false);
    }
  });

  document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('.alert, .auth-alert, .flash').forEach((alert) => {
      const message = alert.textContent.trim();
      if (!message || alert.closest('.register-success-overlay')) return;

      showToast(message, alertTypeFromElement(alert));
      alert.remove();
    });

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
