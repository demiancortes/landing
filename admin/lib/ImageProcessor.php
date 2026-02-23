<?php

function processImageUpload($file, $uploadDir, $maxWidth = 1200, $quality = 80) {

	if (!isset($file) || $file['error'] !== 0) {
		return false;
	}

	$allowedTypes = array('image/jpeg', 'image/png');
	$fileType = mime_content_type($file['tmp_name']);

	if (!in_array($fileType, $allowedTypes)) {
		return false;
	}

	list($width, $height) = getimagesize($file['tmp_name']);

	if (!$width || !$height) {
		return false;
	}

	// Calcular proporción
	if ($width > $maxWidth) {
		$newWidth = $maxWidth;
		$newHeight = intval(($height / $width) * $newWidth);
	} else {
		$newWidth = $width;
		$newHeight = $height;
	}

	$destination = imagecreatetruecolor($newWidth, $newHeight);

	if ($fileType === 'image/png') {
		$source = imagecreatefrompng($file['tmp_name']);
		imagealphablending($destination, false);
		imagesavealpha($destination, true);
	} else {
		$source = imagecreatefromjpeg($file['tmp_name']);
	}

	imagecopyresampled(
		$destination,
		$source,
		0, 0, 0, 0,
		$newWidth,
		$newHeight,
		$width,
		$height
	);

	if (!is_dir($uploadDir)) {
		mkdir($uploadDir, 0755, true);
	}

	$extension = $fileType === 'image/png' ? '.png' : '.jpg';
	$newFileName = uniqid('img_') . $extension;
	$savePath = rtrim($uploadDir, '/') . '/' . $newFileName;

	if ($fileType === 'image/png') {
		imagepng($destination, $savePath, 6);
	} else {
		imagejpeg($destination, $savePath, $quality);
	}

	imagedestroy($source);
	imagedestroy($destination);

	return $newFileName;
}
