<script>
    document.addEventListener('click', function (event) {
        const openButton = event.target.closest('[data-modal-open]');
        if (openButton) {
            const modal = document.getElementById(openButton.dataset.modalOpen);
            modal?.classList.remove('hidden');
        }

        const closeButton = event.target.closest('[data-modal-close]');
        if (closeButton) {
            closeButton.closest('[data-modal]')?.classList.add('hidden');
        }
    });
</script>
