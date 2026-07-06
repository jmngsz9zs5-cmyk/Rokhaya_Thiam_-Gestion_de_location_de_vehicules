<?php
// Vue : formulaire d'enregistrement d'une location

require_once __DIR__ . '/../classes/LocationManager.php';
require_once __DIR__ . '/../classes/VehiculeManager.php';
require_once __DIR__ . '/../classes/ClientManager.php';

$locationManager = new LocationManager();
$vehiculeManager = new VehiculeManager();
$clientManager = new ClientManager();

// Traitement du formulaire
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $location = new Location(
        (int) $_POST['vehicule_id'],
        (int) $_POST['client_id'],
        $_POST['date_debut'],
        $_POST['date_fin']
    );
    $locationManager->ajouter($location);

    header('Location: index.php?page=locations');
    exit;
}

$vehicules = array_filter($vehiculeManager->lister(), fn($v) => $v->isDisponible());
$clients = $clientManager->lister();
?>

<h2>Enregistrer une location</h2>

<?php if (empty($vehicules)): ?>
    <p>Aucun vehicule disponible actuellement.</p>
<?php elseif (empty($clients)): ?>
    <p>Aucun client enregistre. Ajoutez d'abord un client.</p>
<?php else: ?>
    <form method="post" action="index.php?page=location_formulaire">
        <label>Vehicule
            <select name="vehicule_id" required>
                <?php foreach ($vehicules as $vehicule): ?>
                    <option value="<?= $vehicule->getId() ?>">
                        <?= htmlspecialchars($vehicule->getMarque() . ' ' . $vehicule->getModele() . ' (' . $vehicule->getImmatriculation() . ')') ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </label>

        <label>Client
            <select name="client_id" required>
                <?php foreach ($clients as $client): ?>
                    <option value="<?= $client->getId() ?>"><?= htmlspecialchars($client->getNom()) ?></option>
                <?php endforeach; ?>
            </select>
        </label>

        <label>Date de debut
            <input type="date" name="date_debut" required>
        </label>

        <label>Date de fin
            <input type="date" name="date_fin" required>
        </label>

        <button type="submit">Enregistrer la location</button>
        <a href="index.php?page=locations">Annuler</a>
    </form>
<?php endif; ?>
