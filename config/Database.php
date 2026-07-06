<?php

/**
 * Classe Database
 * Gere la connexion PDO a la base de donnees (centralisee et reutilisable).
 */
class Database
{
    private string $host = 'localhost';
    private string $dbname = 'gestion_location_vehicules';
    private string $user = 'root';
    private string $password = '';
    private ?PDO $connexion = null;

    /**
     * Retourne l'instance PDO. La connexion n'est etablie qu'une seule fois.
     */
    public function getConnexion(): PDO
    {
        if ($this->connexion === null) {
            $dsn = "mysql:host={$this->host};dbname={$this->dbname};charset=utf8mb4";

            try {
                $this->connexion = new PDO($dsn, $this->user, $this->password);
                $this->connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                die('Erreur de connexion a la base de donnees : ' . $e->getMessage());
            }
        }

        return $this->connexion;
    }
}
