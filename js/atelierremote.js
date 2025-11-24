export function atelierremote(){

  // Espera a que el stylesheet remoto intente cargar
  const link = document.getElementById("atelierremote");

  link.addEventListener("error", () => {
    console.warn("⚠️ No se pudo cargar atelier-signature remoto. Cargando local…");

    const fallback = document.createElement("link");
    fallback.rel = "stylesheet";
    fallback.href = "/css/signature.css"; // tu ruta local
    document.head.appendChild(fallback);
  });

}