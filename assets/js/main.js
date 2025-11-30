/* 
  Scripts para CONSTRUTEKS MEXICO
*/

import { enableStickyNav } from "./stickyNav.js";
import { initMsgPopupFromUrl /*, showMsgPopup */ } from "./msgPopup.js";

document.addEventListener("DOMContentLoaded", () => {
  // 1) Inicializa navegación sticky y popups
  enableStickyNav();
  initMsgPopupFromUrl();

  // 2) Inicializa navegación principal (mobile + desktop trigger)
  initMainMenu();

  // 3) Sello de tiempo en el formulario
  stampFormTimestamp();
});

function initMainMenu() {
  const menuBtn     = document.querySelector(".menu-btn");       // hamburguesa (mobile)
  const menuBtnDesk = document.querySelector("#menu-btn-desk");  // trigger desktop (<a>)
  const menuPanel   = document.querySelector(".menuIsOpen");     // mega-menú / panel

  // Obligatorios: botón mobile + panel
  if (!menuBtn || !menuPanel) return;

  // Dejamos que CSS controle visibilidad (opacity / transform / pointer-events)
  // HTML puede traer "hidden" como fallback si no carga JS; aquí lo quitamos.
  // menuPanel.classList.remove("hidden");
  menuPanel.setAttribute("aria-hidden", "true");

  // Estado inicial seguro del ícono hamburguesa
  if (
    !menuBtn.classList.contains("active") &&
    !menuBtn.classList.contains("not-active")
  ) {
    menuBtn.classList.add("not-active");
  }

  // Accesibilidad básica para la hamburguesa
  menuBtn.setAttribute("role", "button");
  menuBtn.setAttribute("aria-expanded", "false");
  menuBtn.setAttribute("aria-label", "Abrir menú de navegación");

  // Si existe el trigger de escritorio, seteamos estado inicial
  if (menuBtnDesk) {
    menuBtnDesk.setAttribute("role", "button");
    menuBtnDesk.setAttribute("aria-haspopup", "true");
    menuBtnDesk.setAttribute("aria-expanded", "false");
    // aria-controls ya lo pusiste en el HTML
  }

  const openMenu = () => {
    menuBtn.classList.remove("not-active");
    menuBtn.classList.add("active");

    menuPanel.classList.add("is-open");        // 👈 aquí entra la animación CSS
    document.body.classList.add("nav-open");

    menuBtn.setAttribute("aria-expanded", "true");
    menuBtn.setAttribute("aria-label", "Cerrar menú de navegación");

    if (menuBtnDesk) {
      menuBtnDesk.setAttribute("aria-expanded", "true");
    }

    menuPanel.setAttribute("aria-hidden", "false");
  };

  const closeMenu = () => {
    menuBtn.classList.remove("active");
    menuBtn.classList.add("not-active");

    menuPanel.classList.remove("is-open");     // 👈 aquí se dispara el fade-out
    document.body.classList.remove("nav-open");

    menuBtn.setAttribute("aria-expanded", "false");
    menuBtn.setAttribute("aria-label", "Abrir menú de navegación");

    if (menuBtnDesk) {
      menuBtnDesk.setAttribute("aria-expanded", "false");
    }

    menuPanel.setAttribute("aria-hidden", "true");
  };

  const isOpen = () => menuPanel.classList.contains("is-open");

  const toggleMenu = () => {
    if (isOpen()) {
      closeMenu();
    } else {
      openMenu();
    }
  };

  // --- Eventos ---

  // Click en la hamburguesa (mobile)
  menuBtn.addEventListener("click", (event) => {
    event.stopPropagation(); // que no dispare el “click fuera”
    toggleMenu();
  });

  // Click en el trigger de escritorio (si existe)
  if (menuBtnDesk) {
    menuBtnDesk.addEventListener("click", (event) => {
      event.stopPropagation();
      event.preventDefault(); // evita el salto a #
      toggleMenu();
    });

    // Abrir/cerrar con Enter o Space
    menuBtnDesk.addEventListener("keydown", (event) => {
      if (event.key === "Enter" || event.key === " ") {
        event.preventDefault();
        toggleMenu();
      }
    });
  }

  // Cerrar al hacer click fuera del panel
  document.addEventListener("click", (event) => {
    const target = event.target;

    const isClickInsidePanel = menuPanel.contains(target);
    const isClickOnMobileBtn = menuBtn.contains(target);
    const isClickOnDeskBtn   = menuBtnDesk && menuBtnDesk.contains(target);

    if (!isClickInsidePanel && !isClickOnMobileBtn && !isClickOnDeskBtn) {
      if (isOpen()) {
        closeMenu();
      }
    }
  });

  // Cerrar al hacer click en un link dentro del mega-menú
  menuPanel.addEventListener("click", (event) => {
    const target = event.target;
    if (target.tagName === "A") {
      closeMenu();
    }
  });

  // Cerrar con tecla ESC
  document.addEventListener("keydown", (event) => {
    if (event.key === "Escape" && isOpen()) {
      closeMenu();
    }
  });
}

function stampFormTimestamp() {
  const form = document.querySelector(".project-share-form");
  if (!form) return;

  const tsInput = form.querySelector("#form_ts");
  if (!tsInput) return;

  const setTs = () => {
    tsInput.value = Date.now().toString();
  };

  setTs();
  form.addEventListener("submit", setTs);
}
