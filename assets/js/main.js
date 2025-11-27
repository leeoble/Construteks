/* 
  Scripts para CONSTRUTEKS MEXICO
*/

import { enableStickyNav } from "./stickyNav.js";
import { initMsgPopupFromUrl /*, showMsgPopup */ } from "./msgPopup.js";

document.addEventListener("DOMContentLoaded", () => {
  // Inicializa la navegación sticky
  enableStickyNav();

  // Muestra el popup si la URL trae ?error=...
  initMsgPopupFromUrl();
});
document.addEventListener("DOMContentLoaded", () => {
  const menuBtn   = document.querySelector(".menu-btn");
  const menuPanel = document.querySelector(".menuIsOpen");

  if (!menuBtn || !menuPanel) return;

  // Estado inicial seguro
  if (!menuBtn.classList.contains("active") && !menuBtn.classList.contains("not-active")) {
    menuBtn.classList.add("not-active");
  }

  // Accesibilidad básica
  menuBtn.setAttribute("role", "button");
  menuBtn.setAttribute("aria-expanded", "false");
  menuBtn.setAttribute("aria-label", "Abrir menú de navegación");

  const openMenu = () => {
    menuBtn.classList.remove("not-active");
    menuBtn.classList.add("active");

    menuPanel.classList.remove("hidden");
    document.body.classList.add("nav-open");

    menuBtn.setAttribute("aria-expanded", "true");
    menuBtn.setAttribute("aria-label", "Cerrar menú de navegación");
  };

  const closeMenu = () => {
    menuBtn.classList.remove("active");
    menuBtn.classList.add("not-active");

    menuPanel.classList.add("hidden");
    document.body.classList.remove("nav-open");

    menuBtn.setAttribute("aria-expanded", "false");
    menuBtn.setAttribute("aria-label", "Abrir menú de navegación");
  };

  const toggleMenu = () => {
    const isOpen = !menuPanel.classList.contains("hidden");
    if (isOpen) {
      closeMenu();
    } else {
      openMenu();
    }
  };

  // Click en la hamburguesa
  menuBtn.addEventListener("click", (event) => {
    event.stopPropagation(); // que no dispare el “click fuera”
    toggleMenu();
  });

  // Cerrar al hacer click fuera del panel
  document.addEventListener("click", (event) => {
    const isClickInsidePanel = menuPanel.contains(event.target);
    const isClickOnButton    = menuBtn.contains(event.target);

    if (!isClickInsidePanel && !isClickOnButton) {
      // solo cerramos si está abierto
      if (!menuPanel.classList.contains("hidden")) {
        closeMenu();
      }
    }
  });

  // Cerrar al hacer click en un link dentro del mega menú
  menuPanel.addEventListener("click", (event) => {
    const target = event.target;
    if (target.tagName === "A") {
      closeMenu();
    }
  });

  // (Opcional) cerrar con tecla ESC
  document.addEventListener("keydown", (event) => {
    if (event.key === "Escape" && !menuPanel.classList.contains("hidden")) {
      closeMenu();
    }
  });
});
