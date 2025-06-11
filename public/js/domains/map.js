
const { formAction, csrfToken, defaultX, defaultY } = window.mapConfig;

function updateCoordinatesDisplay(x, y) {
    document.getElementById('cursor-coordinates').innerText = `X: ${x}, Y: ${y}`;
}

function redirectToLocation(locationId) {
    // Создаём форму для перехода
    const form = document.createElement('form');
    form.action = formAction;
    form.method = 'POST';

    // Добавляем скрытое поле с id локации
    const input = document.createElement('input');
    input.type = 'hidden';
    input.name = 'location_id';
    input.value = locationId;

    // Добавляем CSRF токен
    const csrfInput = document.createElement('input');
    csrfInput.type = 'hidden';
    csrfInput.name = '_token';
    csrfInput.value = csrfToken;

    form.appendChild(input);
    form.appendChild(csrfInput);

    // Отправляем форму
    document.body.appendChild(form);
    form.submit();
}

const svg = document.getElementById('map-svg');
const map = document.getElementById('map');
let scale = 1;
let panX = 0,
    panY = 0;
let isPanning = false;
let startX, startY;



window.addEventListener('load', () => {
    showCurrentLocation();
});

function showCurrentLocation() {
    resetZoom();
    const svgRect = svg.getBoundingClientRect();
    const centerX = svgRect.width / 2
    const centerY = svgRect.height / 2;

    panX = centerX - defaultX * scale;
    panY = centerY - defaultY * scale;

    map.setAttribute('transform', `translate(${panX}, ${panY}) scale(${scale})`);
}

function resetZoom() {
    const svgRect = svg.getBoundingClientRect();
    const centerX = svgRect.width / 2;
    const centerY = svgRect.height / 2;

    const pt = svg.createSVGPoint();
    pt.x = centerX;
    pt.y = centerY;

    const cursor = pt.matrixTransform(svg.getScreenCTM().inverse());

    // Центрировать на той же точке, но с масштабом 1
    scale = 1;
    panX = centerX - cursor.x * scale;
    panY = centerY - cursor.y * scale;

    map.setAttribute('transform', `translate(${panX}, ${panY}) scale(${scale})`);
}

function fitMapToView() {
    const bbox = map.getBBox(); // Получаем границы карты
    const svgRect = svg.getBoundingClientRect();

    const widthScale = svgRect.width / bbox.width;
    const heightScale = svgRect.height / bbox.height;
    scale = Math.min(widthScale, heightScale) * 0.9; // Немного уменьшаем, чтобы были отступы

    panX = (svgRect.width / 2) - (bbox.x + bbox.width / 2) * scale;
    panY = (svgRect.height / 2) - (bbox.y + bbox.height / 2) * scale;

    map.setAttribute('transform', `translate(${panX}, ${panY}) scale(${scale})`);
}

function openFullscreen() {
    const elem = document.getElementById('map-svg');
    if (elem.requestFullscreen) {
        elem.requestFullscreen();
    } else if (elem.webkitRequestFullscreen) { // для Safari
        elem.webkitRequestFullscreen();
    } else if (elem.msRequestFullscreen) { // для IE11
        elem.msRequestFullscreen();
    }
}

// Масштабирование с учётом позиции курсора
svg.addEventListener('wheel', function (e) {
    e.preventDefault();
    const zoom = e.deltaY < 0 ? 1.1 : 0.9;

    const pt = svg.createSVGPoint();
    pt.x = e.clientX;
    pt.y = e.clientY;

    const cursor = pt.matrixTransform(svg.getScreenCTM().inverse());

    panX = cursor.x - (cursor.x - panX) * zoom;
    panY = cursor.y - (cursor.y - panY) * zoom;

    scale *= zoom;

    map.setAttribute('transform', `translate(${panX}, ${panY}) scale(${scale})`);
});

// Панорамирование мышью
svg.addEventListener('mousedown', function (e) {
    isPanning = true;
    startX = e.clientX;
    startY = e.clientY;
});

svg.addEventListener('mousemove', function (e) {
    if (!isPanning) return;
    const dx = e.clientX - startX;
    const dy = e.clientY - startY;
    panX += dx;
    panY += dy;
    startX = e.clientX;
    startY = e.clientY;
    map.setAttribute('transform', `translate(${panX}, ${panY}) scale(${scale})`);
});

svg.addEventListener('mouseup', () => isPanning = false);
svg.addEventListener('mouseleave', () => isPanning = false);

svg.addEventListener('mousemove', function (e) {
    const pt = svg.createSVGPoint();
    pt.x = e.clientX;
    pt.y = e.clientY;
    const cursor = pt.matrixTransform(svg.getScreenCTM().inverse());

    const x = Math.round((cursor.x - panX) / scale);
    const y = Math.round((cursor.y - panY) / scale);

    updateCoordinatesDisplay(x, y);

    if (!isPanning) return;
    const dx = e.clientX - startX;
    const dy = e.clientY - startY;
    panX += dx;
    panY += dy;
    startX = e.clientX;
    startY = e.clientY;
    map.setAttribute('transform', `translate(${panX}, ${panY}) scale(${scale})`);
});
svg.addEventListener('mouseleave', () => {
    const el = document.getElementById('cursor-coordinates');
    updateCoordinatesDisplay(el.dataset.defaultX, el.dataset.defaultY);
});

window.addEventListener('DOMContentLoaded', () => {
    const el = document.getElementById('cursor-coordinates');
    updateCoordinatesDisplay(el.dataset.defaultX, el.dataset.defaultY);
});
