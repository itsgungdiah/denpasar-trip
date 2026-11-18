document.querySelectorAll('[data-profile-menu]').forEach((menu) => {
    const dropdown = menu.querySelector('[data-profile-dropdown]');
    const summary = menu.querySelector('summary');

    if (!dropdown || !summary) return;

    const syncDropdownState = () => {
        const isOpen = menu.open;
        dropdown.inert = !isOpen;
        dropdown.setAttribute('aria-hidden', String(!isOpen));
    };

    menu.addEventListener('toggle', syncDropdownState);

    document.addEventListener('pointerdown', (event) => {
        if (menu.open && !menu.contains(event.target)) menu.open = false;
    });

    menu.addEventListener('keydown', (event) => {
        if (event.key === 'Escape' && menu.open) {
            menu.open = false;
            summary.focus();
        }
    });
});
