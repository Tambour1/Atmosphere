<?php
require_once 'cache.php';

/**
 * Récupération des données de la qualité de l'air
 * @return mixed|null
 */
function getAir() {
    $cacheFile = __DIR__ . '/../cache/air.json';
    global $air_url;
    $air_url = "https://services3.arcgis.com/Is0UwT37raQYl9Jj/arcgis/rest/services/ind_grandest_5j/FeatureServer/0/query?where=lib_zone%3D%27Nancy%27&geometryType=esriGeometryEnvelope&spatialRel=esriSpatialRelIntersects&resultType=none&distance=0.0&units=esriSRUnit_Meter&returnGeodetic=false&outFields=*&returnGeometry=true&featureEncoding=esriDefault&multipatchOption=xyFootprint&maxAllowableOffset&applyVCSProjection=false&returnIdsOnly=false&returnUniqueIdsOnly=false&returnCountOnly=false&returnExtentOnly=false&returnQueryGeometry=false&returnDistinctValues=false&cacheHint=false&returnZ=false&returnM=false&returnExceededLimitFeatures=true&sqlFormat=none&f=pjson";
    $airData = get_cached_data($cacheFile, $air_url, 900);
    return $airData ? json_decode($airData) : null;
}

$air = getAir();
$current_date = new DateTime('now', new DateTimeZone('Europe/Paris'));

foreach ($air->features as $feature) {
    foreach ($feature->attributes as $key => $value) {
        if ($key == 'date_ech') {

            if (strlen($value) > 10) { // Si le timestamp est en millisecondes
                $value = intval($value / 1000);
            }

            // Conversion du timestamp en date
            $date_value = (new DateTime())->setTimestamp($value)->setTimezone(new DateTimeZone('Europe/Paris'));

            // Si la date de l'entrée correspond à la date actuelle
            if ($date_value->format('d-m-Y') == $current_date->format('d-m-Y')) {
                $qualite_air = $feature->attributes->lib_qual;
                $air_color = $feature->attributes->coul_qual;
            }
        }
    }
}