/**
 * TV Universo - Admin JavaScript
 * Interacciones del panel de administración
 */

document.addEventListener('DOMContentLoaded', () => {
    initDeleteConfirm();
    initSectionPreview();
    initImagePreview();
});

/** Confirmación antes de eliminar */
function initDeleteConfirm() {
    document.querySelectorAll('.btn-delete, [data-confirm]').forEach(btn => {
        btn.addEventListener('click', (e) => {
            const msg = btn.dataset.confirm || '¿Estás seguro de eliminar este elemento?';
            if (!confirm(msg)) {
                e.preventDefault();
            }
        });
    });
}

/** Preview de sección donde se mostrará el contenido */
function initSectionPreview() {
    const sectionSelect = document.querySelector('[name="section"]');
    const typeSelect = document.querySelector('[name="type"]');
    const preview = document.querySelector('.admin-form__section-preview');

    if (!preview) return;

    function updatePreview() {
        const section = sectionSelect ? sectionSelect.value : '';
        const type = typeSelect ? typeSelect.value : '';

        const labels = {
            home: '🟢 Visible en HOME',
            tendencia: '🟡 Visible en TENDENCIA (Home)',
            top: '🔴 Visible en LO MÁS TOP',
            canal48: '🔵 Visible en CANAL 48',
            toptravel: '🟣 Visible en TOP TRAVEL',
        };

        let text = labels[section] || '📍 Sección: ' + section;
        if (type) {
            text += ' | Marca: ' + (type === 'canal48' ? '📺 Canal 48' : '✈️ Top Travel');
        }
        preview.innerHTML = '👉 ' + text;
    }

    if (sectionSelect) sectionSelect.addEventListener('change', updatePreview);
    if (typeSelect) typeSelect.addEventListener('change', updatePreview);
    updatePreview();
}

/** Preview de imagen por URL */
function initImagePreview() {
    const urlInput = document.querySelector('[name="image_url"], [name="thumbnail"]');
    if (!urlInput) return;

    let previewEl = document.querySelector('.image-preview');
    if (!previewEl) {
        previewEl = document.createElement('div');
        previewEl.className = 'image-preview';
        previewEl.style.cssText = 'margin-top:8px;max-width:300px;border-radius:8px;overflow:hidden;';
        urlInput.parentNode.appendChild(previewEl);
    }

    function updateImagePreview() {
        const url = urlInput.value.trim();
        if (url) {
            previewEl.innerHTML = `<img src="${url}" alt="Preview" style="width:100%;height:auto;" onerror="this.parentNode.innerHTML='<span style=color:#e74c3c;font-size:0.8rem>URL de imagen no válida</span>'">`;
        } else {
            previewEl.innerHTML = '';
        }
    }

    urlInput.addEventListener('input', debounce(updateImagePreview, 500));
    updateImagePreview();
}

/** Debounce utility */
function debounce(fn, delay) {
    let timer;
    return (...args) => {
        clearTimeout(timer);
        timer = setTimeout(() => fn(...args), delay);
    };
}
