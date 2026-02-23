<?php
session_start();
ini_set('display_errors', 0);
ini_set('log_errors', 1);
ini_set('error_log', __DIR__ . '/../logs/php_errors.log');
error_reporting(E_ALL);

define('ADMIN_INTERNAL_ACCESS', true);

require_once __DIR__ . '/lib/ImageProcessor.php';

if (!isset($_SESSION["admin_logged"]) || $_SESSION["admin_logged"] !== true) { header("Location: index.php"); exit; }

if (!isset($_SESSION['csrf_token'])) $_SESSION['csrf_token'] = bin2hex(openssl_random_pseudo_bytes(32));

$section = isset($_GET['section']) ? $_GET['section'] : 'general';
$configPath = __DIR__ . '/../data/config.json';

/* =====================================================
   UTILIDADES
===================================================== */

function getConfigData($path) {
	if (!file_exists($path)) return array();
	$json = file_get_contents($path);
	$data = json_decode($json, true);
	return $data ? $data : array();
}

function saveConfigData($path, $data) {
	$json = json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
	file_put_contents($path, $json);
}

function jsonResponse($status, $type = null) {
	header('Content-Type: application/json');
	$response = array('status' => $status);
	if ($type !== null) $response['type'] = $type;
	echo json_encode($response);
	exit;
}

function validateCsrf() {
	if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) jsonResponse('error', 'invalid_token');
}

function generateNextProductId($products) {
	$max = 0;
	foreach ($products as $product) if (isset($product['id'])) { $num = intval(str_replace('prod-', '', $product['id'])); if ($num > $max) $max = $num; }
	$next = $max + 1;
	return 'prod-' . str_pad($next, 3, '0', STR_PAD_LEFT);
}

$configData = getConfigData($configPath);
if (!isset($configData['products'])) $configData['products'] = array();

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['get_config'])) {

	header('Content-Type: application/json');
	echo json_encode($configData);
	exit;
}


/* =====================================================
   GUARDAR CONFIGURACIÓN GENERAL (AJAX)
===================================================== */

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['save_general'])) {

	validateCsrf();

	$newConfig = json_decode($_POST['config_json'], true);
	if (!$newConfig) jsonResponse('error');

	$configData = $newConfig;

	if (!empty($_FILES['hero_image']['name'])) {

		$uploadDir = __DIR__ . '/../images/uploads/hero';
		$fileName = processImageUpload($_FILES['hero_image'], $uploadDir, 1600, 82);

		if (!$fileName) jsonResponse('error', 'invalid_image_type');

		if (!empty($configData['hero']['image']) && strpos($configData['hero']['image'], 'images/uploads/hero/') === 0) {
			$oldPath = __DIR__ . '/../' . $configData['hero']['image'];
			if (file_exists($oldPath)) unlink($oldPath);
		}

		$configData['hero']['image'] = 'images/uploads/hero/' . $fileName;
	}

	saveConfigData($configPath, $configData);
	jsonResponse('success');
}

/* =====================================================
   ELIMINAR PRODUCTO
===================================================== */

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_product_id'])) {

	validateCsrf();

	$deleteId = $_POST['delete_product_id'];

	foreach ($configData['products'] as $key => $product) {

		if ($product['id'] === $deleteId) {

			if (!empty($product['image']) && strpos($product['image'], 'images/uploads/products/') === 0) {
				$oldPath = __DIR__ . '/../' . $product['image'];
				if (file_exists($oldPath)) unlink($oldPath);
			}

			unset($configData['products'][$key]);
			break;
		}
	}

	$configData['products'] = array_values($configData['products']);
	saveConfigData($configPath, $configData);

	jsonResponse('success');
}

/* =====================================================
   CREAR / EDITAR PRODUCTO (AJAX)
===================================================== */

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['create_product'])) {

	validateCsrf();

	$isEdit = !empty($_POST['product_id']);
	$products = $configData['products'];

	if (!$isEdit && count($products) >= 21) jsonResponse('error', 'max_products');

	$featuredCount = 0;
	foreach ($products as $p) if (!empty($p['featured'])) $featuredCount++;

	$isFeatured = isset($_POST['featured']);

	if ($isFeatured && !$isEdit && $featuredCount >= 3) jsonResponse('error', 'max_featured');

	if ($isEdit) {

		foreach ($configData['products'] as &$product) {

			if ($product['id'] === $_POST['product_id']) {

				$product['name'] = trim($_POST['name']);
				$product['description'] = trim($_POST['description']);
				$product['extra'] = trim($_POST['extra']);
				$product['price'] = trim($_POST['price']);

				if ($isFeatured && empty($product['featured']) && $featuredCount >= 3) jsonResponse('error', 'max_featured');

				$product['featured'] = $isFeatured;

				if (!empty($_FILES['image']['name'])) {

					$uploadDir = __DIR__ . '/../images/uploads/products';
					$fileName = processImageUpload($_FILES['image'], $uploadDir, 1200, 80);

					if (!$fileName) jsonResponse('error', 'invalid_image_type');

					if (!empty($product['image']) && strpos($product['image'], 'images/uploads/products/') === 0) {
						$oldPath = __DIR__ . '/../' . $product['image'];
						if (file_exists($oldPath)) unlink($oldPath);
					}

					$product['image'] = 'images/uploads/products/' . $fileName;
				}

				break;
			}
		}

		saveConfigData($configPath, $configData);
		jsonResponse('success');
	}

	$imagePath = 'images/products/product-placeholder.svg';

	if (!empty($_FILES['image']['name'])) {
		$uploadDir = __DIR__ . '/../images/uploads/products';
		$fileName = processImageUpload($_FILES['image'], $uploadDir, 1200, 80);
		if (!$fileName) jsonResponse('error', 'invalid_image_type');
		$imagePath = 'images/uploads/products/' . $fileName;
	}

	$newProduct = array(
		'id' => generateNextProductId($products),
		'name' => trim($_POST['name']),
		'description' => trim($_POST['description']),
		'extra' => trim($_POST['extra']),
		'price' => trim($_POST['price']),
		'image' => $imagePath,
		'featured' => $isFeatured
	);

	$configData['products'][] = $newProduct;
	saveConfigData($configPath, $configData);

	jsonResponse('success');
}

/* =====================================================
   CARGAR VISTA
===================================================== */

$products = $configData['products'];
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Editor del sitio</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="alternate icon" href="../images/ui/logo.svg">

<link rel="stylesheet" href="css/admin.css">
</head>
<body>

<div class="admin-wrapper">

<div class="admin-header">
<h1>Panel de configuración</h1>
<div class="admin-header-right">
<a href="logout.php" class="admin-logout">Cerrar sesión</a>
</div>
</div>

<div class="admin-tabs">
<a href="editor.php?section=general" class="admin-tab <?php echo $section === 'general' ? 'active' : ''; ?>">Configuración</a>
<a href="editor.php?section=products" class="admin-tab <?php echo $section === 'products' ? 'active' : ''; ?>">Productos</a>
</div>

<?php
if ($section === 'products') include __DIR__ . '/sections/products.php'; else include __DIR__ . '/sections/general.php';
?>

<div id="adminToast" class="admin-toast"></div>

<input type="hidden" id="csrfToken" value="<?php echo $_SESSION['csrf_token']; ?>">

</div>

<script src="js/admin.js"></script>
</body>
</html>
