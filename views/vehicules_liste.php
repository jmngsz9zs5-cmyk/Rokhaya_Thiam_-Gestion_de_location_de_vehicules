<?php
// Vue : liste des vehicules

require_once __DIR__ . '/../classes/VehiculeManager.php';
require_once __DIR__ . '/../classes/LocationManager.php';

$vehiculeManager = new VehiculeManager();
$locationManager = new LocationManager();

$erreur = null;

// Suppression d'un vehicule si demandee
if (isset($_GET['supprimer'])) {
    $idASupprimer = (int) $_GET['supprimer'];

    if ($locationManager->possedeLocationsPourVehicule($idASupprimer)) {
        $erreur = 'Impossible de supprimer ce vehicule : il est lie a une ou plusieurs locations.';
    } else {
        $vehiculeManager->supprimer($idASupprimer);
        header('Location: index.php?page=vehicules');
        exit;
    }
}

$vehicules = $vehiculeManager->lister();
?>

<h2>Liste des vehicules</h2>

<?php if ($erreur): ?>
    <p class="erreur"><?= htmlspecialchars($erreur) ?></p>
<?php endif; ?>

<p><a class="btn" href="index.php?page=vehicule_formulaire">Ajouter un vehicule</a></p>

<table>
    <thead>
        <tr>
            <th>Marque</th>
            <th>Modele</th>
            <th>Immatriculation</th>
            <th>Prix / jour</th>
            <th>Disponible</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($vehicules as $vehicule): ?>
            <tr>
                <td><?= htmlspecialchars($vehicule->getMarque()) ?></td>
                <td><?= htmlspecialchars($vehicule->getModele()) ?></td>
                <td><?= htmlspecialchars($vehicule->getImmatriculation()) ?></td>
                <td><?= htmlspecialchars(number_format($vehicule->getPrixParJour(), 2)) ?></td>
                <td>
                    <?php if ($vehicule->isDisponible()): ?>
                        <span class="badge badge-succes">Disponible</span>
                    <?php else: ?>
                        <span class="badge badge-neutre">Loue</span>
                    <?php endif; ?>
                </td>
                <td class="actions">
                    <a href="index.php?page=vehicule_formulaire&id=<?= $vehicule->getId() ?>">Modifier</a>
                    <a href="index.php?page=vehicules&supprimer=<?= $vehicule->getId() ?>"
                       class="lien-danger"
                       onclick="return confirm('Confirmer la suppression ?');">Supprimer</a>
                </td>
            </tr>
        <?php endforeach; ?>

        <?php if (empty($vehicules)): ?>
            <tr><td colspan="6">Aucun vehicule enregistre.</td></tr>
        <?php endif; ?>
    </tbody>
</table>
