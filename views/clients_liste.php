<?php
// Vue : liste des clients

require_once __DIR__ . '/../classes/ClientManager.php';

$clientManager = new ClientManager();

// Suppression d'un client si demandee
if (isset($_GET['supprimer'])) {
    $clientManager->supprimer((int) $_GET['supprimer']);
    header('Location: index.php?page=clients');
    exit;
}

$clients = $clientManager->lister();
?>

<h2>Liste des clients</h2>

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
                <td>
                    <a href="index.php?page=client_formulaire&id=<?= $client->getId() ?>">Modifier</a>
                    |
                    <a href="index.php?page=clients&supprimer=<?= $client->getId() ?>"
                       onclick="return confirm('Confirmer la suppression ?');">Supprimer</a>
                </td>
            </tr>
        <?php endforeach; ?>

        <?php if (empty($clients)): ?>
            <tr><td colspan="3">Aucun client enregistre.</td></tr>
        <?php endif; ?>
    </tbody>
</table>
