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
