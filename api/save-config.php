<?php
session_start();

if (!isset($_SESSION["admin_logged"]) || $_SESSION["admin_logged"] !== true) {
	http_response_code(403);
	echo json_encode(array("error" => "No autorizado"));
	exit;
}

$data = file_get_contents("php://input");
if (!$data) {
	http_response_code(400);
	echo json_encode(array("error" => "Datos vacíos"));
	exit;
}

$configPath = __DIR__ . "/../data/config.json";

file_put_contents(
	$configPath,
	json_encode(json_decode($data, true), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE)
);

echo json_encode(array("success" => true));
