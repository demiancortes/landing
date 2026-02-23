var SITE_CONFIG = null;

document.addEventListener("DOMContentLoaded", function () {
	initGeneralSection();
	initProductModal();
});

/* =====================================================
   UTILIDADES GLOBALES
===================================================== */

function getCsrfToken() {
	var input = document.getElementById("csrfToken");
	return input ? input.value : "";
}

function appendCsrf(formData) {
	formData.append("csrf_token", getCsrfToken());
}

function showToast(type, message) {

	const toast = document.getElementById("adminToast");
	if (!toast) return;

	toast.className = "admin-toast " + type;
	toast.textContent = message;
	toast.classList.add("show");

	setTimeout(() => {
		toast.classList.remove("show");
	}, 3000);
}

function mapErrorMessage(type) {

	switch (type) {
	case "max_products":
		return "Has alcanzado el máximo de 21 productos.";
	case "max_featured":
		return "Solo puedes tener 3 productos destacados.";
	case "invalid_image_type":
		return "Formato de imagen inválido.";
	case "image_too_large":
		return "La imagen supera el límite permitido.";
	case "upload_failed":
		return "No se pudo subir la imagen.";
	case "invalid_token":
		return "Sesión inválida. Recarga la página.";
	default:
		return "Ocurrió un error inesperado.";
	}
}

async function handleRequest(fetchPromise, successMessage = null) {

	try {

		const response = await fetchPromise;

		if (!response.ok) throw new Error("Error de servidor");

		const data = await response.json();

		if (data.status === "success") {

			if (successMessage) showToast("success", successMessage);
			return data;

		} else {

			showToast("error", mapErrorMessage(data.type));
			return null;
		}

	} catch (error) {

		showToast("error", "Error de conexión o servidor.");
		return null;
	}
}

/* =====================================================
   GENERAL SECTION
===================================================== */

function initGeneralSection() {

	var saveBtn = document.getElementById("saveConfig");
	if (!saveBtn) return;

	loadConfig();
	saveBtn.addEventListener("click", saveConfig);

	var resetBtn = document.getElementById("resetTheme");
	if (resetBtn) {
		resetBtn.addEventListener("click", function () {

			const defaultTheme = {
				accentColor: "#25d366",
				accentColorHover: "#1fbf5a",
				footerBgColor: "#1e7f4f"
			};

			accentColor.value = defaultTheme.accentColor;
			accentColorHover.value = defaultTheme.accentColorHover;
			footerBgColor.value = defaultTheme.footerBgColor;

			if (SITE_CONFIG && SITE_CONFIG.theme) SITE_CONFIG.theme = defaultTheme;
		});
	}
}

function loadConfig() {

	fetch("editor.php?section=general&get_config=1")
	.then(res => res.json())
	.then(config => {

		SITE_CONFIG = config;

		if (businessName) businessName.value = config.business.name || "";
		if (businessPhone) businessPhone.value = config.business.phone || "";

		if (heroTitle) heroTitle.value = config.hero.title || "";
		if (heroSubtitle) heroSubtitle.value = config.hero.subtitle || "";

		if (ctaTitle) ctaTitle.value = config.cta.title || "";
		if (ctaButton) ctaButton.value = config.cta.buttonText || "";

		if (modalButtonText) modalButtonText.value = config.cta.modalButtonText || "";

		if (locationAddress) locationAddress.value = config.location.address || "";
		if (locationLat) locationLat.value = config.location.lat || "";
		if (locationLng) locationLng.value = config.location.lng || "";

		if (hoursWeek && config.hours[0]) hoursWeek.value = config.hours[0].time || "";
		if (hoursSat && config.hours[1]) hoursSat.value = config.hours[1].time || "";
		if (hoursSun && config.hours[2]) hoursSun.value = config.hours[2].time || "";

		if (benefit1) benefit1.value = config.benefits.items[0] || "";
		if (benefit2) benefit2.value = config.benefits.items[1] || "";
		if (benefit3) benefit3.value = config.benefits.items[2] || "";
		if (benefit4) benefit4.value = config.benefits.items[3] || "";

		if (accentColor) accentColor.value = config.theme.accentColor;
		if (accentColorHover) accentColorHover.value = config.theme.accentColorHover;
		if (footerBgColor) footerBgColor.value = config.theme.footerBgColor;

		if (seoCity && config.seo) seoCity.value = config.seo.city || "";
		if (seoDescription && config.seo) seoDescription.value = config.seo.metaDescription || "";
	});
}

async function saveConfig() {

	if (!SITE_CONFIG) return;

	SITE_CONFIG.business.name = businessName.value;
	SITE_CONFIG.business.phone = businessPhone.value;

	SITE_CONFIG.hero.title = heroTitle.value;
	SITE_CONFIG.hero.subtitle = heroSubtitle.value;

	SITE_CONFIG.cta.title = ctaTitle.value;
	SITE_CONFIG.cta.buttonText = ctaButton.value;
	SITE_CONFIG.cta.modalButtonText = modalButtonText.value;

	if (!SITE_CONFIG.seo) SITE_CONFIG.seo = {};

	SITE_CONFIG.seo.city = seoCity.value;
	SITE_CONFIG.seo.metaDescription = seoDescription.value;

	SITE_CONFIG.location.address = locationAddress.value;
	SITE_CONFIG.location.lat = parseFloat(locationLat.value);
	SITE_CONFIG.location.lng = parseFloat(locationLng.value);

	SITE_CONFIG.hours = [
		{ label: "Lunes a Viernes", time: hoursWeek.value },
		{ label: "Sábado", time: hoursSat.value },
		{ label: "Domingo", time: hoursSun.value }
	];

	SITE_CONFIG.benefits.items = [
		benefit1.value,
		benefit2.value,
		benefit3.value,
		benefit4.value
	];

	SITE_CONFIG.theme.accentColor = accentColor.value;
	SITE_CONFIG.theme.accentColorHover = accentColorHover.value;
	SITE_CONFIG.theme.footerBgColor = footerBgColor.value;

	var formData = new FormData();
	formData.append("save_general", "1");
	formData.append("config_json", JSON.stringify(SITE_CONFIG));
	appendCsrf(formData);

	var heroInput = document.getElementById("heroImage");
	if (heroInput && heroInput.files.length > 0) formData.append("hero_image", heroInput.files[0]);

	const result = await handleRequest(
		fetch("editor.php?section=general", { method: "POST", body: formData }),
		"Configuración guardada correctamente"
		);

	if (result) setTimeout(() => location.reload(), 1200);
}

/* =====================================================
   PRODUCT MODAL
===================================================== */

function initProductModal() {

	var modal = document.getElementById("productModal");
	if (!modal) return;

	var openBtn = document.getElementById("openModal");
	var closeBtn = document.getElementById("closeModal");

	if (openBtn) openBtn.addEventListener("click", function () { modal.classList.add("active"); });
	if (closeBtn) closeBtn.addEventListener("click", function () { modal.classList.remove("active"); });

	window.addEventListener("click", function (e) { if (e.target === modal) modal.classList.remove("active"); });

	var form = modal.querySelector("form");

	if (form) {
		form.addEventListener("submit", async function (e) {

			e.preventDefault();

			var formData = new FormData(form);
			appendCsrf(formData);

			const result = await handleRequest(
				fetch("editor.php?section=products", { method: "POST", body: formData }),
				"Producto guardado correctamente"
				);

			if (result) setTimeout(() => location.reload(), 1000);
		});
	}

	document.querySelectorAll(".delete-product-btn").forEach(btn => {
		btn.addEventListener("click", async function () {

			const productId = this.dataset.id;
			if (!confirm("¿Seguro que deseas eliminar este producto?")) return;

			var formData = new FormData();
			formData.append("delete_product_id", productId);
			appendCsrf(formData);

			const result = await handleRequest(
				fetch("editor.php?section=products", { method: "POST", body: formData }),
				"Producto eliminado correctamente"
				);

			if (result) setTimeout(() => location.reload(), 800);
		});
	});

	document.querySelectorAll(".btn-edit").forEach(btn => {
		btn.addEventListener("click", function () {

			const card = this.closest(".product-card");

			document.querySelector("#product_id").value = card.dataset.id;
			document.querySelector("#productName").value = card.dataset.name;
			document.querySelector("#productDescription").value = card.dataset.description;
			document.querySelector("#productExtra").value = card.dataset.extra;
			document.querySelector("#productPrice").value = card.dataset.price;
			document.querySelector("#productFeatured").checked = card.dataset.featured === "1";

			document.querySelector("#saveProductBtn").textContent = "Actualizar producto";
			modal.classList.add("active");
		});
	});
}
