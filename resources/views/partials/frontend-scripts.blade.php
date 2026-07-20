@if (! file_exists(public_path('build/manifest.json')) && ! file_exists(public_path('hot')))
    <script>
        const openModal = (id) => {
            const modal = document.getElementById(id);
            if (!modal) return;
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        };

        const closeModal = (modal) => {
            if (!modal) return;
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        };

        document.addEventListener('click', (event) => {
            const openButton = event.target.closest('[data-modal-open]');
            if (openButton) {
                openModal(openButton.dataset.modalOpen);
                return;
            }

            const closeButton = event.target.closest('[data-modal-close]');
            if (closeButton) {
                closeModal(closeButton.closest('[data-modal]'));
                return;
            }

            if (event.target.matches('[data-modal]')) {
                closeModal(event.target);
            }

            const toggle = event.target.closest('[data-password-toggle]');
            if (toggle) {
                const input = document.getElementById(toggle.dataset.passwordToggle);
                if (input) input.type = input.type === 'password' ? 'text' : 'password';
            }
        });

        document.addEventListener('keydown', (event) => {
            if (event.key === 'Escape') {
                document.querySelectorAll('[data-modal]').forEach(closeModal);
            }
        });
    </script>
@endif
