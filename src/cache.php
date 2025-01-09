<?php

/**
 * Fonction pour récupérer des données dans le cache
 * @param string $cache_file Le fichier de cache
 * @param string $url L'URL à récupérer
 * @param int $expiry_time Le temps d'expiration du cache
 * @param resource $context Le contexte de la requête
 * @return string|false
 */
function get_cached_data($cache_file, $url, $expiry_time = 600, $context = null) {
    // Vérifie si le fichier de cache existe et n'est pas expiré
    if (file_exists($cache_file) && (time() - filemtime($cache_file)) < $expiry_time) {
        return file_get_contents($cache_file);
    } else {
        
        // Si le fichier de cache n'existe pas ou est expiré, recupérer le fichier depuis l'URL
        if ($context) {
            $data = file_get_contents($url, false, $context);
        } else {
            $data = file_get_contents($url);
        }

        // Si la requête réussit, mettre à jour le cache
        if ($data !== false) {
            file_put_contents($cache_file, $data);
        }
        return $data;
    }
}

