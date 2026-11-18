const homeBody = document.getElementById('user-home-body');
const prefersReducedMotion = typeof window.matchMedia === 'function'
    && window.matchMedia('(prefers-reduced-motion: reduce)').matches;

if (homeBody && !prefersReducedMotion && 'IntersectionObserver' in window) {
    document.querySelectorAll('[data-home-stagger]').forEach((group) => {
        Array.from(group.children)
            .filter((child) => child.hasAttribute('data-home-reveal'))
            .forEach((child, index) => child.style.setProperty('--home-reveal-delay', `${index * 90}ms`));
    });

    const revealItems = document.querySelectorAll('[data-home-reveal]');

    if (revealItems.length) {
        document.documentElement.classList.add('home-motion-ready');

        const observer = new IntersectionObserver((entries) => {
            entries.forEach((entry) => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('home-visible');
                    observer.unobserve(entry.target);
                }
            });
        }, {
            threshold: 0.12,
            rootMargin: '0px 0px -6% 0px',
        });

        revealItems.forEach((item) => observer.observe(item));
    }
}

const favoriteStorageKey = (userId) => `denpasar-trip:favorites:user:${userId || 'guest'}`;
const readFavorites = (userId) => {
    try {
        const value = JSON.parse(window.localStorage.getItem(favoriteStorageKey(userId)) || '[]');
        return Array.isArray(value) ? value.filter((item) => item && item.id) : [];
    } catch {
        return [];
    }
};

const syncFavoriteButtons = () => {
    document.querySelectorAll('[data-destination-favorite]').forEach((button) => {
        const isFavorite = readFavorites(button.dataset.userId).some((item) => String(item.id) === String(button.dataset.destinationId));
        button.setAttribute('aria-pressed', String(isFavorite));
        button.setAttribute('aria-label', `${isFavorite ? 'Hapus' : 'Tambahkan'} ${button.dataset.name} ${isFavorite ? 'dari' : 'ke'} favorit`);
        button.classList.toggle('text-[#B94C4C]', isFavorite);
        button.classList.toggle('dark:text-[#FF8A8A]', isFavorite);
        const heart = button.querySelector('svg');
        if (heart) {
            heart.setAttribute('fill', isFavorite ? 'currentColor' : 'none');
            heart.setAttribute('stroke-width', isFavorite ? '1.4' : '1.8');
        }
    });
};

const renderProfileFavorites = () => {
    const section = document.querySelector('[data-profile-favorites]');
    if (!section) return;

    const list = section.querySelector('[data-profile-favorites-list]');
    const empty = section.querySelector('[data-profile-favorites-empty]');
    const favorites = readFavorites(section.dataset.userId);
    list.querySelectorAll('[data-profile-favorite-card]').forEach((card) => card.remove());
    if (empty) empty.hidden = favorites.length > 0;

    favorites.forEach((destination) => {
        const card = document.createElement('article');
        card.dataset.profileFavoriteCard = '';
        card.className = 'overflow-hidden rounded-xl border border-[#F1E5D9] bg-white/80 shadow-sm transition hover:-translate-y-0.5 hover:shadow-md dark:border-white/10 dark:bg-[#14211F]/70';

        if (destination.image) {
            const image = document.createElement('img');
            image.src = destination.image;
            image.alt = destination.name || 'Destinasi favorit';
            image.loading = 'lazy';
            image.className = 'h-36 w-full object-cover';
            card.append(image);
        }

        const content = document.createElement('div');
        content.className = 'p-3.5';
        const categories = document.createElement('p');
        categories.className = 'm-0 text-xs font-semibold text-[#46745D] dark:text-[#A9D2B8]';
        categories.textContent = destination.categories || 'Destinasi';
        const title = document.createElement('h3');
        title.className = 'mb-0 mt-1.5 text-base font-bold text-[#142230] dark:text-[#F5F2EB]';
        title.textContent = destination.name || 'Destinasi';
        const description = document.createElement('p');
        description.className = 'mb-0 mt-1.5 line-clamp-2 text-sm leading-relaxed text-[#687078] dark:text-[#C5CBC8]';
        description.textContent = destination.description || '';
        const remove = document.createElement('button');
        remove.type = 'button';
        remove.className = 'mt-3 inline-flex items-center gap-1.5 text-xs font-bold text-[#A53F3F] transition hover:text-[#7F2525] dark:text-[#FF9A9A]';
        remove.dataset.destinationFavoriteRemove = destination.id;
        remove.textContent = 'Hapus dari favorit';
        content.append(categories, title, description, remove);
        card.append(content);
        list.append(card);
    });
};

syncFavoriteButtons();
renderProfileFavorites();

document.addEventListener('click', (event) => {
    const favoriteButton = event.target.closest('[data-destination-favorite]');
    const removeButton = event.target.closest('[data-destination-favorite-remove]');
    if (!favoriteButton && !removeButton) return;

    const section = favoriteButton?.closest('[data-destination-favorites]')
        || document.querySelector('[data-profile-favorites]');
    const userId = favoriteButton?.dataset.userId || section?.dataset.userId;
    const destinationId = favoriteButton?.dataset.destinationId || removeButton?.dataset.destinationFavoriteRemove;
    const favorites = readFavorites(userId);
    const existingIndex = favorites.findIndex((item) => String(item.id) === String(destinationId));

    if (existingIndex >= 0) {
        favorites.splice(existingIndex, 1);
    } else if (favoriteButton) {
        favorites.push({
            id: favoriteButton.dataset.destinationId,
            name: favoriteButton.dataset.name,
            image: favoriteButton.dataset.image,
            categories: favoriteButton.dataset.categories,
            description: favoriteButton.dataset.description,
            detailUrl: favoriteButton.dataset.detailUrl,
        });
    }

    try {
        window.localStorage.setItem(favoriteStorageKey(userId), JSON.stringify(favorites));
    } catch {
        return;
    }

    syncFavoriteButtons();
    renderProfileFavorites();
});
