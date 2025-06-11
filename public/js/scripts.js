document.addEventListener('DOMContentLoaded', () => {
    // Создаём контейнер для тултипа
    const tooltip = document.createElement('div');
    tooltip.className = 'tooltip-bubble';
    document.body.appendChild(tooltip);

    document.querySelectorAll('[data-tooltip]').forEach(el => {
        let timeoutId;
        let lastEvent;

        // Функция показа тултипа
        const showTip = () => {
            tooltip.textContent = el.dataset.tooltip;
            tooltip.classList.add('visible');
            positionTooltip(lastEvent);
        };

        // Функция планирования появления
        const schedule = (e) => {
            lastEvent = e;
            clearTimeout(timeoutId);
            tooltip.classList.remove('visible');
            timeoutId = setTimeout(showTip, 500);
        };

        // Функция позиционирования тултипа
        const positionTooltip = (e) => {
            const margin = 15;
            const rect = tooltip.getBoundingClientRect();
            let x = e.clientX + margin;
            let y = e.clientY + margin;

            if (rect.width && x + rect.width > window.innerWidth) {
                x = e.clientX - rect.width - margin;
            }
            if (rect.height && y + rect.height > window.innerHeight) {
                y = e.clientY - rect.height - margin;
            }

            tooltip.style.left = `${x}px`;
            tooltip.style.top = `${y}px`;
        };

        el.addEventListener('mouseenter', schedule);
        el.addEventListener('mousemove', schedule);

        el.addEventListener('mouseleave', () => {
            clearTimeout(timeoutId);
            tooltip.classList.remove('visible');
        });
    });
});
