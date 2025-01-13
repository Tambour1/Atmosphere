<?php

/**
 * Récupère les données de circulation du Grand Nancy
 * @return mixed|null
 */
function getCirculation() {
    $cacheFile = __DIR__ . '/../cache/circulation.json';
    global $circulation_url;
    $circulation_url = "https://carto.g-ny.org/data/cifs/cifs_waze_v2.json";
    $circulationData = get_cached_data($cacheFile, $circulation_url, 300);
    return $circulationData ? json_decode($circulationData) : null;
}

$circulation = getCirculation();

// Récupération des incidents
$incidents = [];
foreach ($circulation->incidents as $incident) {
    $polyline = $incident->location->polyline;

    // Conversion des dates
    $starttime = new DateTime($incident->starttime);
    $starttime = $starttime->format('d-m-Y');
    $endtime = new DateTime($incident->endtime);
    $endtime = $endtime->format('d-m-Y');

    $description = $incident->short_description;

    $coordinates = explode(" ", $polyline); // "latitude longitude" séparés par un espace
    $latitude = floatval($coordinates[0]);
    $longitude = floatval($coordinates[1]);

    $incident_obj = (object) [ // Création d'un objet pour les incidents
        'latitude' => $latitude,
        'longitude' => $longitude,
        'starttime' => $starttime,
        'endtime' => $endtime,
        'description' => $description
    ];

    $incidents[] = $incident_obj;
}

// Création des marqueurs des incidents
$markers_js = "";
foreach ($incidents as $incident) {
    $markers_js .= <<<JS
        L.marker([{$incident->latitude}, {$incident->longitude}])
            .addTo(map)
            .bindPopup("{$incident->description}<br>Début: {$incident->starttime}<br>Fin: {$incident->endtime}");
JS;
}

/**
 * Récupère les données de la Place Stanislas
 * @return SimpleXMLElement|null
 */
function getStan() {
    $cacheFile = __DIR__ . '/../cache/stan.xml';
    global $stan_url;
    $stan_url = "https://nominatim.openstreetmap.org/search?q=Place%20Stanislas&format=xml";
    $stanData = get_cached_data($cacheFile, $stan_url, 3600);
    return $stanData ? simplexml_load_string($stanData) : null;
}

$stan = getStan();
$latitude_stan = $stan->place[0]->attributes()->lat;
$longitude_stan = $stan->place[0]->attributes()->lon;

// Création du marqueur de la Place Stanislas
$markerStan = <<<JS
    L.circle([{$latitude_stan}, {$longitude_stan}], {color: 'red', radius: 100, fillOpacity: 0.5, fillColor: 'red'})
        .addTo(map)
        .bindPopup("<b>Place Stanislas</b>");
JS;

// Création de la carte
$map = <<<JS
    <script>
        var map = L.map('map').setView([{$incidents[0]->latitude}, {$incidents[0]->longitude}], 13);
        L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
        }).addTo(map);
        {$markers_js}
        {$markerStan}
    </script>
JS;
