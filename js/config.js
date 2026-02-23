// js/config.js
window.SITE_CONFIG = null;

fetch("api/get-config.php")
  .then(res => {
    if (!res.ok) throw new Error("No se pudo cargar config.json");
    return res.json();
  })
  .then(config => {
    if (!config) throw new Error("Config vacío");
    window.SITE_CONFIG = config;
    document.dispatchEvent(new Event("configLoaded"));
  })
  .catch(err => {
    console.error("Error cargando config.json", err);
  });
