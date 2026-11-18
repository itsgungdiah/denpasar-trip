const profileForm = document.querySelector('[data-profile-form]');

if (profileForm) {
    const editButton = document.querySelector('[data-profile-edit]');
    const saveButton = document.querySelector('[data-profile-save]');
    const cancelButton = document.querySelector('[data-profile-cancel]');
    const passwordFields = profileForm.querySelector('[data-password-fields]');
    const passwordNote = profileForm.querySelector('[data-password-note]');
    const passwordDisplay = profileForm.querySelector('[data-password-display]');
    const editableFields = [...profileForm.querySelectorAll('input[name="name"], input[name="email"]')];
    const passwordInputs = [...profileForm.querySelectorAll('input[name="current_password"], input[name="new_password"], input[name="new_password_confirmation"]')];
    let editing = false;

    const setVisible = (element, visible, display = 'block') => {
        if (!element) return;
        element.hidden = !visible;
        element.style.display = visible ? display : 'none';
    };

    const setEditing = (enabled) => {
        editing = enabled;
        editButton?.setAttribute('aria-pressed', String(enabled));
        setVisible(editButton, !enabled, 'inline-flex');
        setVisible(saveButton, enabled, 'inline-flex');
        setVisible(cancelButton, enabled, 'inline-flex');
        setVisible(passwordFields, enabled, 'grid');
        setVisible(passwordDisplay, !enabled, 'grid');
        setVisible(passwordNote, enabled, 'block');
        editableFields.forEach((input) => {
            input.readOnly = !enabled;
            input.tabIndex = enabled ? 0 : -1;
        });

        if (enabled) profileForm.querySelector('input[name="name"]')?.focus();
    };

    const cancelEditing = () => {
        editableFields.forEach((input) => {
            input.value = input.dataset.savedValue ?? input.value;
            input.removeAttribute('aria-invalid');
        });
        passwordInputs.forEach((input) => {
            input.value = '';
            input.removeAttribute('aria-invalid');
        });
        profileForm.querySelectorAll('small').forEach((message) => { message.hidden = true; });
        document.querySelector('[role="alert"]')?.remove();
        if (saveButton) {
            saveButton.disabled = false;
            saveButton.textContent = 'Simpan';
        }
        setEditing(false);
        editButton?.focus();
    };

    editButton?.addEventListener('click', () => setEditing(true));
    cancelButton?.addEventListener('click', cancelEditing);

    if (profileForm.querySelector('[aria-invalid="true"]')) setEditing(true);

    profileForm.addEventListener('submit', () => {
        if (!saveButton) return;
        saveButton.disabled = true;
        saveButton.textContent = 'Menyimpan...';
    });
}
