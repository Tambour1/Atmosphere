<?php

/**
 * Récupère les données météo
 * @param float $latitude
 * @param float $longitude
 * @return SimpleXMLElement|null
 */
function getMeteo($latitude, $longitude) {
    $cacheFile = __DIR__ . '/../cache/meteo.xml';
    global $meteo_url;
    $meteo_url = "https://www.infoclimat.fr/public-api/gfs/xml?_ll=$latitude,$longitude&_auth=ARsDFFIsBCZRfFtsD3lSe1Q8ADUPeVRzBHgFZgtuAH1UMQNgUTNcPlU5VClSfVZkUn8AYVxmVW0Eb1I2WylSLgFgA25SNwRuUT1bPw83UnlUeAB9DzFUcwR4BWMLYwBhVCkDb1EzXCBVOFQoUmNWZlJnAH9cfFVsBGRSPVs1UjEBZwNkUjIEYVE6WyYPIFJjVGUAZg9mVD4EbwVhCzMAMFQzA2JRMlw5VThUKFJiVmtSZQBpXGtVbwRlUjVbKVIuARsDFFIsBCZRfFtsD3lSe1QyAD4PZA%3D%3D&_c=19f3aa7d766b6ba91191c8be71dd1ab2";
    $meteoData = get_cached_data($cacheFile, $meteo_url, 900);
    return $meteoData ? simplexml_load_string($meteoData) : null;
}

$meteo = getMeteo($latitude, $longitude);

// Transformation XSL
$xsl = new DOMDocument;
$xsl->load(__DIR__ . '/../atmosphere.xsl');

$processor = new XSLTProcessor;
$processor->importStyleSheet($xsl);
$processor->setParameter('', 'current_date', date('Y-m-d'));
$meteo_data = $processor->transformToXML($meteo);