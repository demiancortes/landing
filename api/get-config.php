<?php
$configPath = __DIR__ . '/../data/config.json';

if (!file_exists($configPath)) {
	http_response_code(404);
	exit;
}

header('Content-Type: application/json');
echo file_get_contents($configPath);
