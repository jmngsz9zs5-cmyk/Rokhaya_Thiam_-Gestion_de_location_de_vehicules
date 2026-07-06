<?php

require_once __DIR__ . '/../config/Database.php';
require_once __DIR__ . '/Location.php';
require_once __DIR__ . '/VehiculeManager.php';

/**
 * Classe gestionnaire LocationManager
 * Realise les operations CRUD sur la table location via des requetes preparees,
 * ainsi que les fonctionnalites metier (retour, recherche, locations en cours).
 */
class LocationManager
{
    private PDO $connexion;
    private VehiculeManager $vehiculeManager;

    public function __construct()
    {
        $database = new Database();
        $this->connexion = $database->getConnexion();
        $this->vehiculeManager = new VehiculeManager();
    }

    /**
     * Enregistre une nouvelle location et rend le vehicule indisponible.
     */
    public function ajouter(Location $location): int
    {
        $sql = 'INSERT INTO location (vehicule_id, client_id, date_debut, date_fin, statut)
                VALUES (:vehicule_id, :client_id, :date_debut, :date_fin, :statut)';

        $requete = $this->connexion->prepare($sql);
        $requete->execute([
            'vehicule_id' => $location->getVehiculeId(),
            'client_id' => $location->getClientId(),
            'date_debut' => $location->getDateDebut(),
            'date_fin' => $location->getDateFin(),
            'statut' => $location->getStatut(),
        ]);

        $id = (int) $this->connexion->lastInsertId();

        $vehicule = $this->vehiculeManager->trouverParId($location->getVehiculeId());
        if ($vehicule !== null) {
            $vehicule->setDisponible(false);
            $this->vehiculeManager->modifier($vehicule);
        }

        return $id;
    }

    /**
     * Retourne la liste de toutes les locations.
     *
     * @return Location[]
     */
    public function lister(): array
    {
        $sql = 'SELECT * FROM location ORDER BY id DESC';
        $requete = $this->connexion->query($sql);

        $locations = [];
        while ($ligne = $requete->fetch(PDO::FETCH_ASSOC)) {
            $locations[] = $this->hydrater($ligne);
        }

        return $locations;
    }

    /**
     * Recherche une location par son id. Renvoie null si non trouvee.
     */
    public function trouverParId(int $id): ?Location
    {
        $sql = 'SELECT * FROM location WHERE id = :id';
        $requete = $this->connexion->prepare($sql);
        $requete->execute(['id' => $id]);

        $ligne = $requete->fetch(PDO::FETCH_ASSOC);

        return $ligne ? $this->hydrater($ligne) : null;
    }

    /**
     * Modifie une location existante.
     */
    public function modifier(Location $location): bool
    {
        $sql = 'UPDATE location
                SET vehicule_id = :vehicule_id,
                    client_id = :client_id,
                    date_debut = :date_debut,
                    date_fin = :date_fin,
                    statut = :statut
                WHERE id = :id';

        $requete = $this->connexion->prepare($sql);

        return $requete->execute([
            'vehicule_id' => $location->getVehiculeId(),
            'client_id' => $location->getClientId(),
            'date_debut' => $location->getDateDebut(),
            'date_fin' => $location->getDateFin(),
            'statut' => $location->getStatut(),
            'id' => $location->getId(),
        ]);
    }

    /**
     * Supprime une location par son id.
     */
    public function supprimer(int $id): bool
    {
        $sql = 'DELETE FROM location WHERE id = :id';
        $requete = $this->connexion->prepare($sql);

        return $requete->execute(['id' => $id]);
    }

    /**
     * Marque le retour du vehicule : la location passe a "terminee"
     * et le vehicule redevient disponible.
     */
    public function marquerRetour(int $id): bool
    {
        $location = $this->trouverParId($id);
        if ($location === null) {
            return false;
        }

        $location->setStatut('terminee');
        $resultat = $this->modifier($location);

        $vehicule = $this->vehiculeManager->trouverParId($location->getVehiculeId());
        if ($vehicule !== null) {
            $vehicule->setDisponible(true);
            $this->vehiculeManager->modifier($vehicule);
        }

        return $resultat;
    }

    /**
     * Indique si au moins une location est liee a ce vehicule.
     */
    public function possedeLocationsPourVehicule(int $vehiculeId): bool
    {
        $sql = 'SELECT COUNT(*) FROM location WHERE vehicule_id = :vehicule_id';
        $requete = $this->connexion->prepare($sql);
        $requete->execute(['vehicule_id' => $vehiculeId]);

        return (int) $requete->fetchColumn() > 0;
    }

    /**
     * Indique si au moins une location est liee a ce client.
     */
    public function possedeLocationsPourClient(int $clientId): bool
    {
        $sql = 'SELECT COUNT(*) FROM location WHERE client_id = :client_id';
        $requete = $this->connexion->prepare($sql);
        $requete->execute(['client_id' => $clientId]);

        return (int) $requete->fetchColumn() > 0;
    }

    /**
     * Retourne la liste des locations dont le statut est "en cours".
     *
     * @return Location[]
     */
    public function listerEnCours(): array
    {
        $sql = "SELECT * FROM location WHERE statut = 'en cours' ORDER BY date_debut DESC";
        $requete = $this->connexion->query($sql);

        $locations = [];
        while ($ligne = $requete->fetch(PDO::FETCH_ASSOC)) {
            $locations[] = $this->hydrater($ligne);
        }

        return $locations;
    }

    /**
     * Recherche les locations dont le vehicule correspond a une marque donnee.
     *
     * @return array liste associative (location + infos vehicule/client)
     */
    public function rechercherParMarque(string $marque): array
    {
        $sql = "SELECT l.*, v.marque, v.modele, c.nom AS client_nom
                FROM location l
                INNER JOIN vehicule v ON v.id = l.vehicule_id
                INNER JOIN client c ON c.id = l.client_id
                WHERE v.marque LIKE :marque
                ORDER BY l.date_debut DESC";

        $requete = $this->connexion->prepare($sql);
        $requete->execute(['marque' => '%' . $marque . '%']);

        return $requete->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Recherche les locations d'un client dont le nom correspond.
     *
     * @return array liste associative (location + infos vehicule/client)
     */
    public function rechercherParClient(string $nomClient): array
    {
        $sql = "SELECT l.*, v.marque, v.modele, c.nom AS client_nom
                FROM location l
                INNER JOIN vehicule v ON v.id = l.vehicule_id
                INNER JOIN client c ON c.id = l.client_id
                WHERE c.nom LIKE :nom
                ORDER BY l.date_debut DESC";

        $requete = $this->connexion->prepare($sql);
        $requete->execute(['nom' => '%' . $nomClient . '%']);

        return $requete->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Transforme une ligne de resultat SQL en objet Location.
     */
    private function hydrater(array $ligne): Location
    {
        return new Location(
            (int) $ligne['vehicule_id'],
            (int) $ligne['client_id'],
            $ligne['date_debut'],
            $ligne['date_fin'],
            $ligne['statut'],
            (int) $ligne['id']
        );
    }
}
