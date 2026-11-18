document.addEventListener('click', (event) => {
    const filterOption = event.target.closest('[data-sort-option], [data-rating-option]');
    if (filterOption) {
        const isRating = filterOption.hasAttribute('data-rating-option');
        const wrapper = filterOption.closest(isRating ? '[data-rating-menu]' : '[data-sort-menu]');
        const form = filterOption.closest('form');
        const value = wrapper?.querySelector(isRating ? '[data-rating-value]' : '[data-sort-value]');
        const details = wrapper?.querySelector('details');
        if (form && value) {
            value.value = isRating ? filterOption.dataset.ratingOption : filterOption.dataset.sortOption;
            if (details) details.open = false;
            form.requestSubmit();
        }
        return;
    }

    const moveUp = event.target.closest('[data-move-up]');
    const moveDown = event.target.closest('[data-move-down]');
    const control = moveUp || moveDown;
    if (!control) return;

    const item = control.closest('[data-itinerary-id]');
    const list = item?.parentElement;
    if (!item || !list) return;

    if (moveUp && item.previousElementSibling) list.insertBefore(item, item.previousElementSibling);
    if (moveDown && item.nextElementSibling) list.insertBefore(item.nextElementSibling, item);
    list.querySelectorAll('[data-move-up]').forEach((button, index) => { button.disabled = index === 0; });
    list.querySelectorAll('[data-move-down]').forEach((button, index, buttons) => { button.disabled = index === buttons.length - 1; });
});

document.addEventListener('submit', (event) => {
    const form = event.target.closest('[data-sortable-day-form]');
    if (!form) return;

    const list = form.parentElement.querySelector('[data-sortable-day]');
    if (!list) return;
    form.querySelectorAll('[name="itinerary_ids[]"]').forEach((input) => input.remove());
    list.querySelectorAll('[data-itinerary-id]').forEach((item) => {
        const input = document.createElement('input');
        input.type = 'hidden';
        input.name = 'itinerary_ids[]';
        input.value = item.dataset.itineraryId;
        form.append(input);
    });
});

const itineraryModal = document.querySelector('[data-itinerary-modal]');
const destinationModal = document.querySelector('[data-destination-modal]');

if (itineraryModal) {
    const form = itineraryModal.querySelector('[data-itinerary-form]');
    const dialog = itineraryModal.querySelector('[role="dialog"]');
    const dateField = form.querySelector('[data-visit-date]');
    const startField = form.querySelector('[data-visit-start]');
    const durationField = form.querySelector('[data-visit-duration]');
    const durationValue = form.querySelector('[data-visit-duration-value]');
    const endLabel = form.querySelector('[data-visit-end-label]');
    const manualToggle = form.querySelector('[data-manual-end-toggle]');
    const manualField = form.querySelector('[data-manual-end-field]');
    const manualEnd = form.querySelector('[data-visit-manual-end]');
    const warning = form.querySelector('[data-schedule-warning]');
    const error = form.querySelector('[data-visit-error]');
    const scheduleNode = document.querySelector('#trip-itinerary-schedule');
    const schedules = scheduleNode ? JSON.parse(scheduleNode.textContent || '[]') : [];
    const storeUrl = form.action;
    const csrf = form.querySelector('[name="_token"]')?.value;
    let previousFocus = null;
    let previousOverflow = '';
    let currentDestination = null;
    let scheduleConflict = false;
    let saving = false;

    const parseMinutes = (value) => {
        if (!/^\d{2}:\d{2}$/.test(value || '')) return null;
        const [hours, minutes] = value.split(':').map(Number);
        return hours * 60 + minutes;
    };

    const formatTime = (minutes) => `${String(Math.floor(minutes / 60)).padStart(2, '0')}:${String(minutes % 60).padStart(2, '0')}`;

    const showMessage = (element, message = '') => {
        element.textContent = message;
        element.hidden = !message;
        element.classList.toggle('hidden', !message);
    };

    const selectedDuration = () => {
        if (manualToggle.checked) {
            const start = parseMinutes(startField.value);
            const end = parseMinutes(manualEnd.value);
            return start === null || end === null || end <= start ? null : end - start;
        }
        return Number(durationField.value) || null;
    };

    const updateScheduleFeedback = () => {
        showMessage(error);
        showMessage(warning);
        scheduleConflict = false;
        const start = parseMinutes(startField.value);
        const duration = selectedDuration();
        if (start === null || duration === null) {
            endLabel.textContent = '—';
            durationValue.value = '';
            return;
        }
        const end = start + duration;
        endLabel.textContent = end < 1440 ? formatTime(end) : 'Melewati tengah malam';
        durationValue.value = String(duration);
        if (end >= 1440) {
            showMessage(error, 'Jam selesai tidak boleh melewati tengah malam.');
            return;
        }

        const date = dateField.value;
        const currentId = form.dataset.itineraryId;
        const conflict = schedules.some((visit) => {
            if (visit.date !== date || String(visit.id) === String(currentId) || !visit.start || !visit.duration) return false;
            const otherStart = parseMinutes(visit.start);
            if (otherStart === null) return false;
            const otherEnd = otherStart + Number(visit.duration);
            return start < otherEnd && end > otherStart;
        });
        if (conflict) {
            scheduleConflict = true;
            showMessage(warning, 'Jadwal ini bertumpang tindih dengan destinasi lain. Sesuaikan waktunya sebelum menyimpan. Jadwal lain tidak diubah otomatis.');
        }
    };

    const setDestinationSummary = (source) => {
        form.querySelector('[data-visit-destination]').value = source.dataset.destinationId || '';
        itineraryModal.querySelector('[data-visit-name]').textContent = source.dataset.destinationName || 'Destinasi';
        itineraryModal.querySelector('[data-visit-description]').textContent = source.dataset.destinationDescription || '';
        const image = itineraryModal.querySelector('[data-visit-image]');
        if (source.dataset.destinationImage) {
            image.src = source.dataset.destinationImage;
            image.hidden = false;
        } else {
            image.removeAttribute('src');
            image.hidden = true;
        }
        const categories = (source.dataset.destinationCategories || '').split(',').map((name) => name.trim()).filter(Boolean);
        itineraryModal.querySelector('[data-visit-categories]').replaceChildren(...categories.map((name) => {
            const badge = document.createElement('span');
            badge.className = 'rounded-full bg-[#E8F0EB] px-2 py-0.5 text-[9px] font-bold text-[#123B35] dark:bg-[#203D35] dark:text-[#9AC7B8]';
            badge.textContent = name;
            return badge;
        }));
    };

    const resetVisit = () => {
        form.reset();
        form.action = storeUrl;
        form.dataset.itineraryId = '';
        form.querySelector('[name="_method"]')?.remove();
        form.querySelector('[data-visit-destination]').value = currentDestination?.dataset.destinationId || '';
        form.querySelector('[data-visit-sort-order]').value = '1';
        if (dateField.options.length) dateField.selectedIndex = 0;
        durationField.value = '120';
        manualEnd.value = '';
        manualToggle.checked = false;
        manualField.hidden = true;
        updateScheduleFeedback();
    };

    const openVisit = (source, itinerary = null) => {
        currentDestination = source;
        setDestinationSummary(source);
        resetVisit();
        if (itinerary) {
            form.dataset.itineraryId = itinerary.dataset.itineraryId || '';
            form.action = itinerary.dataset.itineraryUrl;
            const method = document.createElement('input');
            method.type = 'hidden';
            method.name = '_method';
            method.value = 'PUT';
            form.append(method);
            dateField.value = itinerary.dataset.date;
            startField.value = itinerary.dataset.startTime || '08:00';
            form.querySelector('[data-visit-sort-order]').value = itinerary.dataset.sortOrder || '1';
            form.querySelector('[data-visit-note]').value = itinerary.dataset.note || '';
            const savedDuration = Number(itinerary.dataset.duration) || 120;
            if (![...durationField.options].some((option) => Number(option.value) === savedDuration)) {
                const option = document.createElement('option');
                option.value = String(savedDuration);
                option.textContent = `${savedDuration} menit`;
                durationField.append(option);
            }
            durationField.value = String(savedDuration);
        }
        manualToggle.checked = false;
        manualField.hidden = true;
        updateScheduleFeedback();
        previousFocus = document.activeElement;
        previousOverflow = document.body.style.overflow;
        document.body.style.overflow = 'hidden';
        itineraryModal.removeAttribute('hidden');
        itineraryModal.hidden = false;
        itineraryModal.classList.remove('hidden');
        dialog.focus();
    };

    const closeVisit = () => {
        if (itineraryModal.hidden) return;
        itineraryModal.hidden = true;
        itineraryModal.setAttribute('hidden', '');
        itineraryModal.classList.add('hidden');
        document.body.style.overflow = previousOverflow;
        previousFocus?.focus();
    };

    document.addEventListener('click', (event) => {
        const detailCard = event.target.closest('[data-destination-detail]');
        if (detailCard) currentDestination = detailCard;

        const editButton = event.target.closest('[data-itinerary-edit]');
        if (editButton) {
            event.preventDefault();
            openVisit(editButton, editButton.closest('[data-itinerary-id]'));
            return;
        }

        const detailAddButton = event.target.closest('[data-trip-detail-add]');
        if (detailAddButton) {
            const destination = detailAddButton.dataset.destinationId ? detailAddButton : (destinationModal?.dataset.destinationId ? destinationModal : currentDestination);
            if (destinationModal) {
                destinationModal.hidden = true;
                document.body.style.overflow = '';
            }
            if (destination?.dataset.destinationId) openVisit(destination);
            return;
        }
        if (event.target.closest('[data-trip-detail-cancel]')) {
            destinationModal?.querySelector('[data-modal-close]')?.click();
            return;
        }
        if (event.target.closest('[data-itinerary-close], [data-itinerary-cancel], [data-itinerary-overlay]')) closeVisit();
    }, true);

    const detailContent = destinationModal?.querySelector('[data-destination-detail-content]');
    const detailActions = destinationModal?.querySelector('[data-trip-detail-actions]');
    if (detailContent && detailActions) {
        const observer = new MutationObserver(() => {
            const loaded = Boolean(detailContent.querySelector('#destination-modal-title'));
            detailActions.classList.toggle('hidden', !loaded);
            detailActions.classList.toggle('flex', loaded);
        });
        observer.observe(detailContent, { childList: true, subtree: true });
    }

    [dateField, startField, durationField, manualEnd].forEach((field) => field.addEventListener('input', updateScheduleFeedback));
    [dateField, durationField, manualToggle].forEach((field) => field.addEventListener('change', updateScheduleFeedback));
    manualToggle.addEventListener('change', () => {
        manualField.hidden = !manualToggle.checked;
        if (manualToggle.checked && startField.value) {
            const defaultEnd = (parseMinutes(startField.value) ?? 480) + (Number(durationField.value) || 120);
            if (defaultEnd < 1440) manualEnd.value = formatTime(defaultEnd);
        }
        updateScheduleFeedback();
        if (manualToggle.checked) manualEnd.focus();
    });

    form.addEventListener('submit', async (event) => {
        event.preventDefault();
        if (saving) return;

        updateScheduleFeedback();
        if (!durationValue.value || (parseMinutes(startField.value) + Number(durationValue.value)) >= 1440 || scheduleConflict) {
            showMessage(error, error.textContent || 'Periksa jam selesai dan durasi kunjungan.');
            if (scheduleConflict) showMessage(error, 'Jadwal bertumpang tindih. Ubah waktu mulai atau durasi sebelum menyimpan.');
            return;
        }

        saving = true;
        const saveButton = form.querySelector('[data-itinerary-save]');
        const originalLabel = saveButton.textContent;
        saveButton.disabled = true;
        saveButton.textContent = 'Menyimpan…';
        showMessage(error);

        try {
            const response = await fetch(form.action, {
                method: 'POST',
                headers: {
                    Accept: 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                },
                body: new FormData(form),
                credentials: 'same-origin',
            });
            const payload = await response.json();

            if (!response.ok) {
                const firstError = Object.values(payload.errors || {}).flat()[0];
                showMessage(error, firstError || payload.message || 'Destinasi gagal disimpan. Periksa kembali data yang dimasukkan.');
                return;
            }

            closeVisit();
            window.location.reload();
        } catch {
            showMessage(error, 'Terjadi kendala saat menyimpan. Periksa koneksi lalu coba kembali.');
        } finally {
            saving = false;
            saveButton.disabled = false;
            saveButton.textContent = originalLabel;
        }
    });

    document.addEventListener('keydown', (event) => {
        if (!itineraryModal.hidden && event.key === 'Escape') closeVisit();
        if (event.key === 'Enter' || event.key === ' ') {
            const card = event.target.closest('[data-destination-detail][role="button"]');
            if (card) { event.preventDefault(); card.click(); }
        }
    });
}

document.addEventListener('click', (event) => {
    const opener = event.target.closest('[data-trip-open]');
    if (opener) {
        const modal = document.querySelector(`[data-trip-detail-modal="${CSS.escape(opener.dataset.tripOpen)}"]`);
        if (modal?.showModal) {
            event.preventDefault();
            modal.showModal();
        }
        return;
    }

    const close = event.target.closest('[data-trip-modal-close]');
    if (close) {
        close.closest('[data-trip-detail-modal]')?.close();
    }
});

document.addEventListener('click', (event) => {
    const dialog = event.target.closest('[data-trip-detail-modal]');
    if (dialog && event.target === dialog) dialog.close();
});

document.addEventListener('submit', (event) => {
    const form = event.target.closest('[data-trip-delete-form]');
    if (form && !window.confirm('Hapus trip ini beserta seluruh itinerary di dalamnya? Tindakan ini tidak dapat dibatalkan.')) {
        event.preventDefault();
    }
});

let draggedTripItem = null;

document.addEventListener('dragstart', (event) => {
    const item = event.target.closest('[data-trip-sort-item]');
    if (!item) return;
    draggedTripItem = item;
    item.classList.add('opacity-50');
    event.dataTransfer.effectAllowed = 'move';
    event.dataTransfer.setData('text/plain', item.dataset.itineraryId || '');
});

document.addEventListener('dragend', () => {
    draggedTripItem?.classList.remove('opacity-50');
    draggedTripItem = null;
});

document.addEventListener('dragover', (event) => {
    const target = event.target.closest('[data-trip-sort-item]');
    if (!draggedTripItem || !target || target === draggedTripItem || target.parentElement !== draggedTripItem.parentElement) return;
    event.preventDefault();
    const bounds = target.getBoundingClientRect();
    const insertAfter = event.clientY > bounds.top + bounds.height / 2;
    target.parentElement.insertBefore(draggedTripItem, insertAfter ? target.nextElementSibling : target);
});

document.addEventListener('drop', async (event) => {
    const list = event.target.closest('[data-trip-sort-list]');
    if (!draggedTripItem || !list || list !== draggedTripItem.parentElement) return;
    event.preventDefault();
    const form = list.closest('[data-trip-reorder-form]');
    const status = form?.querySelector('[data-trip-reorder-status]');
    if (!form || !status) return;

    const payload = new FormData(form);
    list.querySelectorAll('[data-trip-sort-item]').forEach((item) => payload.append('itinerary_ids[]', item.dataset.itineraryId));
    status.textContent = 'Menyimpan urutan…';
    status.classList.remove('hidden');
    try {
        const response = await fetch(form.action, {
            method: 'POST',
            headers: { Accept: 'text/html', 'X-Requested-With': 'XMLHttpRequest' },
            body: payload,
            credentials: 'same-origin',
        });
        if (!response.ok) throw new Error('Urutan gagal disimpan. Muat ulang halaman untuk memeriksa data.');
        status.textContent = 'Urutan destinasi berhasil disimpan.';
    } catch (error) {
        status.textContent = error.message || 'Urutan gagal disimpan. Coba kembali.';
    }
});
