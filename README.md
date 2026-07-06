# Gestion de location de vehicules

Application web permettant a une agence de gerer ses vehicules, ses clients et le suivi
des locations en cours. Realisee en PHP oriente objet avec une connexion PDO securisee
(requetes preparees).

## Fonctionnalites

- Gestion des vehicules (ajout, liste, modification, suppression)
- Gestion des clients (ajout, liste, modification, suppression)
- Enregistrement d'une location
- Marquage du retour d'un vehicule loue
- Liste des locations en cours
- Recherche de locations par marque de vehicule ou par nom de client

## Structure du projet

```
Gestion de location de vehicules/
|-- config/Database.php          -> classe de connexion PDO
|-- classes/
|   |-- Vehicule.php              -> entite Vehicule
|   |-- VehiculeManager.php       -> CRUD Vehicule
|   |-- Client.php                -> entite Client
|   |-- ClientManager.php         -> CRUD Client
|   |-- Location.php              -> entite Location
|   |-- LocationManager.php       -> CRUD Location + fonctionnalites metier
|-- views/                        -> pages d'affichage (formulaires, listes)
|-- public/index.php              -> point d'entree de l'application
|-- sql/gestion_location_vehicules.sql -> script de creation de la base
|-- assets/css/style.css          -> style personnel
```

## Installation (XAMPP)

1. Se placer dans le dossier `htdocs` de XAMPP puis cloner le depot :

   ```
   cd C:/xampp/htdocs
   git clone https://github.com/jmngsz9zs5-cmyk/Rokhaya_Thiam_-Gestion_de_location_de_vehicules.git "Gestion de location de vehicules"
   ```

2. Demarrer Apache et MySQL depuis le panneau de controle XAMPP.
3. Importer la base de donnees :
   - Ouvrir phpMyAdmin (`http://localhost/phpmyadmin`)
   - Creer/importer la base a partir du fichier `sql/gestion_location_vehicules.sql`
4. Verifier les identifiants de connexion dans `config/Database.php`
   (par defaut : host `localhost`, utilisateur `root`, mot de passe vide).
5. Acceder a l'application via :
   `http://localhost/Gestion de location de vehicules/public/index.php`

## Technologies

- PHP oriente objet
- MySQL / PDO (requetes preparees)
- HTML / CSS
