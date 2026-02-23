<?php
if (!defined('ADMIN_INTERNAL_ACCESS')) { header("Location: ../index.php"); exit; }
?>

<h2>Productos</h2>
<span class="admin-help">
	Administra los productos que aparecen en tu sitio.
	Máximo 21 productos y hasta 3 destacados.
</span>

<div class="products-actions">
	<button type="button" class="btn-admin" id="openModal">
		+ Agregar producto
	</button>
</div>

<div class="products-grid" id="productsContainer">

<?php if (count($products) > 0): ?>

<?php foreach ($products as $product): ?>

	<div class="product-card"
		data-id="<?php echo htmlspecialchars($product['id']); ?>"
		data-name="<?php echo htmlspecialchars($product['name']); ?>"
		data-description="<?php echo htmlspecialchars($product['description']); ?>"
		data-extra="<?php echo htmlspecialchars($product['extra']); ?>"
		data-price="<?php echo htmlspecialchars($product['price']); ?>"
		data-featured="<?php echo !empty($product['featured']) ? '1' : '0'; ?>"
		data-image="<?php echo htmlspecialchars($product['image']); ?>"
	>

		<?php if (!empty($product['image'])): ?>
			<img src="../<?php echo htmlspecialchars($product['image']); ?>" alt="">
		<?php endif; ?>

		<h3><?php echo htmlspecialchars($product['name']); ?></h3>

		<?php if (!empty($product['description'])): ?>
			<p><?php echo htmlspecialchars($product['description']); ?></p>
		<?php endif; ?>

		<?php if (!empty($product['price'])): ?>
			<div class="product-price">
				<?php echo htmlspecialchars($product['price']); ?>
			</div>
		<?php endif; ?>

		<?php if (!empty($product['featured'])): ?>
			<span class="product-badge">Destacado</span>
		<?php endif; ?>

		<div class="product-actions">

			<button class="btn-small btn-edit">
				Editar
			</button>

			<button 
				class="btn-small btn-delete delete-product-btn"
				data-id="<?php echo htmlspecialchars($product['id']); ?>">
				Eliminar
			</button>

		</div>

	</div>

<?php endforeach; ?>

<?php else: ?>

	<div class="product-placeholder">
		Aún no hay productos registrados.
	</div>

<?php endif; ?>

</div>



<!-- =========================
     MODAL PRODUCTO
========================= -->

<div class="modal-overlay" id="productModal">

	<div class="modal-content">

		<h2 id="modalTitle">Nuevo producto</h2>

		<span class="admin-help">
			Completa la información del producto. El ID se genera automáticamente.
		</span>

		<form method="POST" enctype="multipart/form-data">

			<input type="hidden" name="product_id" id="product_id">
			<input type="hidden" name="create_product" value="1">

			<div class="admin-group">
				<label>Nombre del producto</label>
				<span class="field-help">
					Es el nombre que aparecerá en la tarjeta del producto.
				</span>
				<input type="text" name="name" id="productName" required>
			</div>

			<div class="admin-group">
				<label>Descripción</label>
				<span class="field-help">
					Breve descripción visible debajo del nombre.
				</span>
				<input type="text" name="description" id="productDescription">
			</div>

			<div class="admin-group">
				<label>Información extra (opcional)</label>
				<span class="field-help">
					Detalle adicional que complemente el producto.
				</span>
				<input type="text" name="extra" id="productExtra">
			</div>

			<div class="admin-group">
				<label>Precio (opcional)</label>
				<span class="field-help">
					Puedes dejarlo vacío si no deseas mostrar precio.
				</span>
				<input type="text" name="price" id="productPrice">
			</div>

			<div class="admin-group">
				<label>Imagen del producto</label>
				<span class="field-help">
					Formatos permitidos: JPG o PNG. Máximo 2MB.
				</span>
				<input type="file" name="image" accept=".jpg,.jpeg,.png">
			</div>

			<div class="admin-group">
				<label>
					<input type="checkbox" name="featured" id="productFeatured">
					Producto destacado (máximo 3)
				</label>
				<span class="field-help">
					Los productos destacados aparecen en la sección principal.
				</span>
			</div>

			<div class="modal-actions">

				<button type="button" class="btn-ghost" id="closeModal">
					Cancelar
				</button>

				<button type="submit" class="btn-admin" id="saveProductBtn">
					Crear producto
				</button>

			</div>

		</form>

	</div>

</div>
