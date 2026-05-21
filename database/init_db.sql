-- ==============================================================================
-- INITIALISATION DE LA BASE DE DONNÉES : SAÉ GESTION DES STAGES MMI
-- ==============================================================================
CREATE DATABASE IF NOT EXISTS sae_stages_mmi CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE sae_stages_mmi;

DROP TABLE IF EXISTS Etre_jury, Prise_en_charge, Postuler, Soutenance, Stage, Recherche_de_stage, Jury_de_soutenance, Offre_de_stage, Enseignant, Etudiant;

-- Structure de la table Etudiant
CREATE TABLE Etudiant (
    id_etudiant INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100) NOT NULL,
    prenom VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    mot_de_passe VARCHAR(255) NOT NULL,
    numero_etudiant VARCHAR(50) UNIQUE DEFAULT NULL,
    numero_telephone VARCHAR(20) DEFAULT NULL,
    adresse_postale TEXT DEFAULT NULL,
    groupe_tp VARCHAR(10) DEFAULT NULL,
    groupe_td VARCHAR(10) DEFAULT NULL,
    promotion VARCHAR(50) DEFAULT NULL
) ENGINE=InnoDB;

-- Structure de la table Enseignant
CREATE TABLE Enseignant (
    id_enseignant INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100) NOT NULL,
    prenom VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    mot_de_passe VARCHAR(255) NOT NULL,
    role VARCHAR(50) NOT NULL DEFAULT 'Enseignant',
    role_demande VARCHAR(50) DEFAULT NULL,
    statut_compte ENUM('en_attente', 'valide') DEFAULT 'en_attente',
    etablissement VARCHAR(150) DEFAULT NULL,
    numero_telephone VARCHAR(20) DEFAULT NULL,
    adresse_postale TEXT DEFAULT NULL
) ENGINE=InnoDB;

-- Structure de la table Offre_de_stage
CREATE TABLE Offre_de_stage (
    id_offre_de_stage INT AUTO_INCREMENT PRIMARY KEY,
    titre_offre VARCHAR(200) NOT NULL,
    entreprise VARCHAR(100) NOT NULL,
    description TEXT NOT NULL,
    competences TEXT DEFAULT NULL,
    remuneration VARCHAR(50) DEFAULT NULL,
    periode VARCHAR(100) DEFAULT NULL,
    contact VARCHAR(150) DEFAULT NULL
) ENGINE=InnoDB;

-- Structure de la table Jury_de_soutenance
CREATE TABLE Jury_de_soutenance (
    id_jury INT AUTO_INCREMENT PRIMARY KEY,
    numero_jury VARCHAR(50) NOT NULL
) ENGINE=InnoDB;

-- Table de liaison de recherche autonome pour les étudiants
CREATE TABLE Recherche_de_stage (
    id_recherche INT AUTO_INCREMENT PRIMARY KEY,
    entreprise VARCHAR(150) NOT NULL,
    poste VARCHAR(150) NOT NULL,
    statut_candidature ENUM('attente', 'entretien', 'refus', 'valide') DEFAULT 'attente',
    date_recherche TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    id_etudiant INT NOT NULL,
    FOREIGN KEY (id_etudiant) REFERENCES Etudiant(id_etudiant) ON DELETE CASCADE
) ENGINE=InnoDB;

-- Table d'affiliation des étudiants aux enseignants (Tuteurs)
CREATE TABLE Prise_en_charge (
    id_etudiant INT,
    id_enseignant INT,
    annee VARCHAR(9),
    promotion VARCHAR(50),
    PRIMARY KEY (id_etudiant, id_enseignant),
    FOREIGN KEY (id_etudiant) REFERENCES Etudiant(id_etudiant) ON DELETE CASCADE,
    FOREIGN KEY (id_enseignant) REFERENCES Enseignant(id_enseignant) ON DELETE CASCADE
) ENGINE=InnoDB;

-- Table de planification des soutenances
CREATE TABLE Soutenance (
    id_soutenance INT AUTO_INCREMENT PRIMARY KEY,
    date_soutenance DATE,
    horaire TIME,
    lieu VARCHAR(100),
    note_soutenance DECIMAL(4,2),
    rapport TEXT,
    statut_soutenance ENUM('en_attente', 'validee') DEFAULT 'en_attente',
    id_etudiant INT NOT NULL,
    id_enseignant INT NOT NULL,
    FOREIGN KEY (id_etudiant) REFERENCES Etudiant(id_etudiant) ON DELETE CASCADE,
    FOREIGN KEY (id_enseignant) REFERENCES Enseignant(id_enseignant) ON DELETE CASCADE
) ENGINE=InnoDB;

-- LE SEUL COMPTE PAR DÉFAUT : L'Administrateur / Chef de département (Pré-validé)
INSERT INTO Enseignant (nom, prenom, email, mot_de_passe, role, statut_compte) 
VALUES ('Admin', 'Général', 'admin@univ.fr', 'admin123', 'Administrateur', 'valide');