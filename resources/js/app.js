import './bootstrap';

import Alpine from 'alpinejs';
window.Alpine = Alpine;
Alpine.start();

// Atajo de teclado: Ctrl + Enter para agregar un nuevo detalle de servicio
document.addEventListener('keydown', function (e) {

    const active = document.activeElement;
    if (!active) return;

    const inDetalles = active.closest('#detalles-container');
    if (!inDetalles) return;

    // =========================
    // ➕ CREAR NUEVO DETALLE
    // Ctrl + Enter (Win/Linux) / Cmd + Enter (Mac)
    // =========================
    const addShortcut = e.key === 'Enter' && (e.ctrlKey || e.metaKey);

    if (addShortcut) {
        e.preventDefault();

        agregarDetail('servicio');

        setTimeout(() => {
            const last = document.querySelector('#detalles-container textarea:last-of-type');
            if (last) {
                last.focus();
                last.scrollIntoView({
                    behavior: 'smooth',
                    block: 'center'
                });
            }
        }, 50);

        return;
    }
});