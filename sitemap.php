<?php
header("Content-Type: application/xml; charset=utf-8");

$configPath = __DIR__ . '/data/config.json';

function getConfigData($path) {
	if (!file_exists($path)) return array();
	$json = file_get_contents($path);
	return json_decode($json, true);
}

$config = getConfigData($configPath);

$siteUrl = "https://" . $_SERVER['HTTP_HOST'];
$lastmod = date("Y-m-d");

echo '<?xml version="1.0" encoding="UTF-8"?>';
?>

<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">

	<url>
		<loc><?php echo $siteUrl; ?>/</loc>
		<lastmod><?php echo $lastmod; ?></lastmod>
		<changefreq>weekly</changefreq>
		<priority>1.0</priority>
	</url>

</urlset>
