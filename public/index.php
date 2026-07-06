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
    'accueil' => ['icone' => 'accueil', 'libelle' => 'Accueil'],
    'vehicules' => ['icone' => 'vehicule', 'libelle' => 'Vehicules'],
    'clients' => ['icone' => 'client', 'libelle' => 'Clients'],
    'locations' => ['icone' => 'location', 'libelle' => 'Locations'],
    'recherche' => ['icone' => 'recherche', 'libelle' => 'Recherche'],
];

/**
 * Retourne le balisage SVG d'une icone du jeu d'icones de l'application.
 * Icones en traits (style outline), heritent de la couleur du texte (currentColor).
 */
function icone(string $nom): string
{
    $traits = 'fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"';

    $formes = [
        'accueil' => '<path d="M4 11.5 12 4l8 7.5" /><path d="M6 10v9a1 1 0 0 0 1 1h4v-6h2v6h4a1 1 0 0 0 1-1v-9" />',
        'vehicule' => '<path d="M4 16V12l1.6-4.2A2 2 0 0 1 7.5 6.5h9a2 2 0 0 1 1.9 1.3L20 12v4" /><rect x="3" y="16" width="18" height="4" rx="1.4" /><circle cx="7.5" cy="19.5" r="1.4" /><circle cx="16.5" cy="19.5" r="1.4" />',
        'client' => '<circle cx="12" cy="8" r="3.4" /><path d="M5 20c0-3.6 3.1-6.2 7-6.2s7 2.6 7 6.2" />',
        'location' => '<rect x="5" y="4" width="14" height="17" rx="2" /><path d="M9 3.5h6a1 1 0 0 1 1 1V6H8V4.5a1 1 0 0 1 1-1Z" /><path d="M8.5 11h7M8.5 14.5h7M8.5 18h4" />',
        'recherche' => '<circle cx="10.5" cy="10.5" r="6" /><path d="m19 19-4.3-4.3" />',
        'disponible' => '<circle cx="12" cy="12" r="9" /><path d="m8.2 12.3 2.6 2.6 5-5.2" />',
        'plus' => '<path d="M12 5v14M5 12h14" />',
    ];

    $chemin = $formes[$nom] ?? '';

    return '<svg viewBox="0 0 24 24" width="18" height="18" ' . $traits . '>' . $chemin . '</svg>';
}

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
                    <span class="nav-icone"><?= icone($item['icone']) ?></span><?= $item['libelle'] ?>
                </a>
            <?php endforeach; ?>
        </nav>
    </header>

    <main>
        <?php require __DIR__ . '/../views/' . $vues[$page]; ?>
    </main>
</body>
</html>
