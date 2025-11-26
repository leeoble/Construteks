// Funcion de cambio de color de la barra de navegacion para CONSTRUTEKS

export function enableStickyNav() {
  const primaryHeader = document.querySelector('.primary-header');
  if (!primaryHeader) return; // buena práctica: evita errores si no existe

  const scrollWatcher = document.createElement('div');
  scrollWatcher.setAttribute('data-scroll-watcher', '');
  primaryHeader.before(scrollWatcher);

  const navObserver = new IntersectionObserver((entries) => {
    primaryHeader.classList.toggle('sticking', !entries[0].isIntersecting);
  });

  navObserver.observe(scrollWatcher);
  console.log("Sticky Cargado")
}