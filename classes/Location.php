<?php

/**
 * Classe entite Location
 * Represente la location d'un vehicule par un client (encapsulation via attributs prives).
 */
class Location
{
    private ?int $id;
    private int $vehiculeId;
    private int $clientId;
    private string $dateDebut;
    private string $dateFin;
    private string $statut;

    public function __construct(
        int $vehiculeId,
        int $clientId,
        string $dateDebut,
        string $dateFin,
        string $statut = 'en cours',
        ?int $id = null
    ) {
        $this->id = $id;
        $this->vehiculeId = $vehiculeId;
        $this->clientId = $clientId;
        $this->dateDebut = $dateDebut;
        $this->dateFin = $dateFin;
        $this->statut = $statut;
    }

    // Getters

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getVehiculeId(): int
    {
        return $this->vehiculeId;
    }

    public function getClientId(): int
    {
        return $this->clientId;
    }

    public function getDateDebut(): string
    {
        return $this->dateDebut;
    }

    public function getDateFin(): string
    {
        return $this->dateFin;
    }

    public function getStatut(): string
    {
        return $this->statut;
    }

    // Setters

    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    public function setVehiculeId(int $vehiculeId): void
    {
        $this->vehiculeId = $vehiculeId;
    }

    public function setClientId(int $clientId): void
    {
        $this->clientId = $clientId;
    }

    public function setDateDebut(string $dateDebut): void
    {
        $this->dateDebut = $dateDebut;
    }

    public function setDateFin(string $dateFin): void
    {
        $this->dateFin = $dateFin;
    }

    public function setStatut(string $statut): void
    {
        $this->statut = $statut;
    }
}
