-- ==============================================================================
-- INITIALISATION DE LA BASE DE DONNÉES : SAÉ GESTION DES STAGES MMI
-- ==============================================================================

CREATE DATABASE IF NOT EXISTS sae_stages_mmi CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE sae_stages_mmi;

-- ==============================================================================
-- NETTOYAGE
-- ==============================================================================
DROP TABLE IF EXISTS Etre_jury, Prise_en_charge, Postuler, Soutenance, Stage, Recherche_de_stage, Jury_de_soutenance, Offre_de_stage, Enseignant, Etudiant;

-- ==============================================================================
-- CRÉATION DES TABLES PRINCIPALES
-- ==============================================================================

CREATE TABLE Etudiant (
    id_etudiant INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100), 
    prenom VARCHAR(100),
    email VARCHAR(150) NOT NULL UNIQUE,
    mot_de_passe VARCHAR(255) NOT NULL,
    numero_etudiant VARCHAR(50) UNIQUE,
    numero_telephone VARCHAR(20),
    adresse_postale TEXT,
    groupe_tp VARCHAR(10),
    groupe_td VARCHAR(10),
    promotion VARCHAR(50)
);

CREATE TABLE Enseignant (
    id_enseignant INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100), 
    prenom VARCHAR(100),
    email VARCHAR(150) NOT NULL UNIQUE,
    mot_de_passe VARCHAR(255) NOT NULL,
    role VARCHAR(50) NOT NULL,
    -- NOUVEAU : Gestion des validations par l'admin
    statut_compte ENUM('en_attente', 'valide') DEFAULT 'en_attente',
    etablissement VARCHAR(150),
    numero_telephone VARCHAR(20),
    adresse_postale TEXT
);

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
-- CRÉATION DES TABLES LIÉES
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

CREATE TABLE Postuler (
    id_etudiant INT, id_offre_de_stage INT,
    PRIMARY KEY (id_etudiant, id_offre_de_stage),
    FOREIGN KEY (id_etudiant) REFERENCES Etudiant(id_etudiant) ON DELETE CASCADE,
    FOREIGN KEY (id_offre_de_stage) REFERENCES Offre_de_stage(id_offre_de_stage) ON DELETE CASCADE
);

CREATE TABLE Prise_en_charge (
    id_etudiant INT, id_enseignant INT, annee VARCHAR(9), promotion VARCHAR(50),
    PRIMARY KEY (id_etudiant, id_enseignant),
    FOREIGN KEY (id_etudiant) REFERENCES Etudiant(id_etudiant) ON DELETE CASCADE,
    FOREIGN KEY (id_enseignant) REFERENCES Enseignant(id_enseignant) ON DELETE CASCADE
);

CREATE TABLE Etre_jury (
    id_enseignant INT, id_jury INT,
    PRIMARY KEY (id_enseignant, id_jury),
    FOREIGN KEY (id_enseignant) REFERENCES Enseignant(id_enseignant) ON DELETE CASCADE,
    FOREIGN KEY (id_jury) REFERENCES Jury_de_soutenance(id_jury) ON DELETE CASCADE
);

-- ==============================================================================
-- JEU D'ESSAI (DONNÉES DE TEST)
-- ==============================================================================

-- Compte Étudiant de base (Auto-validé par nature)
INSERT INTO Etudiant (nom, prenom, email, mot_de_passe, numero_etudiant) 
VALUES ('Dupont', 'Jean', 'etudiant@univ.fr', 'etudiant123', '20245678');

-- LE COMPTE ADMINISTRATEUR UNIQUE (Créé en base, valide d'office)
INSERT INTO Enseignant (nom, prenom, email, mot_de_passe, role, statut_compte) 
VALUES ('Admin', 'Général', 'admin@univ.fr', 'admin123', 'Administrateur', 'valide');

-- Autres comptes de test (Validés pour pouvoir tester la connexion direct)
INSERT INTO Enseignant (nom, prenom, email, mot_de_passe, role, statut_compte) VALUES 
('Martin', 'Sophie', 'prof@univ.fr', 'enseignant123', 'Enseignant', 'valide'),
('Durand', 'Paul', 'chef@univ.fr', 'chef123', 'Chef de departement', 'valide');

-- Un compte de test "En attente" (Pour tester qu'il ne peut pas se connecter)
INSERT INTO Enseignant (nom, prenom, email, mot_de_passe, role, statut_compte) VALUES 
('Nouveau', 'Prof', 'nouveau@univ.fr', 'prof123', 'Enseignant', 'en_attente');