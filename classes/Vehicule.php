<?php

/**
 * Classe entite Vehicule
 * Represente un vehicule de l'agence (encapsulation via attributs prives).
 */
class Vehicule
{
    private ?int $id;
    private string $marque;
    private string $modele;
    private string $immatriculation;
    private float $prixParJour;
    private bool $disponible;

    public function __construct(
        string $marque,
        string $modele,
        string $immatriculation,
        float $prixParJour,
        bool $disponible = true,
        ?int $id = null
    ) {
        $this->id = $id;
        $this->marque = $marque;
        $this->modele = $modele;
        $this->immatriculation = $immatriculation;
        $this->prixParJour = $prixParJour;
        $this->disponible = $disponible;
    }

    // Getters

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMarque(): string
    {
        return $this->marque;
    }

    public function getModele(): string
    {
        return $this->modele;
    }

    public function getImmatriculation(): string
    {
        return $this->immatriculation;
    }

    public function getPrixParJour(): float
    {
        return $this->prixParJour;
    }

    public function isDisponible(): bool
    {
        return $this->disponible;
    }

    // Setters

    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    public function setMarque(string $marque): void
    {
        $this->marque = $marque;
    }

    public function setModele(string $modele): void
    {
        $this->modele = $modele;
    }

    public function setImmatriculation(string $immatriculation): void
    {
        $this->immatriculation = $immatriculation;
    }

    public function setPrixParJour(float $prixParJour): void
    {
        $this->prixParJour = $prixParJour;
    }

    public function setDisponible(bool $disponible): void
    {
        $this->disponible = $disponible;
    }
}
