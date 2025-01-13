# Atmosphere App
Cette application a été réalisée par **Victor GEORGES**, étudiant de BUT 3 Informatique à l'IUT Nancy-Charlemagne, dans le cadre d'un cours d'interopérabilité.

# Tables des matières
- [Description](#description)
- [Technologies](#technologies)
- [Installation](#installation)
- [Liens](#liens)

# Description
Ce projet est une application web croissant plusieurs APIs en temps réel pour récupérer des informations sur :
  - La météo du jour selon la géolocalisation
  - La qualité de l'air sur Nancy
  - Des incidents en temps réel sur les routes de Nancy

# Technologies
- PHP, XSL
- Leaflet.js pour la carte

# Installation
## Cloner le dépôt
```bash
# clonage du projet
git clone https://github.com/Tambour1/Atmosphere.git

# se placer dans le répertoire 
cd Atmosphere

# Droit sur le cache
chmod -R 777 cache
```
## Création d'un fichier .env
Il faudra ensuite créer à la racine du projet un fichier ".env" contenant une clé d'API pour la géolocalisation. Il faut également mettre la variable ISLOCAL=true afin de lancer le projet en local. Quand elle n'est pas définie, cela permet de mettre le projet sur webetu.
```.env
APIKEY=VotreCleAPI
ISLOCAL=true
```
Pour obtenir une clé d'API gratuite, il vous suffit de vous inscrire sur [ce site](https://app.ipgeolocation.io/login).
Pour des raisons de simplicité, j'ai également mis à disposition une clé d'API par defaut directement dans le code si la variable du .env est vide.
Evidement une clé d'API ne se met absolument pas en clair dans le code :)

## Utiliser Docker
```bash
# Lancer le conteneur à la racine du projet
docker-compose up -d --build

# Arrêter et supprimer le conteneur
docker-compose down
```

L'application sera accessible à l'adresse http://localhost:3007/atmosphere.php

# Liens
- Dépot git : https://github.com/Tambour1/Atmosphere.git
- Webetu : https://webetu.iutnc.univ-lorraine.fr/~george264u/Interop/atmosphere/atmosphere.php
