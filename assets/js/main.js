document.addEventListener('DOMContentLoaded', () => {
  // Marcar activo en el navbar según URL
  const current = location.pathname + location.search;
  document.querySelectorAll('.navbar .nav-link').forEach(a => {
    if (a.getAttribute('href') && a.pathname === location.pathname) {
      a.classList.add('active');
    }
  });
});
