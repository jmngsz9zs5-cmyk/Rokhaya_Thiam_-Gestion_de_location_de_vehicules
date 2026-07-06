<?php
// Vue : liste des clients

require_once __DIR__ . '/../classes/ClientManager.php';
require_once __DIR__ . '/../classes/LocationManager.php';

$clientManager = new ClientManager();
$locationManager = new LocationManager();

$erreur = null;

// Suppression d'un client si demandee
if (isset($_GET['supprimer'])) {
    $idASupprimer = (int) $_GET['supprimer'];

    if ($locationManager->possedeLocationsPourClient($idASupprimer)) {
        $erreur = 'Impossible de supprimer ce client : il est lie a une ou plusieurs locations.';
    } else {
        $clientManager->supprimer($idASupprimer);
        header('Location: index.php?page=clients');
        exit;
    }
}

$clients = $clientManager->lister();
?>

<h2>Liste des clients</h2>

<?php if ($erreur): ?>
    <p class="erreur"><?= htmlspecialchars($erreur) ?></p>
<?php endif; ?>

<p><a class="btn" href="index.php?page=client_formulaire">Ajouter un client</a></p>

<table>
    <thead>
        <tr>
            <th>Nom</th>
            <th>Telephone</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($clients as $client): ?>
            <tr>
                <td><?= htmlspecialchars($client->getNom()) ?></td>
                <td><?= htmlspecialchars($client->getTelephone()) ?></td>
                <td class="actions">
                    <a href="index.php?page=client_formulaire&id=<?= $client->getId() ?>">Modifier</a>
                    <a href="index.php?page=clients&supprimer=<?= $client->getId() ?>"
                       class="lien-danger"
                       onclick="return confirm('Confirmer la suppression ?');">Supprimer</a>
                </td>
            </tr>
        <?php endforeach; ?>

        <?php if (empty($clients)): ?>
            <tr><td colspan="3">Aucun client enregistre.</td></tr>
        <?php endif; ?>
    </tbody>
</table>
