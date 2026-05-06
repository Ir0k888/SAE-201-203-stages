--Création de la base de données
CREATE DATABASE sae_stage_complet;
USE sae_stage_complet;

--Table Administrateur
CREATE TABLE administrateurs (
    id VARCHAR(50) PRIMARY KEY,
    pwd_admin VARCHAR(255) NOT NULL
);

--Table Utilisateur
CREATE TABLE utilisateurs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    droit_modif BOOLEAN DEFAULT FALSE,
    role ENUM('etudiant', 'enseignant') NOT NULL
);

--Table Entreprise
CREATE TABLE entreprises (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(150) NOT NULL,
    ville VARCHAR(100)
);

--Table Enseignant
CREATE TABLE enseignants (
    id INT AUTO_INCREMENT PRIMARY KEY,
    utilisateur_id INT,
    entreprise_id INT,
    nom VARCHAR(100),
    prenom VARCHAR(100),
    etablissement VARCHAR(150),
    num_telephone VARCHAR(20),
    FOREIGN KEY (utilisateur_id) REFERENCES utilisateurs(id),
    FOREIGN KEY (entreprise_id) REFERENCES entreprises(id)
);

--Table Étudiant
CREATE TABLE etudiants (
    id INT AUTO_INCREMENT PRIMARY KEY,
    utilisateur_id INT,
    nom VARCHAR(100),
    prenom VARCHAR(100),
    etablissement VARCHAR(150),

    description_probleme VARCHAR(100),
    date_probleme VARCHAR(100),
    FOREIGN KEY (utilisateur_id) REFERENCES utilisateurs(id)
);

--Table Stage
CREATE TABLE stages (
    id INT AUTO_INCREMENT PRIMARY KEY,
    etudiant_id INT,
    maitre_stage_id INT,
    _offre VARCHAR(255),
    description_offre TEXT,
    remuneration_offre DECIMAL(10,2),
    competences_offre TEXT,
    lieu_offre VARCHAR(150),
    date_offre DATE,
    contact_entreprise_offre VARCHAR(150),

    convention_signe BOOLEAN DEFAULT FALSE,

    date_soutenance DATETIME,
    lieu_soutenance VARCHAR(150),
    FOREIGN KEY (etudiant_id) REFERENCES etudiants(id),
    FOREIGN KEY (maitre_stage_id) REFERENCES maitres_stage(id)
);