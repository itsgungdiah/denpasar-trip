// JavaScript untuk formulir admin destinasi
import './admin/destination-form.js';
import './auth-validation.js';
import './home-interactions.js';
import './explore-details.js';
import './explore-interactions.js';
import './trips.js';
import './trip-step-transition.js';

const modalLayerRoot = document.querySelector('[data-modal-layer-root]');

if (modalLayerRoot) {
    const syncModalLayer = () => {
        const modalOpen = [...modalLayerRoot.querySelectorAll('[data-destination-modal], [data-itinerary-modal]')]
            .some((modal) => !modal.hidden)
            || [...modalLayerRoot.querySelectorAll('[data-trip-saved-modal]')]
                .some((modal) => modal.open);

        modalLayerRoot.classList.toggle('z-[100]', modalOpen);
        modalLayerRoot.classList.toggle('z-10', !modalOpen);
    };

    new MutationObserver(syncModalLayer).observe(modalLayerRoot, {
        attributes: true,
        attributeFilter: ['hidden', 'open'],
        subtree: true,
    });
}
import './trip-date-range.js';
import './navbar.js';
