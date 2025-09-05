document.addEventListener('DOMContentLoaded', () => {
  // Marcar activo en el navbar según URL
  const current = location.pathname + location.search;
  document.querySelectorAll('.navbar .nav-link').forEach(a => {
    if (a.getAttribute('href') && a.pathname === location.pathname) {
      a.classList.add('active');
    }
  });
});
import { getJSON } from './api.js';

document.addEventListener('DOMContentLoaded', async () => {
  try {
    const data = await getJSON(window.APP.BASE_URL + '/data/departamentos.json');
    console.log('Departamentos cargados:', data);
  } catch (err) {
    console.error('Error cargando departamentos:', err);
  }
});
