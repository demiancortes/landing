<script type="application/ld+json">
<?php

function convertTo24Hour($time) {
    $time = trim($time);
    $timestamp = strtotime($time);
    if ($timestamp === false) return null;
    return date("H:i", $timestamp);
}

function parseOpeningHours($hours) {

	$dayMap = array(
		"Lunes" => "Monday",
		"Martes" => "Tuesday",
		"Miércoles" => "Wednesday",
		"Miercoles" => "Wednesday",
		"Jueves" => "Thursday",
		"Viernes" => "Friday",
		"Sábado" => "Saturday",
		"Sabado" => "Saturday",
		"Domingo" => "Sunday"
	);

	$result = array();

	foreach ($hours as $item) {

		if (!isset($item['label']) || !isset($item['time'])) continue;

		$label = trim($item['label']);
		$timeParts = preg_split("/–|-/", $item['time']);

		if (count($timeParts) != 2) continue;

		$open = convertTo24Hour(trim($timeParts[0]));
		$close = convertTo24Hour(trim($timeParts[1]));

		$days = array();

		// Si es rango (Lunes a Viernes)
		if (strpos($label, "a") !== false) {

			$range = explode("a", $label);
			$start = trim($range[0]);
			$end = trim($range[1]);

			$keys = array_keys($dayMap);
			$startIndex = array_search($start, $keys);
			$endIndex = array_search($end, $keys);

			if ($startIndex !== false && $endIndex !== false) {
				for ($i = $startIndex; $i <= $endIndex; $i++) {
					$days[] = $dayMap[$keys[$i]];
				}
			}

		} else {

			if (isset($dayMap[$label])) {
				$days[] = $dayMap[$label];
			}
		}

		foreach ($days as $day) {
			$result[] = array(
				"@type" => "OpeningHoursSpecification",
				"dayOfWeek" => $day,
				"opens" => $open,
				"closes" => $close
			);
		}
	}

	return $result;
}

$openingHours = parseOpeningHours(isset($config['hours']) ? $config['hours'] : array());

$schema = array(
	"@context" => "https://schema.org",
	"@type" => "LocalBusiness",
	"name" => $businessName,
	"image" => $siteUrl . '/' . $heroImage,
	"telephone" => isset($config['business']['phone']) ? $config['business']['phone'] : '',
	"address" => array(
		"@type" => "PostalAddress",
		"streetAddress" => isset($config['location']['address']) ? $config['location']['address'] : '',
		"addressLocality" => $city
	),
	"url" => $siteUrl,
	"openingHoursSpecification" => $openingHours
);

echo json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);

?>
</script>
