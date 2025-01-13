<?php
require_once __DIR__ . '/cache.php';

/**
 * Récupère la localisation de l'utilisateur
 * @param string $ip Adresse IP de l'utilisateur
 * @return SimpleXMLElement|null
 */
function getLocalisation($ip) {    
    $cacheFile = __DIR__ . '/../cache/localisation.xml';
    global $ip_url;
    $apiKey = getenv('APIKEY') ?: "41d15e5d79cf461fbbab930237377c7a"; // clé d'api à ne pas mettre en clair normalement
    $ip_url = 'https://api.ipgeolocation.io/ipgeo?apiKey=' . $apiKey . '&ip=' . $ip;
    $localisationData = get_cached_data($cacheFile, $ip_url, 3600);
    return $localisationData ? json_decode($localisationData) : null;
}

/**
 * Récupère la localisation de l'IUT Charlemagne
 * @return SimpleXMLElement|null
 */
function getCharlemagne() {
    $cacheFile = __DIR__ . '/../cache/charlemagne.xml';
    $charlemagne_url = "https://nominatim.openstreetmap.org/search?q=Iut%20Charlemagne&format=xml";
    $charlemagneData = get_cached_data($cacheFile, $charlemagne_url, 3600);
    return $charlemagneData ? simplexml_load_string($charlemagneData) : null;
}

if (getenv('ISLOCAL') == 'true') {
    $client_ip = "83.196.78.74"; // ip public de test NANCY
} else {
    $client_ip = getIpAddress();
}

$localisation = getLocalisation($client_ip);
$charlemagne = getCharlemagne();

if ($localisation && isset($localisation->city) && $localisation->city == "Nancy") {
    $latitude = $localisation->latitude;
    $longitude = $localisation->longitude;
    $lieu = $localisation->city;
} else {
    $latitude = $charlemagne->place[0]->attributes()->lat;
    $longitude = $charlemagne->place[0]->attributes()->lon;
    $lieu = "IUT Charlemagne";
}

function getIpAddress()
{
    // IPv6
    if (!empty($_SERVER['REMOTE_ADDR']) && filter_var($_SERVER['REMOTE_ADDR'], FILTER_VALIDATE_IP, FILTER_FLAG_IPV6)) {
        return $_SERVER['REMOTE_ADDR'];
    }

    // IPv4
    if (!empty($_SERVER['REMOTE_ADDR']) && filter_var($_SERVER['REMOTE_ADDR'], FILTER_VALIDATE_IP, FILTER_FLAG_IPV4)) {
        return $_SERVER['REMOTE_ADDR'];
    }

    // Si aucune adresse n'est disponible
    return 'Aucune adresse IP disponible';
}