document.addEventListener('DOMContentLoaded', () => {
    // ==================================================
    // 0. PILIH FORM TAMBAH ATAU EDIT DESTINASI
    // ==================================================
    // Jangan sampai form pencarian di halaman index ikut tervalidasi.
    const forms = document.querySelectorAll('form[action*="destinations"]');

    const form = [...forms].find((candidate) => {
        return candidate.querySelector('#description')
            && candidate.querySelector('input[name="categories[]"]');
    });

    if (!form) {
        return;
    }

    // ==================================================
    // 1. HITUNG KARAKTER DESKRIPSI
    // ==================================================
    const descriptionInput = form.querySelector('#description');
    const descriptionCount = form.querySelector('#description-count');

    function updateDescriptionCount() {
        if (descriptionInput && descriptionCount) {
            descriptionCount.textContent = descriptionInput.value.length;
        }
    }

    if (descriptionInput) {
        descriptionInput.addEventListener('input', updateDescriptionCount);
        updateDescriptionCount();
    }

    // ==================================================
    // 2. TAMPILKAN NAMA FOTO
    // ==================================================
    const imageInput = form.querySelector('#image');
    const imageFilename = form.querySelector('#image-filename');

    if (imageInput && imageFilename) {
        imageInput.addEventListener('change', function () {
            imageFilename.textContent = this.files.length > 0
                ? this.files[0].name
                : '';
        });
    }

    // ==================================================
    // 3. PILIHAN TIKET MASUK
    // ==================================================
    const entranceFeeRadios = form.querySelectorAll(
        'input[name="entrance_fee_type"]'
    );

    const entranceFixedFields = form.querySelector('#entrance-fixed-fields');
    const entranceRangeFields = form.querySelector('#entrance-range-fields');

    function updateEntranceFeeFields() {
        const selected = form.querySelector(
            'input[name="entrance_fee_type"]:checked'
        )?.value;

        entranceFixedFields?.classList.toggle('hidden', selected !== 'fixed');
        entranceRangeFields?.classList.toggle('hidden', selected !== 'range');
    }

    entranceFeeRadios.forEach((radio) => {
        radio.addEventListener('change', updateEntranceFeeFields);
    });

    updateEntranceFeeFields();

    // ==================================================
    // 4. PILIHAN PERKIRAAN PENGELUARAN
    // ==================================================
    const spendingRadios = form.querySelectorAll(
        'input[name="average_spending_type"]'
    );

    const spendingFixedFields = form.querySelector('#spending-fixed-fields');
    const spendingRangeFields = form.querySelector('#spending-range-fields');

    function updateSpendingFields() {
        const selected = form.querySelector(
            'input[name="average_spending_type"]:checked'
        )?.value;

        spendingFixedFields?.classList.toggle('hidden', selected !== 'fixed');
        spendingRangeFields?.classList.toggle('hidden', selected !== 'range');
    }

    spendingRadios.forEach((radio) => {
        radio.addEventListener('change', updateSpendingFields);
    });

    updateSpendingFields();

    // ==================================================
    // 5. JADWAL OPERASIONAL DINAMIS
    // ==================================================
    const hoursContainer = form.querySelector('#operating-hours-container');
    const addHoursButton = form.querySelector('#add-operating-hours');

    const dayNames = [
        'Senin',
        'Selasa',
        'Rabu',
        'Kamis',
        'Jumat',
        'Sabtu',
        'Minggu'
    ];

    function updateScheduleNumbers() {
        if (!hoursContainer) {
            return;
        }

        const items = hoursContainer.querySelectorAll('.operating-hours-item');

        items.forEach((item, index) => {
            const number = item.querySelector('.schedule-number');

            if (number) {
                number.textContent = index + 1;
            }

            const removeButton = item.querySelector('.remove-schedule');

            if (removeButton) {
                removeButton.classList.toggle('invisible', items.length === 1);
            }
        });
    }

    function createSchedule(index) {
        const item = document.createElement('div');

        item.className = 'operating-hours-item rounded-lg border border-black/20 p-4';

        const header = document.createElement('div');
        header.className = 'mb-3 flex items-center justify-between';

        const title = document.createElement('h3');
        title.className = 'text-sm font-bold text-brand-black';
        title.append('Jadwal ');

        const number = document.createElement('span');
        number.className = 'schedule-number';
        number.textContent = index + 1;

        title.appendChild(number);

        const requiredMark = document.createElement('span');
        requiredMark.className = 'text-red-500';
        requiredMark.textContent = ' *';
        title.appendChild(requiredMark);

        const removeButton = document.createElement('button');
        removeButton.type = 'button';
        removeButton.className = 'remove-schedule text-red-500 transition hover:text-red-700';
        removeButton.title = 'Hapus jadwal';
        removeButton.setAttribute('aria-label', 'Hapus jadwal');

        const trashIcon = document.createElement('i');
        trashIcon.className = 'fa-solid fa-trash-can';
        removeButton.appendChild(trashIcon);

        header.append(title, removeButton);

        const daySection = document.createElement('div');
        daySection.className = 'mb-4';

        const dayLabel = document.createElement('label');
        dayLabel.className = 'mb-2 block text-sm font-semibold text-brand-black';
        dayLabel.textContent = 'Hari *';

        const dayOptions = document.createElement('div');
        dayOptions.className = 'flex flex-wrap gap-2';

        dayNames.forEach((day) => {
            const label = document.createElement('label');
            label.className = 'day-option cursor-pointer';

            const checkbox = document.createElement('input');
            checkbox.type = 'checkbox';
            checkbox.name = `operating_hours[${index}][days][]`;
            checkbox.value = day;
            checkbox.className = 'peer sr-only';

            const text = document.createElement('span');
            text.className = 'inline-flex rounded-lg border border-black/20 px-3 py-2 text-sm text-brand-gray transition hover:border-brand-green peer-checked:border-brand-green peer-checked:bg-brand-green peer-checked:text-white';
            text.textContent = day;

            label.append(checkbox, text);
            dayOptions.appendChild(label);
        });

        const everyDayLabel = document.createElement('label');
        everyDayLabel.className = 'day-option cursor-pointer';

        const everyDayCheckbox = document.createElement('input');
        everyDayCheckbox.type = 'checkbox';
        everyDayCheckbox.name = `operating_hours[${index}][every_day]`;
        everyDayCheckbox.value = '1';
        everyDayCheckbox.className = 'every-day-checkbox peer sr-only';

        const everyDayText = document.createElement('span');
        everyDayText.className = 'inline-flex rounded-lg border border-black/20 px-3 py-2 text-sm text-brand-gray transition hover:border-brand-green peer-checked:border-brand-green peer-checked:bg-brand-green peer-checked:text-white';
        everyDayText.textContent = 'Setiap Hari';

        everyDayLabel.append(everyDayCheckbox, everyDayText);
        dayOptions.appendChild(everyDayLabel);

        daySection.append(dayLabel, dayOptions);

        const timeSection = document.createElement('div');

        const timeLabel = document.createElement('label');
        timeLabel.className = 'mb-2 block text-sm font-semibold text-brand-black';
        timeLabel.textContent = 'Jam *';

        const timeInput = document.createElement('input');
        timeInput.type = 'text';
        timeInput.name = `operating_hours[${index}][time]`;
        timeInput.placeholder = '08.00-17.00';
        timeInput.className = 'w-full rounded-full border border-black/20 px-4 py-2 text-sm text-brand-black outline-none transition focus:border-brand-green focus:ring-2 focus:ring-brand-green/15';

        timeSection.append(timeLabel, timeInput);
        item.append(header, daySection, timeSection);

        return item;
    }

    if (hoursContainer && addHoursButton) {
        addHoursButton.addEventListener('click', () => {
            const count = hoursContainer.querySelectorAll('.operating-hours-item').length;

            hoursContainer.appendChild(createSchedule(count));
            updateScheduleNumbers();
        });

        hoursContainer.addEventListener('click', (event) => {
            const removeButton = event.target.closest('.remove-schedule');

            if (!removeButton) {
                return;
            }

            const items = hoursContainer.querySelectorAll('.operating-hours-item');

            if (items.length <= 1) {
                return;
            }

            removeButton.closest('.operating-hours-item').remove();
            updateScheduleNumbers();
        });

        // Sinkronisasi pilihan hari saat halaman pertama kali dibuka.
        hoursContainer.querySelectorAll('.operating-hours-item').forEach((item) => {
            const everyDayCheckbox = item.querySelector('.every-day-checkbox');

            if (!everyDayCheckbox) {
                return;
            }

            if (everyDayCheckbox.checked) {
                item.querySelectorAll('input[name$="[days][]"]').forEach((dayCheckbox) => {
                    dayCheckbox.checked = true;
                    dayCheckbox.disabled = true;
                });
            }
        });

        // Sinkronisasi pilihan hari saat checkbox berubah.
        hoursContainer.addEventListener('change', (event) => {
            const checkbox = event.target;

            if (!checkbox.matches('.every-day-checkbox')) {
                return;
            }

            const item = checkbox.closest('.operating-hours-item');

            item.querySelectorAll('input[name$="[days][]"]').forEach((dayCheckbox) => {
                dayCheckbox.checked = checkbox.checked;
                dayCheckbox.disabled = checkbox.checked;
            });
        });

        updateScheduleNumbers();
    }

    // ==================================================
    // 6. BANTUAN MEMBUAT HIDDEN INPUT JSON
    // ==================================================
    function setHiddenInput(name, value) {
        let input = form.querySelector(`input[type="hidden"][name="${name}"]`);

        if (!input) {
            input = document.createElement('input');
            input.type = 'hidden';
            input.name = name;
            form.appendChild(input);
        }

        input.value = JSON.stringify(value);
    }

    function getNumber(inputName) {
        const input = form.querySelector(`[name="${inputName}"]`);

        if (!input || input.value.trim() === '') {
            return null;
        }

        return Number(input.value);
    }

    function getText(inputName) {
        return form.querySelector(`[name="${inputName}"]`)?.value.trim() || '';
    }

    // ==================================================
    // 7. KIRIM DATA SEBAGAI JSON
    // ==================================================
    form.addEventListener('submit', (event) => {
        // Validasi kategori destinasi.
        const selectedCategories = form.querySelectorAll(
            'input[name="categories[]"]:checked'
        );

        if (selectedCategories.length === 0) {
            event.preventDefault();
            alert('Pilih minimal satu kategori destinasi.');
            return;
        }

        // Susun data jadwal operasional.
        const schedules = [];

        if (hoursContainer) {
            const items = hoursContainer.querySelectorAll('.operating-hours-item');

            for (const item of items) {
                const everyDay = item.querySelector('.every-day-checkbox')?.checked || false;

                const days = everyDay
                    ? [...dayNames]
                    : [...item.querySelectorAll('input[name$="[days][]"]:checked')]
                        .map((checkbox) => checkbox.value);

                const time = item.querySelector('input[name$="[time]"]')?.value.trim() || '';

                if (days.length === 0 || time === '') {
                    event.preventDefault();
                    alert('Setiap jadwal harus memiliki hari dan jam operasional.');
                    return;
                }

                schedules.push({
                    days: days,
                    hours: time
                });
            }
        }

        const operatingHoursData = {
            schedules: schedules,
            notes: getText('operating_hours_note')
        };

        // Susun data tiket masuk.
        const entranceType = form.querySelector(
            'input[name="entrance_fee_type"]:checked'
        )?.value;

        const entranceFeeData = {
            type: entranceType,
            min: null,
            max: null,
            amount: null,
            notes: getText('entrance_fee_note')
        };

        if (entranceType === 'fixed') {
            entranceFeeData.amount = getNumber('entrance_fee_fixed');

            if (entranceFeeData.amount === null) {
                event.preventDefault();
                alert('Isi nominal tiket masuk.');
                return;
            }
        } else if (entranceType === 'range') {
            entranceFeeData.min = getNumber('entrance_fee_min');
            entranceFeeData.max = getNumber('entrance_fee_max');

            if (
                entranceFeeData.min === null ||
                entranceFeeData.max === null ||
                entranceFeeData.min > entranceFeeData.max
            ) {
                event.preventDefault();
                alert('Isi rentang harga tiket masuk dengan benar.');
                return;
            }
        } else if (entranceType !== 'free') {
            event.preventDefault();
            alert('Pilih jenis tiket masuk.');
            return;
        }

        // Susun data perkiraan pengeluaran.
        const spendingType = form.querySelector(
            'input[name="average_spending_type"]:checked'
        )?.value;

        const spendingData = {
            type: null,
            min: null,
            max: null,
            amount: null,
            notes: getText('average_spending_note')
        };

        if (spendingType === 'fixed') {
            const amount = getNumber('average_spending_fixed');

            if (amount !== null) {
                spendingData.type = 'fixed';
                spendingData.amount = amount;
            }
        } else if (spendingType === 'range') {
            const min = getNumber('average_spending_min');
            const max = getNumber('average_spending_max');

            if (min !== null || max !== null) {
                if (
                    min === null ||
                    max === null ||
                    min > max
                ) {
                    event.preventDefault();
                    alert('Isi rentang perkiraan pengeluaran dengan benar.');
                    return;
                }

                spendingData.type = 'range';
                spendingData.min = min;
                spendingData.max = max;
            }
        }

        // Ubah data menjadi JSON untuk kolom TEXT di database.
        setHiddenInput('opening_hours', operatingHoursData);
        setHiddenInput('entrance_fee', entranceFeeData);
        setHiddenInput('average_spending', spendingData);

        // Hilangkan nama field operasional lama agar Laravel tidak menerima
        // array sekaligus JSON string dengan nama data yang sama.
        form.querySelectorAll('[name^="operating_hours["]').forEach((input) => {
            input.disabled = true;
        });

        const noteInput = form.querySelector('[name="operating_hours_note"]');

        if (noteInput) {
            noteInput.disabled = true;
        }

        form.querySelectorAll(
            '[name="entrance_fee_type"], ' +
            '[name="entrance_fee_fixed"], ' +
            '[name="entrance_fee_min"], ' +
            '[name="entrance_fee_max"], ' +
            '[name="entrance_fee_note"], ' +
            '[name="average_spending_type"], ' +
            '[name="average_spending_fixed"], ' +
            '[name="average_spending_min"], ' +
            '[name="average_spending_max"], ' +
            '[name="average_spending_note"]'
        ).forEach((input) => {
            input.disabled = true;
        });
    });
});


// ==================================================
// MODAL KONFIRMASI HAPUS DESTINASI
// ==================================================
document.addEventListener('DOMContentLoaded', () => {
    const deleteModal = document.getElementById('delete-modal');
    const modalContent = document.getElementById('delete-modal-content');
    const destinationName = document.getElementById('delete-destination-name');
    const cancelButton = document.getElementById('cancel-delete');
    const confirmButton = document.getElementById('confirm-delete');

    if (
        !deleteModal ||
        !modalContent ||
        !destinationName ||
        !cancelButton ||
        !confirmButton
    ) {
        return;
    }

    let selectedForm = null;

    const closeModal = () => {
        deleteModal.classList.add('opacity-0');
        modalContent.classList.remove('scale-100', 'opacity-100');
        modalContent.classList.add('scale-95', 'opacity-0');

        setTimeout(() => {
            deleteModal.classList.add('hidden');
            deleteModal.classList.remove('flex');
        }, 200);

        selectedForm = null;
    };

    document.querySelectorAll('.delete-destination-form').forEach((form) => {
        form.addEventListener('submit', (event) => {
            event.preventDefault();

            selectedForm = form;

            const row = form.closest('tr');
            const nameElement = row?.querySelector('[data-destination-name]');

            destinationName.textContent = nameElement?.textContent.trim() || 'destinasi ini';

            deleteModal.classList.remove('hidden');
            deleteModal.classList.add('flex', 'opacity-0');

            requestAnimationFrame(() => {
                deleteModal.classList.remove('opacity-0');
                modalContent.classList.remove('scale-95', 'opacity-0');
                modalContent.classList.add('scale-100', 'opacity-100');
            });
        });
    });

    cancelButton.addEventListener('click', closeModal);

    confirmButton.addEventListener('click', () => {
        if (selectedForm) {
            selectedForm.submit();
        }
    });

    deleteModal.addEventListener('click', (event) => {
        if (event.target === deleteModal) {
            closeModal();
        }
    });

    document.addEventListener('keydown', (event) => {
        if (event.key === 'Escape' && !deleteModal.classList.contains('hidden')) {
            closeModal();
        }
    });
});