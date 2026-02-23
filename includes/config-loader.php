<?php

$configPath = __DIR__ . '/../data/config.json';

function getConfigData($path) {
	if (!file_exists($path)) return array();
	$json = file_get_contents($path);
	$data = json_decode($json, true);
	return $data ? $data : array();
}

$config = getConfigData($configPath);

$businessName = isset($config['business']['name']) ? $config['business']['name'] : 'Mi negocio';
$metaDescription = isset($config['seo']['metaDescription']) ? $config['seo']['metaDescription'] : '';
$heroImage = isset($config['hero']['image']) ? $config['hero']['image'] : 'images/hero/hero.svg';
$city = isset($config['seo']['city']) ? $config['seo']['city'] : '';
$siteUrl = "https://" . $_SERVER['HTTP_HOST'];
