import './bootstrap';

import Alpine from 'alpinejs';
import collapse from '@alpinejs/collapse';
import imageCompression from 'browser-image-compression';

Alpine.plugin(collapse)
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


/**
 * Optimización de fotografías para las salidas vehiculares.
 */
document.addEventListener('DOMContentLoaded', () => {
    const form = document.querySelector(
        'form[data-image-compression="vehicle-departure"]'
    );

    if (!form) return;

    const submitButton = form.querySelector('#departure-submit-button');
    const statusContainer = form.querySelector('#departure-submit-status');
    const statusMessage = form.querySelector('#departure-submit-message');

    let processing = false;

    form.addEventListener('submit', async (event) => {
        if (processing) return;

        const photoInputs = Array.from(
            form.querySelectorAll('.checklist-photo')
        );

        const selectedInputs = photoInputs.filter(
            input => input.files && input.files.length > 0
        );

        if (selectedInputs.length === 0) return;

        event.preventDefault();

        processing = true;

        submitButton.disabled = true;
        submitButton.classList.add('opacity-50', 'cursor-not-allowed');

        statusContainer.classList.remove('hidden');

        try {
            const totalPhotos = selectedInputs.reduce(
                (total, input) => total + input.files.length,
                0
            );

            let processedPhotos = 0;

            for (const input of selectedInputs) {
                const compressedFiles = [];

                for (const originalFile of Array.from(input.files)) {
                    statusMessage.textContent =
                        `Optimizando fotografía ${processedPhotos + 1} de ${totalPhotos}...`;

                    const options = {
                        maxSizeMB: 0.5,
                        maxWidthOrHeight: 1600,
                        useWebWorker: true,
                        initialQuality: 0.82,
                        fileType: 'image/webp'
                    };

                    const compressedFile = await imageCompression(
                        originalFile,
                        options
                    );

                    const finalFile = new File(
                        [compressedFile],
                        originalFile.name.replace(/\.[^/.]+$/, '') + '.webp',
                        {
                            type: 'image/webp',
                            lastModified: Date.now()
                        }
                    );

                    compressedFiles.push(finalFile);
                    processedPhotos++;
                }

                const dataTransfer = new DataTransfer();

                compressedFiles.forEach(file => {
                    dataTransfer.items.add(file);
                });

                input.files = dataTransfer.files;
            }

            statusMessage.textContent =
                'Fotografías optimizadas. Enviando información al servidor...';

            // Enviar el formulario después de optimizar las imágenes.
            form.requestSubmit();

        } catch (error) {
            console.error('Error al optimizar fotografías:', error);

            processing = false;

            submitButton.disabled = false;
            submitButton.classList.remove('opacity-50', 'cursor-not-allowed');

            statusContainer.classList.add('hidden');

            alert(
                'No fue posible optimizar las fotografías. ' +
                'Intenta nuevamente o selecciona otras imágenes.'
            );
        }
    });
});
