const detailModal = document.querySelector('[data-destination-modal]');

if (detailModal) {
    const dialog = detailModal.querySelector('[role="dialog"]');
    const detailContent = detailModal.querySelector('[data-destination-detail-content]');
    const closeButton = detailModal.querySelector('[data-modal-close]');
    const overlay = detailModal.querySelector('[data-modal-overlay]');
    let previousFocus = null;
    let requestController = null;
    let reviewRequestController = null;
    let previousBodyOverflow = '';
    const reviewEditorOrigins = new WeakMap();

    const closeModal = () => {
        if (detailModal.hidden) return;

        requestController?.abort();
        requestController = null;
        reviewRequestController?.abort();
        reviewRequestController = null;
        if (detailModal.dataset.closing === 'true') return;

        detailModal.dataset.closing = 'true';
        const reducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
        const animations = reducedMotion ? [] : [
            dialog.animate(
                [{ opacity: 1, transform: 'translateY(0) scale(1)' }, { opacity: 0, transform: 'translateY(8px) scale(.985)' }],
                { duration: 160, easing: 'cubic-bezier(.4, 0, 1, 1)' },
            ),
            overlay.animate([{ opacity: 1 }, { opacity: 0 }], { duration: 160, easing: 'ease-in' }),
        ];

        Promise.all(animations.map((animation) => animation.finished.catch(() => {}))).then(() => {
            if (detailModal.dataset.closing !== 'true') return;

            delete detailModal.dataset.closing;
            detailModal.hidden = true;
            dialog.removeAttribute('aria-labelledby');
            document.body.style.overflow = previousBodyOverflow;
            previousFocus?.focus();
            previousFocus = null;
        });
    };

    const openModal = async (trigger) => {
        requestController?.abort();
        reviewRequestController?.abort();
        reviewRequestController = null;
        ['destinationId', 'destinationName', 'destinationImage', 'destinationCategories', 'destinationDescription'].forEach((key) => {
            detailModal.dataset[key] = trigger.dataset[key] || '';
        });
        const addToItineraryButton = detailModal.querySelector('[data-trip-detail-add]');
        ['destinationId', 'destinationName', 'destinationImage', 'destinationCategories', 'destinationDescription'].forEach((key) => {
            if (addToItineraryButton) addToItineraryButton.dataset[key] = trigger.dataset[key] || '';
        });
        requestController = new AbortController();
        previousFocus = trigger;
        previousBodyOverflow = document.body.style.overflow;
        document.body.style.overflow = 'hidden';
        detailModal.hidden = false;
        delete detailModal.dataset.closing;
        [detailModal, dialog, overlay].forEach((element) => element.getAnimations().forEach((animation) => animation.cancel()));
        if (!window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
            dialog.animate(
                [{ opacity: 0, transform: 'translateY(10px) scale(.985)' }, { opacity: 1, transform: 'translateY(0) scale(1)' }],
                { duration: 220, easing: 'cubic-bezier(.2, .8, .2, 1)' },
            );
            overlay.animate([{ opacity: 0 }, { opacity: 1 }], { duration: 220, easing: 'ease-out' });
        }
        dialog.setAttribute('aria-label', 'Detail destinasi');
        dialog.removeAttribute('aria-labelledby');
        detailContent.innerHTML = '<div class="grid min-h-60 place-items-center p-8 text-center text-sm text-[#5D6063]" role="status">Memuat detail destinasi...</div>';
        closeButton.focus();

        try {
            const response = await fetch(trigger.dataset.detailUrl, {
                headers: {
                    Accept: 'text/html',
                    'X-Requested-With': 'XMLHttpRequest',
                },
                credentials: 'same-origin',
                signal: requestController.signal,
            });

            if (!response.ok) throw new Error('Detail destinasi gagal dimuat.');

            detailContent.innerHTML = await response.text();
            if (!detailContent.querySelector('#destination-modal-title')) {
                throw new Error('Format detail destinasi tidak valid.');
            }

            dialog.removeAttribute('aria-label');
            dialog.setAttribute('aria-labelledby', 'destination-modal-title');
        } catch (error) {
            if (error.name === 'AbortError') return;
            detailContent.innerHTML = '<p class="grid min-h-60 place-items-center p-8 text-center text-sm text-[#9B3D2A]" role="alert">Detail destinasi tidak dapat dimuat. Silakan coba lagi.</p>';
        }
    };

    const fetchReviews = async (section, url) => {
        reviewRequestController?.abort();
        reviewRequestController = new AbortController();
        const content = section.querySelector('[data-review-content]');
        const toggle = section.querySelector('[data-review-toggle]');
        section.dataset.previewContent ??= content.innerHTML;
        content.innerHTML = '<p class="my-2 text-[11px] text-[#747979]" role="status">Memuat ulasan...</p>';

        try {
            const response = await fetch(url, {
                headers: { Accept: 'text/html', 'X-Requested-With': 'XMLHttpRequest' },
                credentials: 'same-origin',
                signal: reviewRequestController.signal,
            });
            if (!response.ok) throw new Error('Ulasan gagal dimuat.');

            const html = await response.text();
            if (!html.includes('destination-review-list')) throw new Error('Format ulasan tidak valid.');

            content.innerHTML = html;
            if (toggle) {
                toggle.setAttribute('aria-expanded', 'true');
                toggle.innerHTML = 'Tampilkan Ringkas <svg viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path d="M17 10H4m5 5-5-5 5-5"></path></svg>';
            }
        } catch (error) {
            if (error.name === 'AbortError') return;
            content.innerHTML = '<p class="my-2 text-[11px] text-[#9B3D2A]" role="alert">Ulasan tidak dapat dimuat. Silakan coba lagi.</p>';
        }
    };

    const openReviewEditor = (section, editButton = null) => {
        const editor = section.querySelector('[data-review-editor]');
        const form = editor?.querySelector('[data-review-form]');
        if (!editor || !form) return;

        if (!reviewEditorOrigins.has(editor)) {
            reviewEditorOrigins.set(editor, { parent: editor.parentNode, nextSibling: editor.nextSibling });
        }
        document.body.append(editor);

        form.reset();
        form.action = editButton?.dataset.reviewEditUrl || form.dataset.reviewStoreUrl;
        form.querySelector('[data-review-method]').value = editButton ? 'PUT' : 'POST';
        editor.querySelector('[data-review-editor-title]').textContent = editButton ? 'Edit Ulasan' : 'Tulis Ulasan';
        form.querySelector('[data-review-submit-label]').textContent = editButton ? 'Simpan Perubahan' : 'Kirim Ulasan';
        form.querySelector('[data-review-textarea]').value = editButton?.dataset.reviewText || '';

        if (editButton) {
            const rating = form.querySelector(`input[name="rating"][value="${editButton.dataset.reviewRating}"]`);
            if (rating) rating.checked = true;
        }

        form.querySelectorAll('[data-review-error], [data-review-form-error]').forEach((error) => {
            error.hidden = true;
            error.textContent = '';
        });
        const textarea = form.querySelector('[data-review-textarea]');
        form.querySelector('[data-review-counter]').textContent = `${textarea.value.length}/2000`;
        editor.classList.remove('hidden');
        editor.classList.add('grid');
        editor.querySelector('[role="dialog"]')?.focus();
        window.setTimeout(() => textarea.focus(), 0);
    };

    const closeReviewEditor = (editor) => {
        if (!editor) return;

        editor?.classList.add('hidden');
        editor?.classList.remove('grid');

        const origin = reviewEditorOrigins.get(editor);
        if (origin?.parent?.isConnected) {
            if (origin.nextSibling?.parentNode === origin.parent) {
                origin.parent.insertBefore(editor, origin.nextSibling);
            } else {
                origin.parent.append(editor);
            }
        }
        reviewEditorOrigins.delete(editor);
    };

    const submitReview = async (form) => {
        const section = form.closest('[data-destination-reviews]');
        const submitButton = form.querySelector('[type="submit"]');
        const submitLabel = form.querySelector('[data-review-submit-label]');
        const loadingLabel = form.querySelector('[data-review-submit-loading]');
        const formError = form.querySelector('[data-review-form-error]');

        form.querySelectorAll('[data-review-error]').forEach((error) => {
            error.hidden = true;
            error.textContent = '';
        });
        formError.hidden = true;
        formError.textContent = '';
        submitButton.disabled = true;
        submitLabel.hidden = true;
        loadingLabel.hidden = false;
        reviewRequestController?.abort();
        reviewRequestController = new AbortController();

        try {
            const response = await fetch(form.action, {
                    method: 'POST',
                body: new FormData(form),
                headers: {
                    Accept: 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                },
                credentials: 'same-origin',
                signal: reviewRequestController.signal,
            });
            const payload = await response.json();

            if (response.status === 422 && payload.errors) {
                Object.entries(payload.errors).forEach(([field, messages]) => {
                    const error = form.querySelector(`[data-review-error="${field}"]`);
                    if (error) {
                        error.textContent = messages[0];
                        error.hidden = false;
                    }
                });
                return;
            }

            if (!response.ok) {
                throw new Error(payload.message || 'Ulasan tidak dapat dikirim. Silakan coba lagi.');
            }

            if (payload.html) {
                closeReviewEditor(form.closest('[data-review-editor]'));
                section.outerHTML = payload.html;
                detailContent.querySelector('[data-destination-reviews]')?.scrollIntoView({ block: 'nearest', behavior: 'smooth' });
            }
        } catch (error) {
            if (error.name === 'AbortError') return;
            formError.textContent = error.message || 'Ulasan tidak dapat dikirim. Silakan coba lagi.';
            formError.hidden = false;
        } finally {
            if (form.isConnected) {
                submitButton.disabled = false;
                submitLabel.hidden = false;
                loadingLabel.hidden = true;
            }
        }
    };

    document.addEventListener('submit', (event) => {
        const form = event.target.closest('[data-review-form]');
        if (!form) return;

        event.preventDefault();
        submitReview(form);
    });

    document.addEventListener('input', (event) => {
        const field = event.target.closest('[data-review-field]');
        if (!field) return;

        if (event.target.matches('[data-review-textarea]')) {
            const counter = field.querySelector('[data-review-counter]');
            if (counter) counter.textContent = `${event.target.value.length}/2000`;
        }

        const error = field.querySelector('[data-review-error]');
        if (error) {
            error.hidden = true;
            error.textContent = '';
        }
    });

    document.addEventListener('change', (event) => {
        const field = event.target.closest('[data-review-field="rating"]');
        if (!field) return;

        const error = field.querySelector('[data-review-error="rating"]');
        if (error) {
            error.hidden = true;
            error.textContent = '';
        }
    });

    document.addEventListener('click', (event) => {
        const composeButton = event.target.closest('[data-review-compose]');
        if (composeButton) {
            openReviewEditor(composeButton.closest('[data-destination-reviews]'));
            return;
        }

        const editButton = event.target.closest('[data-review-edit]');
        if (editButton) {
            openReviewEditor(editButton.closest('[data-destination-reviews]'), editButton);
            return;
        }

        const editorClose = event.target.closest('[data-review-editor-close], [data-review-editor-overlay]');
        if (editorClose) {
            closeReviewEditor(editorClose.closest('[data-review-editor]') || editorClose.parentElement.querySelector('[data-review-editor]'));
            return;
        }

        const reviewToggle = event.target.closest('[data-review-toggle]');
        if (reviewToggle) {
            const section = reviewToggle.closest('[data-destination-reviews]');
            if (reviewToggle.getAttribute('aria-expanded') === 'true') {
                reviewRequestController?.abort();
                section.querySelector('[data-review-content]').innerHTML = section.dataset.previewContent;
                reviewToggle.setAttribute('aria-expanded', 'false');
                reviewToggle.innerHTML = 'Lihat Semua <svg viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path d="M3 10h13M11 5l5 5-5 5"></path></svg>';
            } else {
                fetchReviews(section, reviewToggle.dataset.allReviewsUrl);
            }
            return;
        }

        const reviewPageLink = event.target.closest('[data-review-pagination] a');
        if (reviewPageLink) {
            event.preventDefault();
            fetchReviews(reviewPageLink.closest('[data-destination-reviews]'), reviewPageLink.href);
            return;
        }

        const trigger = event.target.closest('[data-destination-detail]');
        if (trigger) {
            event.preventDefault();
            openModal(trigger);
            return;
        }

        if (event.target.closest('[data-modal-close]') || event.target === overlay) closeModal();
    });

    document.addEventListener('keydown', (event) => {
        if (detailModal.hidden) return;

        if (event.key === 'Escape') {
            event.preventDefault();
            closeModal();
            return;
        }

        if (event.key !== 'Tab') return;

        const focusable = Array.from(dialog.querySelectorAll('button:not([disabled]), a[href], input:not([disabled]), select:not([disabled]), [tabindex]:not([tabindex="-1"])'))
            .filter((element) => element.offsetParent !== null);

        if (!focusable.length) {
            event.preventDefault();
            dialog.focus();
            return;
        }

        const first = focusable[0];
        const last = focusable[focusable.length - 1];

        if (event.shiftKey && document.activeElement === first) {
            event.preventDefault();
            last.focus();
        } else if (!event.shiftKey && document.activeElement === last) {
            event.preventDefault();
            first.focus();
        }
    });
}
