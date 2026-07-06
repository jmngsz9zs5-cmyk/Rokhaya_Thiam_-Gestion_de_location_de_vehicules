<?php
// Vue : formulaire d'ajout / modification d'un client

require_once __DIR__ . '/../classes/ClientManager.php';

$clientManager = new ClientManager();
$client = null;

if (isset($_GET['id'])) {
    $client = $clientManager->trouverParId((int) $_GET['id']);
}

// Traitement du formulaire
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = trim($_POST['nom']);
    $telephone = trim($_POST['telephone']);

    if (isset($_POST['id']) && $_POST['id'] !== '') {
        $client = new Client($nom, $telephone, (int) $_POST['id']);
        $clientManager->modifier($client);
    } else {
        $client = new Client($nom, $telephone);
        $clientManager->ajouter($client);
    }

    header('Location: index.php?page=clients');
    exit;
}
?>

<h2><?= $client ? 'Modifier le client' : 'Ajouter un client' ?></h2>

<form method="post" action="index.php?page=client_formulaire">
    <?php if ($client): ?>
        <input type="hidden" name="id" value="<?= $client->getId() ?>">
    <?php endif; ?>

    <label>Nom
        <input type="text" name="nom" value="<?= $client ? htmlspecialchars($client->getNom()) : '' ?>" required>
    </label>

    <label>Telephone
        <input type="text" name="telephone" value="<?= $client ? htmlspecialchars($client->getTelephone()) : '' ?>" required>
    </label>

    <button type="submit">Enregistrer</button>
    <a href="index.php?page=clients">Annuler</a>
</form>
