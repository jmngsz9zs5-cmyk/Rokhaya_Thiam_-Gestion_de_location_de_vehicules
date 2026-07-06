<?php

/**
 * Classe entite Client
 * Represente un client de l'agence (encapsulation via attributs prives).
 */
class Client
{
    private ?int $id;
    private string $nom;
    private string $telephone;

    public function __construct(string $nom, string $telephone, ?int $id = null)
    {
        $this->id = $id;
        $this->nom = $nom;
        $this->telephone = $telephone;
    }

    // Getters

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): string
    {
        return $this->nom;
    }

    public function getTelephone(): string
    {
        return $this->telephone;
    }

    // Setters

    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    public function setNom(string $nom): void
    {
        $this->nom = $nom;
    }

    public function setTelephone(string $telephone): void
    {
        $this->telephone = $telephone;
    }
}
