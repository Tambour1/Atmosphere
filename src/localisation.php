<?php
require_once 'cache.php';

/**
 * Récupère la localisation de l'utilisateur
 * @param string $ip Adresse IP de l'utilisateur
 * @return SimpleXMLElement|null
 */
function getLocalisation($ip) {
    $opts = array('http' => array('proxy'=> 'tcp://127.0.0.1:8080', 'request_fulluri'=> true), 'ssl' => array( 'verify_peer' => false, 'verify_peer_name' => false));
    $context = stream_context_create($opts);
    $cacheFile = __DIR__ . '/../cache/localisation.xml';
    global $ip_url;
    $ip_url = "http://ip-api.com/xml/$ip";
    $localisationData = get_cached_data($cacheFile, $ip_url, 3600, $context);
    return $localisationData ? simplexml_load_string($localisationData) : null;
}

$client_ip = $_SERVER['REMOTE_ADDR'];

$localisation = getLocalisation($client_ip);

if ($localisation->status == 'success' && $localisation->city == 'Nancy') {
    $latitude = $localisation->lat;
    $longitude = $localisation->lon;
    $lieu = $localisation->city;
} else { // recupération par défaut des coordonnées de l'IUT Charlemagne
    $opts = [
        "http" => [
            "header" => "User-Agent: test/1.0 (test@gmail.com)"
        ]
    ];
    $context = stream_context_create($opts);
    $charlemagne_url = "https://nominatim.openstreetmap.org/search?q=Iut%20Charlemagne&format=xml";
    $charlemagneData = file_get_contents($charlemagne_url, false, $context);
    $charlemagne = simplexml_load_string($charlemagneData);
    $latitude = $charlemagne->place[0]->attributes()->lat;
    $longitude = $charlemagne->place[0]->attributes()->lon;
    $lieu = "IUT Charlemagne";
}