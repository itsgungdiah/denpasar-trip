document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('[data-toggle-password-for]').forEach((button) => {
        const input = document.getElementById(button.dataset.togglePasswordFor);
        if (!input) return;

        button.addEventListener('click', () => {
            const showing = input.type === 'password';
            input.type = showing ? 'text' : 'password';
            button.setAttribute('aria-label', showing ? 'Sembunyikan konfirmasi password' : 'Tampilkan konfirmasi password');
            button.setAttribute('aria-pressed', String(showing));
        });
    });

    document.querySelectorAll('form[data-auth-form]').forEach((form) => {
        const mode = form.dataset.authForm;
        const inputs = [...form.querySelectorAll('[data-auth-field]')];
        let submitted = false;

        const messageFor = (input) => {
            const value = input.value.trim();
            const type = input.dataset.authField;

            if (type === 'terms') {
                return input.checked ? '' : 'Persetujuan wajib dicentang.';
            }

            if (!value) {
                if (type === 'name') return 'Nama wajib diisi.';
                if (type === 'email') return 'Email wajib diisi.';
                if (type === 'password') return 'Password wajib diisi.';
                if (type === 'password_confirmation') return 'Konfirmasi password wajib diisi.';
            }

            if (type === 'email' && !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(value)) {
                return 'Format email tidak valid.';
            }

            if (type === 'password' && mode === 'register') {
                if (value.length < 8) return 'Password minimal 8 karakter.';
                if (!/\p{L}/u.test(value)) return 'Password harus mengandung huruf.';
                if (!/\p{N}/u.test(value)) return 'Password harus mengandung angka.';
            }

            if (type === 'password_confirmation') {
                const password = form.querySelector('[data-auth-field="password"]');
                if (password && input.value !== password.value) {
                    return 'Konfirmasi password tidak cocok.';
                }
            }

            return '';
        };

        const validateField = (input) => {
            const message = messageFor(input);
            const error = form.querySelector(`[data-field-error="${input.dataset.authField}"]`);
            const shell = input.closest('.auth-input-shell');

            input.setAttribute('aria-invalid', message ? 'true' : 'false');
            shell?.classList.toggle('!border-red-500', Boolean(message));
            shell?.classList.toggle('border-2', Boolean(message));
            shell?.classList.toggle('border-white/90', !message);
            if (input.type === 'checkbox') {
                input.classList.toggle('border-red-500', Boolean(message));
            }

            if (error) {
                error.textContent = message;
                error.classList.toggle('hidden', !message);
            }

            return !message;
        };

        inputs.forEach((input) => {
            input.addEventListener('blur', () => {
                input.dataset.touched = 'true';
                validateField(input);
            });

            input.addEventListener(input.type === 'checkbox' ? 'change' : 'input', () => {
                const error = form.querySelector(`[data-field-error="${input.dataset.authField}"]`);
                if (submitted || input.dataset.touched === 'true' || (error && !error.classList.contains('hidden'))) {
                    validateField(input);
                }

                if (input.dataset.authField === 'password') {
                    const confirmation = form.querySelector('[data-auth-field="password_confirmation"]');
                    const confirmationError = confirmation
                        ? form.querySelector('[data-field-error="password_confirmation"]')
                        : null;
                    if (confirmation && (
                        submitted
                        || confirmation.dataset.touched === 'true'
                        || (confirmationError && !confirmationError.classList.contains('hidden'))
                    )) {
                        validateField(confirmation);
                    }
                }
            });
        });

        form.addEventListener('submit', (event) => {
            submitted = true;
            const valid = inputs.map(validateField).every(Boolean);

            if (!valid) {
                event.preventDefault();
                form.querySelector('[aria-invalid="true"]')?.focus();
                return;
            }

            if (form.dataset.submitting === 'true') {
                event.preventDefault();
                return;
            }

            form.dataset.submitting = 'true';
            const button = form.querySelector('button[type="submit"]');
            if (button) {
                button.disabled = true;
                button.setAttribute('aria-busy', 'true');
                const label = button.querySelector('[data-submit-label]');
                const arrow = button.querySelector('[data-submit-arrow]');
                const spinner = button.querySelector('[data-loading-spinner]');
                if (label) label.textContent = 'Memproses...';
                arrow?.classList.add('hidden');
                spinner?.classList.remove('hidden');
            }
        });
    });
});
