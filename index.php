<?php require_once __DIR__ . '/includes/config-loader.php'; ?>
<!DOCTYPE html>
<html lang="es-MX">
<head>

	<!-- Google Tag Manager --><script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src='https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);})(window,document,'script','dataLayer','GTM-PPCCWVST');</script><!-- End Google Tag Manager -->


	<meta charset="UTF-8" />

	<?php require_once __DIR__ . '/includes/head.php'; ?>
	<?php require_once __DIR__ . '/includes/schema.php'; ?>

	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="alternate icon" href="images/ui/logo.svg">
	<meta name="robots" content="index, follow">

	<link rel="canonical" href="https://persianasvizual.com/">
	<link rel="stylesheet" href="css/styles.css">
</head>

<body id="top">
	<!-- Google Tag Manager (noscript) -->
	<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-PPCCWVST" height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
	<!-- End Google Tag Manager (noscript) -->
	<main>
		<h1 style="position:absolute; left:-9999px;">
			Persianas en Mazatlán a la medida
		</h1>

		<header class="site-header">
			<div class="header-container">
				<a href="#top" class="logo">
					<img src="images/ui/logo_header.svg" alt="Persianas Vizual - Instalación de Persianas en Mazatlán">
				</a>
			</div>
		</header>


		<!-- HERO -->
		<section class="hero ">
			<div class="hero-content">
				<h1></h1>
				<p></p>
				<a id="whatsappHero" class="btn btn-whatsapp" target="_blank">Contáctanos</a>
			</div>
		</section>

		<!-- MENÚ DESTACADO -->
		<section class="menu">
			<h2>Productos Destacados</h2>

			<div class="menu-slider" id="featuredMenu"></div>

			<div class="menu-more">
				<a href="#catalogo" id="showCatalog" class="btn btn-secondary">
					Ver todos los productos
				</a>
			</div>
		</section>

		<!-- CATÁLOGO COMPLETO (OCULTO) -->
		<section class="catalog is-hidden" id="catalogo">
			<h2>Todos nuestros productos</h2>
			<div class="catalog-grid" id="catalogMenu"></div>
		</section>

		<!-- BENEFICIOS -->
		<section class="benefits">
			<h2 id="benefitsTitle"></h2>
			<ul id="benefitsList"></ul>
		</section>

		<!-- HORARIOS -->
		<section class="hours">
			<h2>🕒 Horarios de atención</h2>
			<ul class="hours-list" id="hoursList"></ul>
		</section>

		<!-- MAPA -->
		<section class="map">
			<h2>📍 Visítanos</h2>
			<p id="businessAddress"></p>
			<div class="map-responsive">
				<iframe id="mapFrame" title="Ubicación de Persianas Vizual en Mazatlán" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
			</div>
		</section>

		<!-- CTA -->
		<section class="cta">
			<h2 id="ctaTitle"></h2>
			<a id="whatsappCTA" class="btn btn-whatsapp large" target="_blank"></a>
		</section>
	</main>

	<!-- FOOTER -->
	<footer class="footer">
		<p id="footerBusinessName"></p>
		<div id="social-links" class="social-container"></div>
	</footer>

	<!-- MODAL PRODUCTO -->
	<div class="product-modal" id="productModal">
		<div class="modal-content">
			<button class="modal-close" id="closeModal">✕</button>
			<img id="modalImage" alt="">
			<h3 id="modalTitle"></h3>
			<p id="modalDescription"></p>
			<p id="modalExtra" class="modal-extra"></p>
			<span id="modalPrice"></span>
			<a id="modalWhatsapp" class="btn btn-whatsapp large" target="_blank"></a>
		</div>
	</div>

	<!-- WHATSAPP FLOTANTE -->
	<a id="whatsappFloat" class="whatsapp-float" rel="noopener noreferrer" aria-label="Enviar mensaje por WhatsApp" href="https://wa.me/526691632351?text=Hola%20%F0%9F%91%8B%F0%9F%8F%BB%2C%20quiero%20m%C3%A1s%20informaci%C3%B3n" target="_blank" >
		<svg xmlns="http://www.w3.org/2000/svg"viewBox="0 0 24 24" aria-hidden="true" >
			<path fill="currentColor" d="M12 2a10 10 0 0 0-8.66 15l-1.34 4.9 5.02-1.32A10 10 0 1 0 12 2zm0 18.2a8.2 8.2 0 0 1-4.18-1.15l-.3-.18-2.98.78.8-2.9-.2-.31A8.2 8.2 0 1 1 12 20.2zm4.53-6.15c-.25-.13-1.47-.72-1.7-.8-.23-.09-.4-.13-.57.13-.17.25-.65.8-.8.96-.15.17-.3.19-.55.06-.25-.13-1.05-.39-2-1.25-.74-.66-1.24-1.47-1.39-1.72-.14-.25-.01-.38.11-.5.11-.11.25-.28.38-.42.13-.14.17-.25.25-.41.08-.16.04-.31-.02-.42-.06-.12-.57-1.38-.78-1.9-.2-.5-.4-.42-.55-.43h-.47c-.16 0-.42.06-.64.31-.22.25-.84.82-.84 2s.86 2.32.98 2.48c.12.16 1.69 2.58 4.1 3.62.57.25 1.01.4 1.35.51.58.18 1.11.15 1.53.09.47-.07 1.47-.6 1.68-1.2.21-.6.21-1.1.15-1.2-.06-.1-.23-.16-.48-.28z"/>
		</svg>
	</a>
	<button id="backToTop" class="back-to-top" aria-label="Volver arriba">↑</button>

	<!-- SCRIPTS -->
	<script src="js/config.js"></script>
	<script src="js/site.js"></script>
	<script src="js/menu.js"></script>

	<script>
		const sections = document.querySelectorAll("section");

		const observer = new IntersectionObserver(entries => {
			entries.forEach(entry => {
				if (entry.isIntersecting) {
					entry.target.classList.add("visible");
					observer.unobserve(entry.target);
				}
			});
		}, {
			threshold: 0.2
		});

		sections.forEach(section => {
			observer.observe(section);
		});
	</script>
</body>
</html>