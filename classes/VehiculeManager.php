<?php

require_once __DIR__ . '/../config/Database.php';
require_once __DIR__ . '/Vehicule.php';

/**
 * Classe gestionnaire VehiculeManager
 * Realise les operations CRUD sur la table vehicule via des requetes preparees.
 */
class VehiculeManager
{
    private PDO $connexion;

    public function __construct()
    {
        $database = new Database();
        $this->connexion = $database->getConnexion();
    }

    /**
     * Ajoute un nouveau vehicule en base et renvoie son id.
     */
    public function ajouter(Vehicule $vehicule): int
    {
        $sql = 'INSERT INTO vehicule (marque, modele, immatriculation, prix_par_jour, disponible)
                VALUES (:marque, :modele, :immatriculation, :prix_par_jour, :disponible)';

        $requete = $this->connexion->prepare($sql);
        $requete->execute([
            'marque' => $vehicule->getMarque(),
            'modele' => $vehicule->getModele(),
            'immatriculation' => $vehicule->getImmatriculation(),
            'prix_par_jour' => $vehicule->getPrixParJour(),
            'disponible' => $vehicule->isDisponible() ? 1 : 0,
        ]);

        return (int) $this->connexion->lastInsertId();
    }

    /**
     * Retourne la liste de tous les vehicules.
     *
     * @return Vehicule[]
     */
    public function lister(): array
    {
        $sql = 'SELECT * FROM vehicule ORDER BY id DESC';
        $requete = $this->connexion->query($sql);

        $vehicules = [];
        while ($ligne = $requete->fetch(PDO::FETCH_ASSOC)) {
            $vehicules[] = $this->hydrater($ligne);
        }

        return $vehicules;
    }

    /**
     * Recherche un vehicule par son id. Renvoie null si non trouve.
     */
    public function trouverParId(int $id): ?Vehicule
    {
        $sql = 'SELECT * FROM vehicule WHERE id = :id';
        $requete = $this->connexion->prepare($sql);
        $requete->execute(['id' => $id]);

        $ligne = $requete->fetch(PDO::FETCH_ASSOC);

        return $ligne ? $this->hydrater($ligne) : null;
    }

    /**
     * Modifie un vehicule existant.
     */
    public function modifier(Vehicule $vehicule): bool
    {
        $sql = 'UPDATE vehicule
                SET marque = :marque,
                    modele = :modele,
                    immatriculation = :immatriculation,
                    prix_par_jour = :prix_par_jour,
                    disponible = :disponible
                WHERE id = :id';

        $requete = $this->connexion->prepare($sql);

        return $requete->execute([
            'marque' => $vehicule->getMarque(),
            'modele' => $vehicule->getModele(),
            'immatriculation' => $vehicule->getImmatriculation(),
            'prix_par_jour' => $vehicule->getPrixParJour(),
            'disponible' => $vehicule->isDisponible() ? 1 : 0,
            'id' => $vehicule->getId(),
        ]);
    }

    /**
     * Supprime un vehicule par son id.
     */
    public function supprimer(int $id): bool
    {
        $sql = 'DELETE FROM vehicule WHERE id = :id';
        $requete = $this->connexion->prepare($sql);

        return $requete->execute(['id' => $id]);
    }

    /**
     * Transforme une ligne de resultat SQL en objet Vehicule.
     */
    private function hydrater(array $ligne): Vehicule
    {
        return new Vehicule(
            $ligne['marque'],
            $ligne['modele'],
            $ligne['immatriculation'],
            (float) $ligne['prix_par_jour'],
            (bool) $ligne['disponible'],
            (int) $ligne['id']
        );
    }
}
