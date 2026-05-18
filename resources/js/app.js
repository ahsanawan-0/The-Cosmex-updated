const toggleDisplay = (element, show) => {
    if (!element) return;
    element.classList.toggle('hidden', !show);
};

const initSearchForms = () => {
    const forms = document.querySelectorAll('[data-search-form]');

    forms.forEach((form) => {
        const input = form.querySelector('[data-search-input]');
        const clearButton = form.querySelector('[data-search-clear]');
        if (!input) return;

        let debounceTimer;

        const updateClear = () => {
            if (clearButton) {
                toggleDisplay(clearButton, input.value.length > 0);
                if (input.value.length > 0) {
                    clearButton.classList.add('flex');
                } else {
                    clearButton.classList.remove('flex');
                }
            }
        };

        input.addEventListener('input', () => {
            updateClear();
            window.clearTimeout(debounceTimer);
            debounceTimer = window.setTimeout(() => {
                if (input.value.trim().length > 1 || input.value.trim().length === 0) {
                    form.requestSubmit();
                }
            }, 500);
        });

        input.addEventListener('keydown', (event) => {
            if (event.key === 'Enter') {
                event.preventDefault();
                form.requestSubmit();
            }
        });

        clearButton?.addEventListener('click', () => {
            input.value = '';
            updateClear();
            input.focus();
            form.requestSubmit();
        });

        updateClear();
    });
};

const initMobileMenu = () => {
    const toggle = document.querySelector('[data-mobile-menu-toggle]');
    const menu = document.querySelector('[data-mobile-menu]');
    const submenuToggles = document.querySelectorAll('[data-mobile-submenu-toggle]');

    toggle?.addEventListener('click', () => {
        const isHidden = menu?.classList.contains('hidden');
        toggleDisplay(menu, isHidden);
    });

    submenuToggles.forEach((button) => {
        button.addEventListener('click', () => {
            const key = button.getAttribute('data-mobile-submenu-toggle');
            const target = document.querySelector(`[data-mobile-submenu="${key}"]`);
            const marker = button.querySelector('span:last-child');
            const shouldOpen = target?.classList.contains('hidden');
            toggleDisplay(target, shouldOpen);
            if (marker) {
                marker.textContent = shouldOpen ? '−' : '+';
            }
        });
    });
};

document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('[data-cloak]').forEach((element) => {
        element.removeAttribute('data-cloak');
    });

    initSearchForms();
    initMobileMenu();
});
