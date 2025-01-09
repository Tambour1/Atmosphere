<?php
require_once 'src/localisation.php';
require_once 'src/meteo.php';
require_once 'src/map.php';
require_once 'src/air.php';

echo <<<HTML
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Atmosphere</title>
    <link rel="stylesheet" href="styles/atmosphere.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
          integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY="
          crossorigin=""/>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
            integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo="
            crossorigin=""></script>
</head>
<body>
    <header>
        <h1>Atmosphere - Météo et Infos</h1>
        <p>Obtenez des informations en temps réel sur la météo, la circulation et la qualité de l'air</p>
    </header>
    <main> 
        <section class="infos">
        <div class="meteo">
            <h2>Météo du jour à $lieu</h2>             
            <div class="meteo-data">$meteo_data</div>
        </div>
        <div class="air">
            <h2>Qualité de l'air</h2>
            <p><strong>$qualite_air</strong></p>
            <div class="rond" style="background-color: $air_color;"></div>
        </div>
        </section>        
        
        <section class="map">
            <h2>Difficultés de circulation dans le Grand Nancy</h2>
            <div id="map"></div>
        </section>
        
    </main>
    <footer>
        <p>&copy; 2025 - Application Atmosphere - Météo et Infos | Développée par Victor GEORGES</p>
        <p><a href="./src/apis.php">Consulter les APIs utilisées</a></p>
    </footer>
    $map
</body>
</html>
HTML;
