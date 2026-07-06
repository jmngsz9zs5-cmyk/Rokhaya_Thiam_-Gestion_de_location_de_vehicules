<?php
// Vue : recherche de locations par marque de vehicule ou par nom de client

require_once __DIR__ . '/../classes/LocationManager.php';

$locationManager = new LocationManager();

$resultats = [];
$recherche = false;

if (isset($_GET['marque']) && trim($_GET['marque']) !== '') {
    $resultats = $locationManager->rechercherParMarque(trim($_GET['marque']));
    $recherche = true;
} elseif (isset($_GET['client']) && trim($_GET['client']) !== '') {
    $resultats = $locationManager->rechercherParClient(trim($_GET['client']));
    $recherche = true;
}
?>

<h2>Recherche de locations</h2>

<form method="get" action="index.php">
    <input type="hidden" name="page" value="recherche">

    <label>Par marque de vehicule
        <input type="text" name="marque" placeholder="Ex : Toyota">
    </label>
    <button type="submit">Rechercher</button>
</form>

<form method="get" action="index.php">
    <input type="hidden" name="page" value="recherche">

    <label>Par nom de client
        <input type="text" name="client" placeholder="Ex : Diop">
    </label>
    <button type="submit">Rechercher</button>
</form>

<?php if ($recherche): ?>
    <h3>Resultats</h3>
    <table>
        <thead>
            <tr>
                <th>Vehicule</th>
                <th>Client</th>
                <th>Date debut</th>
                <th>Date fin</th>
                <th>Statut</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($resultats as $ligne): ?>
                <tr>
                    <td><?= htmlspecialchars($ligne['marque'] . ' ' . $ligne['modele']) ?></td>
                    <td><?= htmlspecialchars($ligne['client_nom']) ?></td>
                    <td><?= htmlspecialchars($ligne['date_debut']) ?></td>
                    <td><?= htmlspecialchars($ligne['date_fin']) ?></td>
                    <td><?= htmlspecialchars($ligne['statut']) ?></td>
                </tr>
            <?php endforeach; ?>

            <?php if (empty($resultats)): ?>
                <tr><td colspan="5">Aucun resultat.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
<?php endif; ?>
