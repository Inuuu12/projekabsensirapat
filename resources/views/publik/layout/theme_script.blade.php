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
<style>
    /* Global browser autofill fix for light & dark mode */
    input:-webkit-autofill,
    input:-webkit-autofill:hover,
    input:-webkit-autofill:focus,
    input:-webkit-autofill:active,
    textarea:-webkit-autofill,
    textarea:-webkit-autofill:hover,
    textarea:-webkit-autofill:focus,
    select:-webkit-autofill,
    select:-webkit-autofill:hover,
    select:-webkit-autofill:focus {
        -webkit-box-shadow: 0 0 0 1000px #ffffff inset !important;
        -webkit-text-fill-color: #1f2937 !important;
        caret-color: #1f2937 !important;
        transition: background-color 5000s ease-in-out 0s;
    }

    html.dark input:-webkit-autofill,
    html.dark input:-webkit-autofill:hover,
    html.dark input:-webkit-autofill:focus,
    html.dark input:-webkit-autofill:active,
    html.dark textarea:-webkit-autofill,
    html.dark textarea:-webkit-autofill:hover,
    html.dark textarea:-webkit-autofill:focus,
    html.dark select:-webkit-autofill,
    html.dark select:-webkit-autofill:hover,
    html.dark select:-webkit-autofill:focus,
    .dark input:-webkit-autofill,
    .dark input:-webkit-autofill:hover,
    .dark input:-webkit-autofill:focus,
    .dark input:-webkit-autofill:active,
    .dark textarea:-webkit-autofill,
    .dark textarea:-webkit-autofill:hover,
    .dark textarea:-webkit-autofill:focus,
    .dark select:-webkit-autofill,
    .dark select:-webkit-autofill:hover,
    .dark select:-webkit-autofill:focus {
        -webkit-box-shadow: 0 0 0 1000px #0f1c19 inset !important;
        -webkit-text-fill-color: #ffffff !important;
        caret-color: #ffffff !important;
        transition: background-color 5000s ease-in-out 0s;
    }

    html.dark {
        color-scheme: dark;
    }
    html:not(.dark) {
        color-scheme: light;
    }
</style>
