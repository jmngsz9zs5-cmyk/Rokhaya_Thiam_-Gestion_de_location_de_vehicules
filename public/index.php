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

// Liens du menu de navigation (icone + libelle), avec detection de la page active
$menu = [
    'accueil' => ['icone' => '🏠', 'libelle' => 'Accueil'],
    'vehicules' => ['icone' => '🚗', 'libelle' => 'Vehicules'],
    'clients' => ['icone' => '👤', 'libelle' => 'Clients'],
    'locations' => ['icone' => '📋', 'libelle' => 'Locations'],
    'recherche' => ['icone' => '🔍', 'libelle' => 'Recherche'],
];

// Les formulaires appartiennent visuellement a la section parente pour le surlignage du menu
$pageActive = $page;
if ($page === 'vehicule_formulaire') {
    $pageActive = 'vehicules';
} elseif ($page === 'client_formulaire') {
    $pageActive = 'clients';
} elseif ($page === 'location_formulaire') {
    $pageActive = 'locations';
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Gestion de location de vehicules</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@600;700&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <header>
        <div class="entete-marque">
            <span class="logo">GLV</span>
            <h1>Gestion de location de vehicules</h1>
        </div>
        <nav>
            <?php foreach ($menu as $cle => $item): ?>
                <a href="index.php?page=<?= $cle ?>" class="<?= $pageActive === $cle ? 'active' : '' ?>">
                    <span class="nav-icone"><?= $item['icone'] ?></span><?= $item['libelle'] ?>
                </a>
            <?php endforeach; ?>
        </nav>
    </header>

    <main>
        <?php require __DIR__ . '/../views/' . $vues[$page]; ?>
    </main>
</body>
</html>
