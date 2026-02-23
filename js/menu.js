/* =========================
	 ELEMENTOS DEL MODAL
========================= */
const modal = document.getElementById("productModal");
const modalImage = document.getElementById("modalImage");
const modalTitle = document.getElementById("modalTitle");
const modalDescription = document.getElementById("modalDescription");
const modalExtra = document.getElementById("modalExtra");
const modalPrice = document.getElementById("modalPrice");
const modalWhatsapp = document.getElementById("modalWhatsapp");
const closeModalBtn = document.getElementById("closeModal");

/* =========================
	 MODAL: ABRIR / CERRAR
========================= */
function openModal(item) {
	if (!modal) return;

	modal.classList.add("active");
	document.body.classList.add("modal-open");

	modalImage.src = item.image || "images/products/product-placeholder.svg";
	modalImage.alt = item.name;

	modalTitle.textContent = item.name;
	modalDescription.textContent = item.description || "";
	modalExtra.textContent = item.extra || "";
	modalPrice.textContent = item.price || "";

	const phone = window.SITE_CONFIG?.business?.phone || "";
	const message = `Hola 👋🏻, me interesa este producto: ${item.name}`;
	modalWhatsapp.href =
`https://wa.me/${phone}?text=` + encodeURIComponent(message);
}

function closeModal() {
	if (!modal) return;

	modal.classList.remove("active");
	document.body.classList.remove("modal-open");
}

/* =========================
	 EVENTOS DE CIERRE
========================= */
// Botón X
if (closeModalBtn) {
	closeModalBtn.addEventListener("click", closeModal);
}

// Click fuera del contenido
if (modal) {
	modal.addEventListener("click", e => {
		if (e.target === modal) {
			closeModal();
		}
	});
}

// Tecla ESC
document.addEventListener("keydown", e => {
	if (e.key === "Escape" && modal?.classList.contains("active")) {
		closeModal();
	}
});

/* =========================
	 TARJETA DE PRODUCTO
========================= */
function createCard(item) {
	const card = document.createElement("article");
	card.className = "menu-card";

	card.innerHTML = `
		<img src="${item.image || "images/products/product-placeholder.svg"}" alt="${item.name}">
		<h3>${item.name}</h3>
		<p>${item.description || ""}</p>
		<span>${item.price || ""}</span>
	`;

	card.addEventListener("click", () => openModal(item));
	return card;
}

/* =========================
	 RENDER DE MENÚ
========================= */
document.addEventListener("configLoaded", () => {
	const config = window.SITE_CONFIG;
	if (!config || !Array.isArray(config.products)) return;

	const featured = document.getElementById("featuredMenu");
	const catalog = document.getElementById("catalogMenu");

	if (featured) featured.innerHTML = "";
	if (catalog) catalog.innerHTML = "";

	config.products.forEach(item => {
		if (catalog) {
			catalog.appendChild(createCard(item));
		}

		if (item.featured && featured && featured.children.length < 3) {
			featured.appendChild(createCard(item));
		}
	});
});

/* =========================
	 MOSTRAR / OCULTAR CATÁLOGO
========================= */
const showCatalog = document.getElementById("showCatalog");
const catalogSection = document.getElementById("catalogo");

if (showCatalog && catalogSection) {
	showCatalog.addEventListener("click", e => {
		e.preventDefault();

		const isHidden = catalogSection.classList.contains("is-hidden");

		if (isHidden) {
			catalogSection.classList.remove("is-hidden");
			showCatalog.textContent = "Ocultar productos";

			catalogSection.scrollIntoView({
				behavior: "smooth",
				block: "start"
			});
		} else {
			catalogSection.classList.add("is-hidden");
			showCatalog.textContent = "Ver todos los productos";
		}
	});
}

function renderSocials(config) {
	const container = document.getElementById("social-links");
	if (!container) return;

	container.innerHTML = "";

	const socialIcons = {
		facebook: `<svg viewBox="0 0 24 24" fill="currentColor"><path d="M22 12a10 10 0 1 0-11.56 9.87v-6.99H8v-2.88h2.44V9.41c0-2.41 1.43-3.74 3.63-3.74 1.05 0 2.15.19 2.15.19v2.36h-1.21c-1.2 0-1.57.75-1.57 1.52v1.82H16.1l-.39 2.88h-2.27v6.99A10 10 0 0 0 22 12z"/></svg>`,
		instagram: `<svg viewBox="0 0 24 24" fill="currentColor"><path d="M7 2C4.24 2 2 4.24 2 7v10c0 2.76 2.24 5 5 5h10c2.76 0 5-2.24 5-5V7c0-2.76-2.24-5-5-5H7zm5 5.5A4.5 4.5 0 1 1 7.5 12 4.5 4.5 0 0 1 12 7.5zm5.25-1.75a1.25 1.25 0 1 1-1.25 1.25 1.25 1.25 0 0 1 1.25-1.25z"/></svg>`,
		whatsapp: `<svg viewBox="0 0 32 32" fill="currentColor"><path d="M16.001 3C8.82 3 3 8.82 3 16c0 2.82.92 5.43 2.48 7.55L4 29l5.63-1.45A12.94 12.94 0 0 0 16.001 29C23.18 29 29 23.18 29 16S23.18 3 16.001 3zm0 23.6c-2.29 0-4.53-.62-6.49-1.8l-.47-.28-3.34.86.89-3.26-.3-.5A10.57 10.57 0 0 1 5.4 16c0-5.85 4.76-10.6 10.6-10.6 5.85 0 10.6 4.75 10.6 10.6 0 5.84-4.75 10.6-10.6 10.6zm5.78-7.95c-.32-.16-1.9-.94-2.19-1.05-.29-.11-.5-.16-.71.16-.21.32-.81 1.05-.99 1.26-.18.21-.36.24-.68.08-.32-.16-1.34-.49-2.56-1.57-.95-.85-1.59-1.9-1.77-2.22-.18-.32-.02-.49.13-.65.13-.13.32-.34.47-.5.16-.16.21-.27.32-.45.11-.18.05-.34-.03-.5-.08-.16-.71-1.71-.97-2.34-.26-.62-.52-.54-.71-.55l-.6-.01c-.18 0-.5.06-.76.34-.26.29-1 1-1 2.45s1.03 2.85 1.18 3.05c.16.21 2.03 3.1 4.92 4.35.69.3 1.22.48 1.64.61.69.22 1.31.19 1.8.12.55-.08 1.9-.78 2.17-1.53.26-.75.26-1.39.18-1.53-.08-.14-.29-.22-.61-.38z"/></svg>`
	};

	const socialLabels = {
		facebook: "Facebook",
		instagram: "Instagram",
		whatsapp: "WhatsApp"
	};

	["facebook", "instagram", "whatsapp"].forEach(platform => {
		const url = config.social[platform];

		if (url && url.trim() !== "") {
			const a = document.createElement("a");

			a.href = url;
			a.target = "_blank";
			a.rel = "noopener noreferrer";
			a.classList.add("social-btn", `social-${platform}`);
			a.title = socialLabels[platform];
			a.setAttribute("aria-label", socialLabels[platform]);

			a.innerHTML = socialIcons[platform];

			container.appendChild(a);
		}
	});
}