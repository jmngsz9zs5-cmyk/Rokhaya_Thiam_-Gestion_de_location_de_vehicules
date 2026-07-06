<?php
// Vue : page d'accueil (tableau de bord)

require_once __DIR__ . '/../classes/VehiculeManager.php';
require_once __DIR__ . '/../classes/ClientManager.php';
require_once __DIR__ . '/../classes/LocationManager.php';

$vehiculeManager = new VehiculeManager();
$clientManager = new ClientManager();
$locationManager = new LocationManager();

$vehicules = $vehiculeManager->lister();
$nbVehicules = count($vehicules);
$nbVehiculesDisponibles = count(array_filter($vehicules, fn($v) => $v->isDisponible()));
$nbClients = count($clientManager->lister());
$nbLocationsEnCours = count($locationManager->listerEnCours());
?>

<section class="accueil-hero">
    <h2>Bienvenue sur l'espace de gestion</h2>
    <p>Suivez en un coup d'oeil vos vehicules, vos clients et vos locations en cours.</p>
</section>

<div class="stats-grille">
    <div class="stat-carte">
        <span class="icone-pastille teinte-primaire"><?= icone('vehicule') ?></span>
        <span class="stat-valeur"><?= $nbVehicules ?></span>
        <span class="stat-libelle">Vehicules</span>
    </div>
    <div class="stat-carte">
        <span class="icone-pastille teinte-succes"><?= icone('disponible') ?></span>
        <span class="stat-valeur"><?= $nbVehiculesDisponibles ?></span>
        <span class="stat-libelle">Disponibles</span>
    </div>
    <div class="stat-carte">
        <span class="icone-pastille teinte-violet"><?= icone('client') ?></span>
        <span class="stat-valeur"><?= $nbClients ?></span>
        <span class="stat-libelle">Clients</span>
    </div>
    <div class="stat-carte">
        <span class="icone-pastille teinte-ambre"><?= icone('location') ?></span>
        <span class="stat-valeur"><?= $nbLocationsEnCours ?></span>
        <span class="stat-libelle">Locations en cours</span>
    </div>
</div>

<h3>Acces rapide</h3>

<div class="actions-grille">
    <a class="action-carte" href="index.php?page=vehicules">
        <span class="icone-pastille teinte-primaire"><?= icone('vehicule') ?></span>
        <div>
            <strong>Gerer les vehicules</strong>
            <p>Ajouter, modifier, suivre la disponibilite</p>
        </div>
    </a>
    <a class="action-carte" href="index.php?page=clients">
        <span class="icone-pastille teinte-violet"><?= icone('client') ?></span>
        <div>
            <strong>Gerer les clients</strong>
            <p>Ajouter, modifier, consulter la liste</p>
        </div>
    </a>
    <a class="action-carte" href="index.php?page=locations">
        <span class="icone-pastille teinte-ambre"><?= icone('location') ?></span>
        <div>
            <strong>Gerer les locations</strong>
            <p>Enregistrer une location, marquer un retour</p>
        </div>
    </a>
    <a class="action-carte" href="index.php?page=recherche">
        <span class="icone-pastille teinte-succes"><?= icone('recherche') ?></span>
        <div>
            <strong>Rechercher</strong>
            <p>Par marque de vehicule ou par client</p>
        </div>
    </a>
</div>
