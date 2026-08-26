<script>
    (function() {
        const savedTheme = localStorage.getItem('sirapi_theme');
        if (savedTheme === 'dark' || (!savedTheme && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    })();

    function toggleSirapiTheme() {
        const isDark = document.documentElement.classList.toggle('dark');
        const newTheme = isDark ? 'dark' : 'light';
        localStorage.setItem('sirapi_theme', newTheme);
        window.dispatchEvent(new CustomEvent('sirapi-theme-changed', { detail: { theme: newTheme } }));
        updateThemeIcons();
    }

    function updateThemeIcons() {
        const isDark = document.documentElement.classList.contains('dark');
        document.querySelectorAll('[data-theme-icon-light]').forEach(el => {
            el.classList.toggle('hidden', !isDark);
        });
        document.querySelectorAll('[data-theme-icon-dark]').forEach(el => {
            el.classList.toggle('hidden', isDark);
        });
    }
    document.addEventListener('DOMContentLoaded', updateThemeIcons);
</script>
