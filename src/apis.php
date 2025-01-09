<?php
require_once 'localisation.php';
require_once 'air.php';
require_once 'meteo.php';
require_once 'map.php';

echo <<<HTML
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>APIs utilisées</title>
</head>
<body>
    <main>
        <section>
            <h2>Liste des APIs</h2>
            <ul>   
                <li><a href="$ip_url">Localisation</a></li>
                <li><a href="$meteo_url">Météo</a></li>
                <li><a href="$air_url">Qualité de l'air</a></li>
                <li><a href="$circulation_url">Circulation</a></li>
                <li><a href="$stan_url">Place Stanislas</a></li>
            </ul>
        </section>
    </main>
</body>
</html>
HTML;
