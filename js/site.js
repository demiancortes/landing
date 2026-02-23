// js/site.js
document.addEventListener("configLoaded", () => {
	const config = window.SITE_CONFIG;

	if (!config) {
		console.warn("SITE_CONFIG no disponible");
		return;
	}

  /* =========================
	 HERO
  ========================= */
	if (config.hero) {
		const heroTitle = document.querySelector(".hero h1");
		const heroSubtitle = document.querySelector(".hero p");
		const imgHero = document.querySelector(".hero");

		if (heroTitle && config.hero.title) {
			heroTitle.textContent = config.hero.title;
		}

		if (heroSubtitle && config.hero.subtitle) {
			heroSubtitle.textContent = config.hero.subtitle;
		}

		if (config.hero && config.hero.image) {
			imgHero.style.backgroundImage =`linear-gradient(rgba(0,0,0,.5), rgba(0,0,0,.5)), url(${config.hero.image})`;
		}
	}

  /* =========================
	 WHATSAPP
  ========================= */
	if (config.business && config.business.phone) {
		const message = "Hola 👋🏻, quiero más información";
		const url = `https://wa.me/${config.business.phone}?text=${encodeURIComponent(message)}`;

		document.querySelectorAll(".btn-whatsapp").forEach(btn => {
			btn.href = url;
		});
	}

  /* =========================
	 THEME (COLORES)
  ========================= */
	if (config.theme) {
		const root = document.documentElement;
		const theme = config.theme;

		if (theme.accentColor) {
			root.style.setProperty("--accent-color", theme.accentColor);
		}

		if (theme.accentColorHover) {
			root.style.setProperty("--accent-color-hover", theme.accentColorHover);
		}

		if (theme.footerBgColor) {
			root.style.setProperty("--footer-bg-color", theme.footerBgColor);
		}
	}

	/* =========================
	TITLE + FOOTER
	========================= */
	if (config.business && config.business.name) {
		const year = new Date().getFullYear();

		// Title del navegador
		document.title = config.business.name;

		// Footer
		const footerName = document.getElementById("footerBusinessName");
		if (footerName) {
			footerName.textContent = `${config.business.name} © ${year}`;
		}
	}

	/* =========================
	SOCIAL LINKS
	========================= */
	if (config.social) {
		renderSocials(config);
	}

	/* =========================
   HORARIOS
	========================= */
	if (Array.isArray(config.hours)) {
		const hoursList = document.getElementById("hoursList");

		if (hoursList) {
			hoursList.innerHTML = "";

			config.hours.forEach(item => {
				const li = document.createElement("li");

				li.innerHTML = `
		<span>${item.label}</span>
		<strong>${item.time}</strong>
				`;

				hoursList.appendChild(li);
			});
		}
	}

	/* =========================
   BENEFICIOS
	========================= */
	if (config.benefits) {
		const title = document.getElementById("benefitsTitle");
		const list = document.getElementById("benefitsList");

		if (title && config.benefits.title) {
			title.textContent = config.benefits.title;
		}

		if (list && Array.isArray(config.benefits.items)) {
			list.innerHTML = "";

			config.benefits.items.forEach(text => {
				const li = document.createElement("li");
				li.textContent = `✔ ${text}`;
				list.appendChild(li);
			});
		}
	}

	/* =========================
   CTA
	========================= */
	if (config.cta) {
		const ctaTitle = document.getElementById("ctaTitle");
		const ctaButton = document.getElementById("whatsappCTA");
		const ctaButtonModal = document.getElementById("modalWhatsapp");

		if (ctaTitle && config.cta.title) {
			ctaTitle.textContent = config.cta.title;
		}

		if (ctaButton && config.cta.buttonText) {
			ctaButton.textContent = config.cta.buttonText;
		}

		if (config.cta && config.cta.modalButtonText) {
			ctaButtonModal.textContent = config.cta.modalButtonText;
		}

	}

	/* =========================
   	UBICACIÓN / MAPA
	========================= */
	if (config.location) {
		const addressEl = document.getElementById("businessAddress");
		const mapFrame = document.getElementById("mapFrame");
		const mapLink = document.getElementById("mapLink");

  		// Dirección visible
		if (addressEl && config.location.address) {
			addressEl.textContent = config.location.address;
		}

 		 // Mapa por coordenadas (NUNCA FALLA)
		if (mapFrame && config.location.lat && config.location.lng) {
			const src = `https://www.google.com/maps?q=${config.location.lat},${config.location.lng}&output=embed`;
			mapFrame.src = src;
		}

  		// Link externo
		if (mapLink && config.location.mapUrl) {
			mapLink.href = config.location.mapUrl;
		}
	}
});

/* =========================
   BACK TO TOP
========================= */
const backToTop = document.getElementById("backToTop");

if (backToTop) {
	window.addEventListener("scroll", () => {
		backToTop.classList.toggle("show", window.scrollY > 300);
	});

	backToTop.addEventListener("click", () => {
		window.scrollTo({ top: 0, behavior: "smooth" });
	});
}