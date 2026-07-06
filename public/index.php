<?php
// Point d'entree de l'application : redirige vers la vue demandee

$pagesAutorisees = [
    'accueil',
    'vehicules',
    'vehicule_formulaire',
    'clients',
    'client_formulaire',
    'locations',
    'location_formulaire',
    'recherche',
];

$page = $_GET['page'] ?? 'accueil';
if (!in_array($page, $pagesAutorisees, true)) {
    $page = 'accueil';
}

// Correspondance entre le parametre "page" et le fichier de vue
$vues = [
    'accueil' => 'accueil.php',
    'vehicules' => 'vehicules_liste.php',
    'vehicule_formulaire' => 'vehicule_formulaire.php',
    'clients' => 'clients_liste.php',
    'client_formulaire' => 'client_formulaire.php',
    'locations' => 'locations_liste.php',
    'location_formulaire' => 'location_formulaire.php',
    'recherche' => 'recherche.php',
];
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Gestion de location de vehicules</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <header>
        <h1>Gestion de location de vehicules</h1>
        <nav>
            <a href="index.php?page=accueil">Accueil</a>
            <a href="index.php?page=vehicules">Vehicules</a>
            <a href="index.php?page=clients">Clients</a>
            <a href="index.php?page=locations">Locations</a>
            <a href="index.php?page=recherche">Recherche</a>
        </nav>
    </header>

    <main>
        <?php require __DIR__ . '/../views/' . $vues[$page]; ?>
    </main>
</body>
</html>
