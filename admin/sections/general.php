<?php
if (!defined('ADMIN_INTERNAL_ACCESS')) { header("Location: ../index.php"); exit; }
?>

<!-- ================= NEGOCIO ================= -->
<h2>Nombre del negocio</h2>
<span class="admin-help">
	Este nombre aparecerá en la parte superior del sitio y en el título del navegador.
</span>

<div class="admin-group">
	<label>Nombre del negocio</label>
	<input id="businessName" type="text">
</div>

<div class="admin-group">
	<label>Número de WhatsApp</label>
	<input id="businessPhone" type="text">
</div>

<!-- ================= SECCIÓN PRINCIPAL ================= -->
<h2>Sección principal</h2>
<span class="admin-help">
	Es el mensaje principal que las personas ven al entrar a tu página.
</span>

<div class="admin-group">
	<label>Título principal</label>
	<input id="heroTitle" type="text">
</div>

<div class="admin-group">
	<label>Texto secundario</label>
	<input id="heroSubtitle" type="text">
</div>

<div class="admin-group">
	<label>Imagen principal (Hero)</label>
	<span class="admin-help">
		Formato JPG o PNG. Recomendado horizontal. Máx 3MB.
	</span>
	<input type="file" id="heroImage" name="hero_image" accept=".jpg,.jpeg,.png">
</div>


<!-- ================= SECCIÓN FINAL ================= -->
<h2>Sección de contacto final</h2>
<span class="admin-help">
	Es el mensaje que aparece al final de la página invitando al cliente a contactarte.
</span>

<div class="admin-group">
	<label>Título</label>
	<input id="ctaTitle" type="text">
</div>

<div class="admin-group">
	<label>Texto del botón</label>
	<input id="ctaButton" type="text">
</div>

<!-- ================= MODAL PRODUCTOS ================= -->
<h2>Modal de productos</h2>
<span class="admin-help">
	Este texto aparecerá en el botón del detalle de cada producto.
</span>

<div class="admin-group">
	<label>Texto del botón del modal</label>
	<input id="modalButtonText" type="text">
</div>

<!-- ================= SEO ================= -->
<h2>SEO</h2>
<span class="admin-help">
Optimiza cómo aparece tu sitio en Google y redes sociales.
</span>

<div class="admin-group">
	<label>Ciudad principal</label>
	<span class="field-help">
		Se usará en el título del sitio (Ej: Mazatlán).
	</span>
	<input id="seoCity" type="text">
</div>

<div class="admin-group">
	<label>Meta descripción</label>
	<span class="field-help">
		Texto que aparece en Google. Máximo recomendado 160 caracteres.
	</span>
	<input id="seoDescription" type="text" maxlength="160">
</div>

<!-- ================= UBICACIÓN ================= -->
<h2>Ubicación</h2>
<span class="admin-help">
	Estos datos permiten mostrar automáticamente el mapa en tu sitio.
</span>

<div class="admin-group">
	<label>Dirección</label>
	<input id="locationAddress" type="text">
</div>

<div class="admin-group">
	<label>Latitud</label>
	<input id="locationLat" type="text">
</div>

<div class="admin-group">
	<label>Longitud</label>
	<input id="locationLng" type="text">
</div>

<!-- ================= HORARIOS ================= -->
<h2>Horarios de atención</h2>
<span class="admin-help">
	Define los días y horarios en los que atiendes a tus clientes.
</span>

<div class="admin-group">
	<label>Lunes a Viernes</label>
	<input id="hoursWeek" type="text">
</div>

<div class="admin-group">
	<label>Sábado</label>
	<input id="hoursSat" type="text">
</div>

<div class="admin-group">
	<label>Domingo</label>
	<input id="hoursSun" type="text">
</div>

<!-- ================= BENEFICIOS ================= -->
<h2>Puntos destacados</h2>
<span class="admin-help">
	Son las razones por las que las personas deberían elegir tu negocio.
</span>

<div class="admin-group"><input id="benefit1" type="text" placeholder="Ej: Atención rápida"></div>
<div class="admin-group"><input id="benefit2" type="text"></div>
<div class="admin-group"><input id="benefit3" type="text"></div>
<div class="admin-group"><input id="benefit4" type="text"></div>

<!-- ================= COLORES ================= -->
<div class="admin-section">
	<h2>Estilos del sitio</h2>
	<span class="admin-help">
		Personaliza los colores principales que se aplican en botones y pie de página.
	</span>

	<div class="admin-group admin-color">
		<label for="accentColor">Color principal</label>
		<input id="accentColor" type="color">
	</div>

	<div class="admin-group admin-color">
		<label for="accentColorHover">Color al pasar el cursor</label>
		<input id="accentColorHover" type="color">
	</div>

	<div class="admin-group admin-color">
		<label for="footerBgColor">Color del pie de página</label>
		<input id="footerBgColor" type="color">
	</div>

	<div class="admin-reset-wrapper">
		<button type="button" id="resetTheme" class="btn-admin btn-ghost">
			Restablecer estilos predeterminados
		</button>
	</div>
</div>

<div class="admin-actions">
	<button id="saveConfig" class="btn-admin">
		Guardar cambios
	</button>
</div>
