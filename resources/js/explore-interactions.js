const dropdowns = [...document.querySelectorAll('[data-explore-dropdown]')];

if (dropdowns.length) {
    const closeDropdown = (dropdown, { restoreFocus = false } = {}) => {
        const trigger = dropdown.querySelector('[data-explore-dropdown-trigger]');
        const menu = dropdown.querySelector('[data-explore-dropdown-menu]');
        const chevron = dropdown.querySelector('[data-explore-dropdown-chevron]');

        if (!trigger || !menu || trigger.getAttribute('aria-expanded') !== 'true') return;

        trigger.setAttribute('aria-expanded', 'false');
        menu.setAttribute('aria-hidden', 'true');
        menu.classList.add('invisible', 'pointer-events-none', 'translate-y-1', 'scale-[.98]', 'opacity-0');
        menu.classList.remove('visible', 'pointer-events-auto', 'translate-y-0', 'scale-100', 'opacity-100');
        chevron?.classList.remove('rotate-180');

        window.setTimeout(() => {
            if (trigger.getAttribute('aria-expanded') === 'false') menu.setAttribute('inert', '');
        }, 220);

        if (restoreFocus) trigger.focus();
    };

    const openDropdown = (dropdown, { focusOption = false } = {}) => {
        dropdowns.forEach((other) => {
            if (other !== dropdown) closeDropdown(other);
        });

        const trigger = dropdown.querySelector('[data-explore-dropdown-trigger]');
        const menu = dropdown.querySelector('[data-explore-dropdown-menu]');
        const chevron = dropdown.querySelector('[data-explore-dropdown-chevron]');
        if (!trigger || !menu) return;

        menu.removeAttribute('inert');
        menu.setAttribute('aria-hidden', 'false');
        trigger.setAttribute('aria-expanded', 'true');
        menu.classList.remove('invisible', 'pointer-events-none', 'translate-y-1', 'scale-[.98]', 'opacity-0');
        menu.classList.add('visible', 'pointer-events-auto', 'translate-y-0', 'scale-100', 'opacity-100');
        chevron?.classList.add('rotate-180');

        if (focusOption) {
            const selected = menu.querySelector('[aria-checked="true"]');
            (selected || menu.querySelector('[data-explore-filter-option]'))?.focus();
        }
    };

    dropdowns.forEach((dropdown) => {
        const trigger = dropdown.querySelector('[data-explore-dropdown-trigger]');
        const menu = dropdown.querySelector('[data-explore-dropdown-menu]');
        if (!trigger || !menu) return;

        trigger.addEventListener('click', () => {
            if (trigger.getAttribute('aria-expanded') === 'true') closeDropdown(dropdown);
            else openDropdown(dropdown);
        });

        trigger.addEventListener('keydown', (event) => {
            if (['ArrowDown', 'Enter', ' '].includes(event.key)) {
                event.preventDefault();
                openDropdown(dropdown, { focusOption: true });
            }
        });

        menu.addEventListener('click', (event) => {
            const option = event.target.closest('[data-explore-filter-option]');
            if (!option) return;

            const form = option.closest('form');
            const input = form?.querySelector(`[data-explore-filter-value="${option.dataset.filterName}"]`);
            if (!form || !input) return;

            input.value = option.dataset.filterValue ?? '';
            menu.querySelectorAll('[data-explore-filter-option]').forEach((item) => {
                const selected = item === option;
                item.setAttribute('aria-checked', selected ? 'true' : 'false');
                item.querySelector('svg')?.classList.toggle('opacity-100', selected);
                item.querySelector('svg')?.classList.toggle('opacity-0', !selected);
            });

            const label = dropdown.querySelector('[data-explore-dropdown-label]');
            if (label) label.textContent = option.querySelector('span')?.textContent.trim() ?? '';

            closeDropdown(dropdown);
            form.requestSubmit();
        });

        menu.addEventListener('keydown', (event) => {
            const options = [...menu.querySelectorAll('[data-explore-filter-option]')];
            const currentIndex = options.indexOf(document.activeElement);
            let nextIndex = currentIndex;

            if (event.key === 'Escape') {
                event.preventDefault();
                closeDropdown(dropdown, { restoreFocus: true });
                return;
            }
            if (event.key === 'ArrowDown') nextIndex = (currentIndex + 1) % options.length;
            else if (event.key === 'ArrowUp') nextIndex = (currentIndex - 1 + options.length) % options.length;
            else if (event.key === 'Home') nextIndex = 0;
            else if (event.key === 'End') nextIndex = options.length - 1;
            else return;

            event.preventDefault();
            options[nextIndex]?.focus();
        });
    });

    document.addEventListener('pointerdown', (event) => {
        dropdowns.forEach((dropdown) => {
            if (!dropdown.contains(event.target)) closeDropdown(dropdown);
        });
    });

    document.addEventListener('keydown', (event) => {
        if (event.key === 'Escape') dropdowns.forEach((dropdown) => closeDropdown(dropdown));
    });
}

const revealItems = [...document.querySelectorAll('[data-explore-reveal]')];
const reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

if (revealItems.length && !reduceMotion && 'IntersectionObserver' in window) {
    const observer = new IntersectionObserver((entries, currentObserver) => {
        entries.forEach((entry) => {
            if (!entry.isIntersecting) return;

            const siblings = entry.target.closest('[data-explore-stagger]');
            const staggerIndex = siblings
                ? [...siblings.querySelectorAll('[data-explore-reveal]')].indexOf(entry.target)
                : 0;

            const revealAnimation = entry.target.animate(
                [
                    { opacity: 0, transform: 'translate3d(0, 16px, 0)' },
                    { opacity: 1, transform: 'translate3d(0, 0, 0)' },
                ],
                {
                    duration: 580,
                    delay: Math.max(0, staggerIndex) * 75,
                    easing: 'cubic-bezier(.22, 1, .36, 1)',
                    fill: 'both',
                },
            );
            // Release the WAAPI effect after the entrance so hover transforms
            // and Tailwind transitions remain in control of the element.
            revealAnimation.addEventListener('finish', () => revealAnimation.cancel(), { once: true });
            currentObserver.unobserve(entry.target);
        });
    }, { threshold: 0.12, rootMargin: '0px 0px -32px 0px' });

    revealItems.forEach((item) => observer.observe(item));
}
