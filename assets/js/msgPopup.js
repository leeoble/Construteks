// js/errorPopup.js

const mensajes = {
  request:     "Método de envío no permitido.",
  tipo:        "Por favor selecciona el tipo de proyecto.",
  dimensiones: "Describe mejor las dimensiones clave.",
  nota:        "Cuéntanos un poco más sobre el requerimiento especial.",

  // Contacto
  nombre:      "El nombre no puede estar vacío.",
  nombreMatch: "El nombre no puede contener caracteres extraños.",
  telefono:    "El teléfono debe contener al menos 10 dígitos.",
  correo:      "Por favor revisa el formato de correo electrónico.",

  // Estados del backend
  mailFail:    "No fue posible enviar tu información. Intenta nuevamente.",
  exito:       "¡Mensaje enviado correctamente! Gracias.",
  
  // Correo Largo
  correoLargo: "El correo no puede ser mayor de 120 caracteres",
  // Fallback
  otro:        "Ocurrió un error inesperado."
};

/**
 * Muestra el popup de error con el mensaje correspondiente al código.
 * @param {string} msgCode
 */
export function showMsgPopup(msgCode) {
  const popup = document.getElementById("popup-warning");
  const texto = document.getElementById("popup-warning-message");
  const boton = document.getElementById("popup-close-btn");

  if (!popup || !texto || !boton) {
    console.warn("Popup: elementos no encontrados en el DOM.");
    return;
  }

  const mensaje = mensajes[msgCode] || mensajes.otro;
  texto.textContent = mensaje;
  popup.style.display = "flex";

  // Prevenir listeners duplicados
  if (!boton.dataset.popupListener) {
    boton.addEventListener("click", () => {
      popup.style.display = "none";

      // Limpiar parámetros de la URL
      if (window.history && window.history.replaceState) {
        window.history.replaceState({}, document.title, window.location.pathname);
      }
    });
    boton.dataset.popupListener = "true";
  }
}

/**
 * Lee ?msg=... de la URL y, si existe, muestra el popup.
 */
export function initMsgPopupFromUrl() {
  const params = new URLSearchParams(window.location.search);
  const msgCode = params.get("msg");
  if (!msgCode) return;
  showErrorPopup(msgCode);
}
//DEBUG TEST
/*
document.addEventListener("DOMContentLoaded", () => {
  // Forzar un mensaje de prueba al cargar la página
  showMsgPopup("request");
});
*/