function initTripDateRange(root) {
    const form = root.closest('form');
    const tripNameInput = form?.querySelector('[data-trip-name]');
    const tripNameError = form?.querySelector('[data-trip-name-error]');
    const startInput = root.querySelector('[data-date-input="start"]');
    const endInput = root.querySelector('[data-date-input="end"]');
    const error = root.querySelector('[data-range-error]');
    const pickers = [...root.querySelectorAll('[data-date-picker]')].map((element) => ({
        element,
        field: element.dataset.datePicker,
        trigger: element.querySelector('[data-date-trigger]'),
        value: element.querySelector('[data-date-value]'),
        calendar: element.querySelector('[data-date-calendar]'),
        monthLabel: element.querySelector('[data-date-month]'),
        daysGrid: element.querySelector('[data-date-days]'),
        previousButton: element.querySelector('[data-date-prev]'),
        nextButton: element.querySelector('[data-date-next]'),
        todayButton: element.querySelector('[data-date-today]'),
        hint: element.querySelector('[data-date-hint]'),
        visibleMonth: null,
        focusedDate: null,
        open: false,
        animation: null,
    }));

    if (!form || !startInput || !endInput || pickers.length !== 2 || pickers.some((picker) => !picker.calendar || !picker.daysGrid)) return;

    const today = startOfDay(new Date());
    let startDate = parseDate(startInput.value);
    let endDate = parseDate(endInput.value);
    if (startDate && endDate && endDate < startDate) endDate = null;

    function startOfDay(date) {
        return new Date(date.getFullYear(), date.getMonth(), date.getDate());
    }

    function monthStart(date) {
        return new Date(date.getFullYear(), date.getMonth(), 1);
    }

    function parseDate(value) {
        const match = /^(\d{4})-(\d{2})-(\d{2})$/.exec(value || '');
        if (!match) return null;
        const date = new Date(Number(match[1]), Number(match[2]) - 1, Number(match[3]));
        return date.getFullYear() === Number(match[1]) && date.getMonth() === Number(match[2]) - 1 && date.getDate() === Number(match[3]) ? date : null;
    }

    function toIsoDate(date) {
        return `${date.getFullYear()}-${String(date.getMonth() + 1).padStart(2, '0')}-${String(date.getDate()).padStart(2, '0')}`;
    }

    function sameDay(left, right) {
        return Boolean(left && right && toIsoDate(left) === toIsoDate(right));
    }

    function formatDate(date) {
        return new Intl.DateTimeFormat('id-ID', { day: '2-digit', month: 'short', year: 'numeric' }).format(date);
    }

    function setError(message = '') {
        error.textContent = message;
        error.classList.toggle('hidden', !message);
    }

    function syncValues() {
        startInput.value = startDate ? toIsoDate(startDate) : '';
        endInput.value = endDate ? toIsoDate(endDate) : '';
        root.querySelector('[data-date-value="start"]').textContent = startDate ? formatDate(startDate) : 'Pilih tanggal mulai';
        root.querySelector('[data-date-value="end"]').textContent = endDate ? formatDate(endDate) : 'Pilih tanggal selesai';
        pickers.forEach((picker) => {
            picker.hint.textContent = picker.field === 'start'
                ? (startDate ? 'Tanggal mulai trip' : 'Pilih tanggal mulai')
                : (endDate ? 'Tanggal selesai trip' : 'Pilih tanggal selesai');
        });
    }

    function shiftMonth(date, amount) {
        const target = new Date(date.getFullYear(), date.getMonth() + amount, 1);
        const lastDay = new Date(target.getFullYear(), target.getMonth() + 1, 0).getDate();
        target.setDate(Math.min(date.getDate(), lastDay));
        return target;
    }

    function renderCalendar(picker, focusIso = null) {
        picker.monthLabel.textContent = new Intl.DateTimeFormat('id-ID', { month: 'long', year: 'numeric' }).format(picker.visibleMonth);
        picker.daysGrid.replaceChildren();
        const firstDay = monthStart(picker.visibleMonth);
        const mondayOffset = (firstDay.getDay() + 6) % 7;
        const gridStart = new Date(firstDay.getFullYear(), firstDay.getMonth(), 1 - mondayOffset);

        for (let index = 0; index < 42; index += 1) {
            const date = new Date(gridStart.getFullYear(), gridStart.getMonth(), gridStart.getDate() + index);
            const isoDate = toIsoDate(date);
            const isStart = sameDay(date, startDate);
            const isEnd = sameDay(date, endDate);
            const isEndpoint = picker.field === 'start' ? isStart : isEnd;
            const isInRange = Boolean(startDate && endDate && date > startDate && date < endDate);
            const isCurrentMonth = date.getMonth() === picker.visibleMonth.getMonth();
            const isToday = sameDay(date, today);
            const button = document.createElement('button');

            button.type = 'button';
            button.dataset.date = isoDate;
            button.setAttribute('role', 'gridcell');
            button.setAttribute('aria-label', new Intl.DateTimeFormat('id-ID', { dateStyle: 'full' }).format(date));
            button.setAttribute('aria-pressed', String(isEndpoint));
            button.tabIndex = sameDay(date, picker.focusedDate) ? 0 : -1;
            button.className = [
                'relative grid h-9 w-full place-items-center text-[12px] font-medium transition-colors duration-150',
                'focus-visible:z-10 focus-visible:rounded-full focus-visible:outline-2 focus-visible:outline-offset-1 focus-visible:outline-[#1B665D]',
                isEndpoint
                    ? 'rounded-full bg-[#123B35] text-white shadow-sm dark:bg-[#3A7466] dark:text-white'
                    : isInRange
                        ? 'rounded-none bg-[#E6EFEA] text-[#17483F] dark:bg-[#29453E] dark:text-[#D5E9E1]'
                        : 'rounded-full text-[#26333A] hover:bg-[#F1E5D9] dark:text-[#E4E8E5] dark:hover:bg-[#293C37]',
                !isCurrentMonth && !isEndpoint ? 'text-[#AEB4B2] dark:text-[#687671]' : '',
                isToday && !isEndpoint ? 'after:absolute after:bottom-1 after:h-1 after:w-1 after:rounded-full after:bg-[#C66A4A]' : '',
            ].filter(Boolean).join(' ');
            button.textContent = String(date.getDate());
            button.addEventListener('click', () => selectDate(picker, date));
            picker.daysGrid.append(button);
        }

        syncValues();
        if (focusIso) picker.daysGrid.querySelector(`[data-date="${focusIso}"]`)?.focus({ preventScroll: true });
    }

    function renderAllCalendars() {
        pickers.forEach((picker) => renderCalendar(picker));
    }

    function selectDate(picker, date) {
        const selected = startOfDay(date);
        if (picker.field === 'start') {
            startDate = selected;
            if (endDate && endDate < startDate) endDate = null;
        } else {
            if (startDate && selected < startDate) {
                setError('Tanggal selesai tidak boleh sebelum tanggal mulai.');
                picker.focusedDate = selected;
                picker.visibleMonth = monthStart(selected);
                renderCalendar(picker, toIsoDate(selected));
                return;
            }
            endDate = selected;
        }

        setError();
        picker.focusedDate = selected;
        picker.visibleMonth = monthStart(selected);
        renderAllCalendars();
        setCalendarOpen(picker, false);
        picker.trigger.focus({ preventScroll: true });
    }

    function setCalendarOpen(picker, nextOpen) {
        picker.open = nextOpen;
        picker.trigger.setAttribute('aria-expanded', String(nextOpen));
        picker.calendar.setAttribute('aria-hidden', String(!nextOpen));
        picker.animation?.cancel();
        if (nextOpen) {
            pickers.filter((candidate) => candidate !== picker && candidate.open).forEach((candidate) => setCalendarOpen(candidate, false));
            // Render as a body-level overlay so viewport-locked sections cannot clip it.
            if (picker.calendar.parentElement !== document.body) document.body.append(picker.calendar);
            picker.calendar.style.display = 'block';
            positionCalendar(picker);
            picker.animation = picker.calendar.animate(
                [{ opacity: 0, transform: 'translateY(-5px)' }, { opacity: 1, transform: 'translateY(0)' }],
                { duration: matchMedia('(prefers-reduced-motion: reduce)').matches ? 0 : 160, easing: 'ease-out' },
            );
            return;
        }
        if (picker.calendar.style.display === 'none') return;
        if (matchMedia('(prefers-reduced-motion: reduce)').matches) {
            picker.calendar.style.display = 'none';
            return;
        }
        picker.animation = picker.calendar.animate(
            [{ opacity: 1, transform: 'translateY(0)' }, { opacity: 0, transform: 'translateY(-5px)' }],
            { duration: 120, easing: 'ease-in' },
        );
        picker.animation.finished.then(() => {
            if (!picker.open) {
                picker.calendar.style.display = 'none';
            }
        }).catch(() => {});
    }

    function positionCalendar(picker) {
        const triggerRect = picker.trigger.getBoundingClientRect();
        const calendarRect = picker.calendar.getBoundingClientRect();
        const margin = 12;
        const maxLeft = Math.max(margin, window.innerWidth - calendarRect.width - margin);
        const preferredLeft = picker.field === 'end' ? triggerRect.right - calendarRect.width : triggerRect.left;
        const left = Math.min(maxLeft, Math.max(margin, preferredLeft));
        const belowTop = triggerRect.bottom + 8;
        const top = belowTop + calendarRect.height <= window.innerHeight - margin
            ? belowTop
            : Math.max(margin, triggerRect.top - calendarRect.height - 8);
        picker.calendar.style.left = `${left}px`;
        picker.calendar.style.top = `${top}px`;
    }

    pickers.forEach((picker) => {
        const selectedDate = picker.field === 'start' ? startDate : endDate;
        picker.visibleMonth = monthStart(selectedDate || today);
        picker.focusedDate = selectedDate || today;
        renderCalendar(picker);

        picker.trigger.addEventListener('click', () => {
            if (picker.open) {
                setCalendarOpen(picker, false);
                return;
            }
            const selected = picker.field === 'start' ? startDate : endDate;
            picker.focusedDate = selected || today;
            picker.visibleMonth = monthStart(picker.focusedDate);
            renderCalendar(picker);
            setCalendarOpen(picker, true);
        });
        picker.previousButton.addEventListener('click', () => {
            picker.visibleMonth = monthStart(shiftMonth(picker.visibleMonth, -1));
            picker.focusedDate = shiftMonth(picker.focusedDate, -1);
            renderCalendar(picker);
            picker.previousButton.focus({ preventScroll: true });
        });
        picker.nextButton.addEventListener('click', () => {
            picker.visibleMonth = monthStart(shiftMonth(picker.visibleMonth, 1));
            picker.focusedDate = shiftMonth(picker.focusedDate, 1);
            renderCalendar(picker);
            picker.nextButton.focus({ preventScroll: true });
        });
        picker.todayButton.addEventListener('click', () => {
            picker.focusedDate = today;
            picker.visibleMonth = monthStart(today);
            renderCalendar(picker, toIsoDate(today));
        });
        picker.daysGrid.addEventListener('keydown', (event) => {
            const date = parseDate(event.target.dataset.date);
            if (!date) return;
            let nextDate = null;
            if (event.key === 'ArrowLeft') nextDate = new Date(date.getFullYear(), date.getMonth(), date.getDate() - 1);
            if (event.key === 'ArrowRight') nextDate = new Date(date.getFullYear(), date.getMonth(), date.getDate() + 1);
            if (event.key === 'ArrowUp') nextDate = new Date(date.getFullYear(), date.getMonth(), date.getDate() - 7);
            if (event.key === 'ArrowDown') nextDate = new Date(date.getFullYear(), date.getMonth(), date.getDate() + 7);
            if (event.key === 'Home') nextDate = new Date(date.getFullYear(), date.getMonth(), date.getDate() - ((date.getDay() + 6) % 7));
            if (event.key === 'End') nextDate = new Date(date.getFullYear(), date.getMonth(), date.getDate() + (6 - ((date.getDay() + 6) % 7)));
            if (event.key === 'PageUp') nextDate = shiftMonth(date, -1);
            if (event.key === 'PageDown') nextDate = shiftMonth(date, 1);
            if (!nextDate) return;
            event.preventDefault();
            picker.focusedDate = nextDate;
            picker.visibleMonth = monthStart(nextDate);
            renderCalendar(picker, toIsoDate(nextDate));
        });
    });

    document.addEventListener('pointerdown', (event) => {
        pickers.filter((picker) => picker.open && !picker.element.contains(event.target) && !picker.calendar.contains(event.target)).forEach((picker) => setCalendarOpen(picker, false));
    });
    const repositionOpenCalendars = () => pickers.filter((picker) => picker.open).forEach(positionCalendar);
    window.addEventListener('resize', repositionOpenCalendars);
    window.addEventListener('scroll', repositionOpenCalendars, true);
    document.addEventListener('keydown', (event) => {
        if (event.key !== 'Escape') return;
        const openPicker = pickers.find((picker) => picker.open);
        if (openPicker) {
            setCalendarOpen(openPicker, false);
            openPicker.trigger.focus({ preventScroll: true });
        }
    });
    form.addEventListener('submit', (event) => {
        const tripName = tripNameInput?.value.trim() || '';
        if (!tripName) {
            event.preventDefault();
            tripNameError.textContent = 'Nama trip wajib diisi.';
            tripNameError.classList.remove('hidden');
            tripNameInput.setAttribute('aria-invalid', 'true');
            tripNameInput.classList.add('!border-[#C64D3F]', '!ring-2', '!ring-[#C64D3F]/15');
            tripNameInput.focus({ preventScroll: true });
            return;
        }

        const submittedStart = parseDate(startInput.value);
        const submittedEnd = parseDate(endInput.value);
        if (!submittedStart || !submittedEnd || submittedEnd < submittedStart) {
            event.preventDefault();
            setError(!submittedStart || !submittedEnd
                ? 'Pilih tanggal mulai dan tanggal selesai.'
                : 'Tanggal selesai tidak boleh sebelum tanggal mulai.');
            const invalidPicker = pickers.find((picker) => picker.field === (!submittedStart ? 'start' : 'end'));
            if (invalidPicker) {
                invalidPicker.focusedDate = invalidPicker.field === 'start' ? (startDate || today) : (endDate || startDate || today);
                invalidPicker.visibleMonth = monthStart(invalidPicker.focusedDate);
                renderCalendar(invalidPicker);
                setCalendarOpen(invalidPicker, true);
                invalidPicker.trigger.focus({ preventScroll: true });
            }
        }
    });

    tripNameInput?.addEventListener('input', () => {
        if (!tripNameInput.value.trim()) return;
        tripNameError.textContent = '';
        tripNameError.classList.add('hidden');
        tripNameInput.removeAttribute('aria-invalid');
        tripNameInput.classList.remove('!border-[#C64D3F]', '!ring-2', '!ring-[#C64D3F]/15');
    });
}

document.querySelectorAll('[data-trip-date-range]').forEach(initTripDateRange);
