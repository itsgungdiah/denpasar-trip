const stepView = document.querySelector('[data-trip-step-view]');
const reducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)');

if (stepView && !reducedMotion.matches && typeof stepView.animate === 'function') {
    stepView.animate(
        [
            { opacity: 0, transform: 'translateY(10px)' },
            { opacity: 1, transform: 'translateY(0)' },
        ],
        { duration: 360, easing: 'cubic-bezier(0.22, 1, 0.36, 1)' },
    );
}

function leaveStep() {
    if (!stepView || reducedMotion.matches || typeof stepView.animate !== 'function') {
        return Promise.resolve();
    }

    const animation = stepView.animate(
        [
            { opacity: 1, transform: 'translateY(0)' },
            { opacity: 0, transform: 'translateY(-8px)' },
        ],
        { duration: 170, easing: 'ease-in', fill: 'forwards' },
    );

    return animation.finished.catch(() => {});
}

document.addEventListener('click', (event) => {
    const link = event.target instanceof Element
        ? event.target.closest('[data-trip-step-link]')
        : null;

    if (!link || !stepView?.contains(link) || reducedMotion.matches || event.defaultPrevented) return;
    if (event.button !== 0 || event.metaKey || event.ctrlKey || event.shiftKey || event.altKey || link.target) return;

    event.preventDefault();
    leaveStep().then(() => window.location.assign(link.href));
});

document.addEventListener('submit', (event) => {
    const form = event.target instanceof HTMLFormElement
        ? event.target.closest('[data-trip-step-form]')
        : null;

    if (!form || !stepView?.contains(form) || form.dataset.tripTransitioning === 'true' || event.defaultPrevented || reducedMotion.matches) return;

    event.preventDefault();
    const submitter = event.submitter;

    leaveStep().then(() => {
        form.dataset.tripTransitioning = 'true';
        if (submitter) form.requestSubmit(submitter);
        else form.requestSubmit();
    });
});
