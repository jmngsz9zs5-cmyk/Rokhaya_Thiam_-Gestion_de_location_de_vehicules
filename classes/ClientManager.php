<?php

require_once __DIR__ . '/../config/Database.php';
require_once __DIR__ . '/Client.php';

/**
 * Classe gestionnaire ClientManager
 * Realise les operations CRUD sur la table client via des requetes preparees.
 */
class ClientManager
{
    private PDO $connexion;

    public function __construct()
    {
        $database = new Database();
        $this->connexion = $database->getConnexion();
    }

    /**
     * Ajoute un nouveau client en base et renvoie son id.
     */
    public function ajouter(Client $client): int
    {
        $sql = 'INSERT INTO client (nom, telephone) VALUES (:nom, :telephone)';

        $requete = $this->connexion->prepare($sql);
        $requete->execute([
            'nom' => $client->getNom(),
            'telephone' => $client->getTelephone(),
        ]);

        return (int) $this->connexion->lastInsertId();
    }

    /**
     * Retourne la liste de tous les clients.
     *
     * @return Client[]
     */
    public function lister(): array
    {
        $sql = 'SELECT * FROM client ORDER BY id DESC';
        $requete = $this->connexion->query($sql);

        $clients = [];
        while ($ligne = $requete->fetch(PDO::FETCH_ASSOC)) {
            $clients[] = $this->hydrater($ligne);
        }

        return $clients;
    }

    /**
     * Recherche un client par son id. Renvoie null si non trouve.
     */
    public function trouverParId(int $id): ?Client
    {
        $sql = 'SELECT * FROM client WHERE id = :id';
        $requete = $this->connexion->prepare($sql);
        $requete->execute(['id' => $id]);

        $ligne = $requete->fetch(PDO::FETCH_ASSOC);

        return $ligne ? $this->hydrater($ligne) : null;
    }

    /**
     * Modifie un client existant.
     */
    public function modifier(Client $client): bool
    {
        $sql = 'UPDATE client SET nom = :nom, telephone = :telephone WHERE id = :id';

        $requete = $this->connexion->prepare($sql);

        return $requete->execute([
            'nom' => $client->getNom(),
            'telephone' => $client->getTelephone(),
            'id' => $client->getId(),
        ]);
    }

    /**
     * Supprime un client par son id.
     */
    public function supprimer(int $id): bool
    {
        $sql = 'DELETE FROM client WHERE id = :id';
        $requete = $this->connexion->prepare($sql);

        return $requete->execute(['id' => $id]);
    }

    /**
     * Transforme une ligne de resultat SQL en objet Client.
     */
    private function hydrater(array $ligne): Client
    {
        return new Client(
            $ligne['nom'],
            $ligne['telephone'],
            (int) $ligne['id']
        );
    }
}
