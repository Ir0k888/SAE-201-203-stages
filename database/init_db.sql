-- ==============================================================================
-- INITIALISATION DE LA BASE DE DONNÉES : SAÉ GESTION DES STAGES MMI
-- ==============================================================================

-- 1. Création de la base et sélection
CREATE DATABASE IF NOT EXISTS sae_stages_mmi CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE sae_stages_mmi;

-- ==============================================================================
-- 2. NETTOYAGE DE LA BASE (Drop dans l'ordre inverse des contraintes)
-- ==============================================================================
DROP TABLE IF EXISTS Etre_jury;
DROP TABLE IF EXISTS Prise_en_charge;
DROP TABLE IF EXISTS Postuler;
DROP TABLE IF EXISTS Soutenance;
DROP TABLE IF EXISTS Stage;
DROP TABLE IF EXISTS Recherche_de_stage;
DROP TABLE IF EXISTS Jury_de_soutenance;
DROP TABLE IF EXISTS Offre_de_stage;
DROP TABLE IF EXISTS Enseignant;
DROP TABLE IF EXISTS Etudiant;

-- ==============================================================================
-- 3. CRÉATION DES TABLES PRINCIPALES (Sans clés étrangères)
-- ==============================================================================

CREATE TABLE Etudiant (
    id_etudiant INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100) NOT NULL,
    prenom VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    mot_de_passe VARCHAR(255) NOT NULL,
    numero_etudiant VARCHAR(50) NOT NULL UNIQUE,
    numero_telephone VARCHAR(20),
    adresse_postale TEXT,
    groupe_tp VARCHAR(10),
    groupe_td VARCHAR(10),
    promotion VARCHAR(50)
);

CREATE TABLE Enseignant (
    id_enseignant INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100) NOT NULL,
    prenom VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    mot_de_passe VARCHAR(255) NOT NULL,
    etablissement VARCHAR(150),
    numero_telephone VARCHAR(20),
    adresse_postale TEXT,
    role ENUM('Responsable de stage', 'Enseignant', 'Maitre de stage', 'Chef de departement', 'Administrateur') NOT NULL
);

INSERT INTO Etudiant (email, mot_de_passe) VALUES ('etudiant@univ.fr', 'etudiant123');
INSERT INTO Enseignant (email, mot_de_passe, role) VALUES 
('enseignant@univ.fr', 'enseignant123', 'Enseignant'),
('resp@univ.fr', 'resp123', 'Responsable de stage'),
('chef@univ.fr', 'chef123', 'Chef de departement'),
('admin@univ.fr', 'admin123', 'Administrateur');

CREATE TABLE Offre_de_stage (
    id_offre_de_stage INT AUTO_INCREMENT PRIMARY KEY,
    titre_offre VARCHAR(200) NOT NULL,
    description TEXT NOT NULL
);

CREATE TABLE Jury_de_soutenance (
    id_jury INT AUTO_INCREMENT PRIMARY KEY,
    numero_jury VARCHAR(50) NOT NULL
);

-- ==============================================================================
-- 4. CRÉATION DES TABLES AVEC CLÉS ÉTRANGÈRES
-- ==============================================================================

CREATE TABLE Recherche_de_stage (
    id_recherche INT AUTO_INCREMENT PRIMARY KEY,
    contact_entreprise VARCHAR(150),
    statut_candidature VARCHAR(50),
    date_recherche DATE,
    id_etudiant INT NOT NULL,
    FOREIGN KEY (id_etudiant) REFERENCES Etudiant(id_etudiant) ON DELETE CASCADE
);

CREATE TABLE Stage (
    id_stage INT AUTO_INCREMENT PRIMARY KEY,
    description TEXT,
    competence_requise TEXT,
    duree VARCHAR(50),
    lieu VARCHAR(150),
    date_debut DATE,
    date_fin DATE,
    id_etudiant INT NOT NULL,
    id_offre_de_stage INT,
    id_enseignant INT,
    FOREIGN KEY (id_etudiant) REFERENCES Etudiant(id_etudiant) ON DELETE CASCADE,
    FOREIGN KEY (id_offre_de_stage) REFERENCES Offre_de_stage(id_offre_de_stage) ON DELETE SET NULL,
    FOREIGN KEY (id_enseignant) REFERENCES Enseignant(id_enseignant) ON DELETE SET NULL
);

CREATE TABLE Soutenance (
    id_soutenance INT AUTO_INCREMENT PRIMARY KEY,
    date_soutenance DATE,
    horaire TIME,
    lieu VARCHAR(100),
    note_soutenance DECIMAL(4,2),
    rapport TEXT,
    id_etudiant INT NOT NULL,
    id_jury INT NOT NULL,
    FOREIGN KEY (id_etudiant) REFERENCES Etudiant(id_etudiant) ON DELETE CASCADE,
    FOREIGN KEY (id_jury) REFERENCES Jury_de_soutenance(id_jury) ON DELETE CASCADE
);

-- ==============================================================================
-- 5. CRÉATION DES TABLES DE LIAISON
-- ==============================================================================

CREATE TABLE Postuler (
    id_etudiant INT,
    id_offre_de_stage INT,
    PRIMARY KEY (id_etudiant, id_offre_de_stage),
    FOREIGN KEY (id_etudiant) REFERENCES Etudiant(id_etudiant) ON DELETE CASCADE,
    FOREIGN KEY (id_offre_de_stage) REFERENCES Offre_de_stage(id_offre_de_stage) ON DELETE CASCADE
);

CREATE TABLE Prise_en_charge (
    id_etudiant INT,
    id_enseignant INT,
    annee VARCHAR(9),
    promotion VARCHAR(50),
    PRIMARY KEY (id_etudiant, id_enseignant),
    FOREIGN KEY (id_etudiant) REFERENCES Etudiant(id_etudiant) ON DELETE CASCADE,
    FOREIGN KEY (id_enseignant) REFERENCES Enseignant(id_enseignant) ON DELETE CASCADE
);

CREATE TABLE Etre_jury (
    id_enseignant INT,
    id_jury INT,
    PRIMARY KEY (id_enseignant, id_jury),
    FOREIGN KEY (id_enseignant) REFERENCES Enseignant(id_enseignant) ON DELETE CASCADE,
    FOREIGN KEY (id_jury) REFERENCES Jury_de_soutenance(id_jury) ON DELETE CASCADE
);

-- ==============================================================================
-- 6. JEU D'ESSAI : GÉNÉRATION DES COMPTES ET DONNÉES TYPES (Mdp: password123)
-- ==============================================================================

-- Compte Étudiant (id: 1)
INSERT INTO Etudiant (nom, prenom, email, mot_de_passe, numero_etudiant, groupe_tp, groupe_td, promotion) 
VALUES ('Dupont', 'Jean', 'etudiant@univ.fr', 'password123', '20245678', 'TP3', 'TD2', 'MMI 2');

-- Comptes Enseignants et Staff (ids: 1 à 5)
INSERT INTO Enseignant (nom, prenom, email, mot_de_passe, role) VALUES 
('Martin', 'Sophie', 'admin@univ.fr', 'password123', 'Administrateur'),
('Durand', 'Paul', 'chef@univ.fr', 'password123', 'Chef de departement'),
('Lefevre', 'Marc', 'resp.stage@univ.fr', 'password123', 'Responsable de stage'),
('Bernard', 'Julie', 'prof@univ.fr', 'password123', 'Enseignant'),
('Dubois', 'Luc', 'tuteur.entreprise@pro.fr', 'password123', 'Maitre de stage');

-- Création d'un Jury type (id: 1)
INSERT INTO Jury_de_soutenance (numero_jury) VALUES ('Jury MMI - Groupe A');

-- Affectation de 2 profs au Jury 1 (respect de la consigne)
INSERT INTO Etre_jury (id_enseignant, id_jury) VALUES 
(4, 1), -- Julie Bernard (Prof)
(3, 1); -- Marc Lefevre (Resp. Stage)

-- Création d'une soutenance de test pour l'étudiant 1, évalué par le jury 1
INSERT INTO Soutenance (date_soutenance, horaire, lieu, id_etudiant, id_jury) 
VALUES ('2026-06-15', '14:00:00', 'Amphithéâtre B104', 1, 1);