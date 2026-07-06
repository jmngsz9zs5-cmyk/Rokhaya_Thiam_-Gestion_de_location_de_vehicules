-- Script de creation de la base de donnees
-- Projet : Gestion de location de vehicules

CREATE DATABASE IF NOT EXISTS gestion_location_vehicules
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_unicode_ci;

USE gestion_location_vehicules;

-- Table des vehicules
CREATE TABLE IF NOT EXISTS vehicule (
    id INT AUTO_INCREMENT PRIMARY KEY,
    marque VARCHAR(50) NOT NULL,
    modele VARCHAR(50) NOT NULL,
    immatriculation VARCHAR(20) NOT NULL UNIQUE,
    prix_par_jour DECIMAL(10,2) NOT NULL,
    disponible TINYINT(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB;

-- Table des clients
CREATE TABLE IF NOT EXISTS client (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100) NOT NULL,
    telephone VARCHAR(20) NOT NULL
) ENGINE=InnoDB;

-- Table des locations
CREATE TABLE IF NOT EXISTS location (
    id INT AUTO_INCREMENT PRIMARY KEY,
    vehicule_id INT NOT NULL,
    client_id INT NOT NULL,
    date_debut DATE NOT NULL,
    date_fin DATE NOT NULL,
    statut ENUM('en cours', 'terminee') NOT NULL DEFAULT 'en cours',
    CONSTRAINT fk_location_vehicule FOREIGN KEY (vehicule_id) REFERENCES vehicule(id),
    CONSTRAINT fk_location_client FOREIGN KEY (client_id) REFERENCES client(id)
) ENGINE=InnoDB;
