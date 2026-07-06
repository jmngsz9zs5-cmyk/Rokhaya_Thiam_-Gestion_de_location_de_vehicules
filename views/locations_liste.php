<?php
// Vue : liste des locations (toutes ou en cours uniquement)

require_once __DIR__ . '/../classes/LocationManager.php';
require_once __DIR__ . '/../classes/VehiculeManager.php';
require_once __DIR__ . '/../classes/ClientManager.php';

$locationManager = new LocationManager();
$vehiculeManager = new VehiculeManager();
$clientManager = new ClientManager();

// Marquer le retour d'une location si demande
if (isset($_GET['retour'])) {
    $locationManager->marquerRetour((int) $_GET['retour']);
    header('Location: index.php?page=locations');
    exit;
}

$filtreEnCours = isset($_GET['filtre']) && $_GET['filtre'] === 'en_cours';
$locations = $filtreEnCours ? $locationManager->listerEnCours() : $locationManager->lister();
?>

<h2>Liste des locations</h2>

<p>
    <a class="btn" href="index.php?page=location_formulaire">Enregistrer une location</a>
</p>

<div class="onglets">
    <a href="index.php?page=locations" class="<?= !$filtreEnCours ? 'actif' : '' ?>">Toutes les locations</a>
    <a href="index.php?page=locations&filtre=en_cours" class="<?= $filtreEnCours ? 'actif' : '' ?>">Locations en cours</a>
</div>

<table>
    <thead>
        <tr>
            <th>Vehicule</th>
            <th>Client</th>
            <th>Date debut</th>
            <th>Date fin</th>
            <th>Statut</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($locations as $location): ?>
            <?php
            $vehicule = $vehiculeManager->trouverParId($location->getVehiculeId());
            $client = $clientManager->trouverParId($location->getClientId());
            ?>
            <tr>
                <td><?= $vehicule ? htmlspecialchars($vehicule->getMarque() . ' ' . $vehicule->getModele()) : '-' ?></td>
                <td><?= $client ? htmlspecialchars($client->getNom()) : '-' ?></td>
                <td><?= htmlspecialchars($location->getDateDebut()) ?></td>
                <td><?= htmlspecialchars($location->getDateFin()) ?></td>
                <td>
                    <?php if ($location->getStatut() === 'en cours'): ?>
                        <span class="badge badge-succes">En cours</span>
                    <?php else: ?>
                        <span class="badge badge-neutre">Terminee</span>
                    <?php endif; ?>
                </td>
                <td class="actions">
                    <?php if ($location->getStatut() === 'en cours'): ?>
                        <a href="index.php?page=locations&retour=<?= $location->getId() ?>"
                           onclick="return confirm('Confirmer le retour du vehicule ?');">Marquer le retour</a>
                    <?php endif; ?>
                </td>
            </tr>
        <?php endforeach; ?>

        <?php if (empty($locations)): ?>
            <tr><td colspan="6">Aucune location trouvee.</td></tr>
        <?php endif; ?>
    </tbody>
</table>
