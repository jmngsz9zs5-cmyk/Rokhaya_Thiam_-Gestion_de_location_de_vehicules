<?php
// Vue : formulaire d'ajout / modification d'un vehicule

require_once __DIR__ . '/../classes/VehiculeManager.php';

$vehiculeManager = new VehiculeManager();
$vehicule = null;

if (isset($_GET['id'])) {
    $vehicule = $vehiculeManager->trouverParId((int) $_GET['id']);
}

// Traitement du formulaire
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $marque = trim($_POST['marque']);
    $modele = trim($_POST['modele']);
    $immatriculation = trim($_POST['immatriculation']);
    $prixParJour = (float) $_POST['prix_par_jour'];
    $disponible = isset($_POST['disponible']);

    if (isset($_POST['id']) && $_POST['id'] !== '') {
        $vehicule = new Vehicule($marque, $modele, $immatriculation, $prixParJour, $disponible, (int) $_POST['id']);
        $vehiculeManager->modifier($vehicule);
    } else {
        $vehicule = new Vehicule($marque, $modele, $immatriculation, $prixParJour, $disponible);
        $vehiculeManager->ajouter($vehicule);
    }

    header('Location: index.php?page=vehicules');
    exit;
}
?>

<h2><?= $vehicule ? 'Modifier le vehicule' : 'Ajouter un vehicule' ?></h2>

<form method="post" action="index.php?page=vehicule_formulaire">
    <?php if ($vehicule): ?>
        <input type="hidden" name="id" value="<?= $vehicule->getId() ?>">
    <?php endif; ?>

    <label>Marque
        <input type="text" name="marque" value="<?= $vehicule ? htmlspecialchars($vehicule->getMarque()) : '' ?>" required>
    </label>

    <label>Modele
        <input type="text" name="modele" value="<?= $vehicule ? htmlspecialchars($vehicule->getModele()) : '' ?>" required>
    </label>

    <label>Immatriculation
        <input type="text" name="immatriculation" value="<?= $vehicule ? htmlspecialchars($vehicule->getImmatriculation()) : '' ?>" required>
    </label>

    <label>Prix par jour
        <input type="number" step="0.01" name="prix_par_jour" value="<?= $vehicule ? $vehicule->getPrixParJour() : '' ?>" required>
    </label>

    <label>
        <input type="checkbox" name="disponible" <?= (!$vehicule || $vehicule->isDisponible()) ? 'checked' : '' ?>>
        Disponible
    </label>

    <button type="submit">Enregistrer</button>
    <a href="index.php?page=vehicules">Annuler</a>
</form>
