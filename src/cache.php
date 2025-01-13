<?php

/**
 * Fonction pour récupérer des données dans le cache
 * @param string $cache_file Le fichier de cache
 * @param string $url L'URL à récupérer
 * @param int $expiry_time Le temps d'expiration du cache
 * @param resource $context Le contexte de la requête
 * @return string|false
 */
function get_cached_data($cache_file, $url, $expiry_time = 600) {

    // Crée le contexte selon l'environnement
    if (getenv('ISLOCAL') == 'true') {
        $opts = array('http' => array('header' => "User-Agent: test/1.0 (test@gmail.com)"));
    } else {
        $opts = array('http' => array('proxy'=> 'tcp://www-cache:3128', 'request_fulluri'=> true,"header" => "User-Agent: test/1.0 (test@gmail.com)"), 'ssl' => array( 'verify_peer' => false, 'verify_peer_name' => false));
    }
       
    $context = stream_context_create($opts);

    // Vérifie si le fichier de cache existe et n'est pas expiré
    if (file_exists($cache_file) && (time() - filemtime($cache_file)) < $expiry_time) {
        return file_get_contents($cache_file);
    } else {
        
        $data = file_get_contents($url, false, $context);

        // Si la requête réussit, mettre à jour le cache
        if ($data !== false) {
            file_put_contents($cache_file, $data);
        }
        return $data;
    }
}

