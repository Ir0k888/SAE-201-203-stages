-- ==============================================================================
-- INITIALISATION DE LA BASE DE DONNÉES : SAÉ GESTION DES STAGES MMI
-- ==============================================================================
CREATE DATABASE IF NOT EXISTS sae_stages_mmi CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE sae_stages_mmi;

DROP TABLE IF EXISTS Etre_jury, Prise_en_charge, Postuler, Soutenance, Stage, Recherche_de_stage, Jury_de_soutenance, Offre_de_stage, Enseignant, Etudiant;

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
    promotion VARCHAR(50) DEFAULT NULL,
    bio TEXT DEFAULT NULL,
    photo_profil VARCHAR(255) DEFAULT 'default.png',
    annee_mmi ENUM('1', '2', '3') DEFAULT NULL
) ENGINE=InnoDB;

CREATE TABLE Enseignant (
    id_enseignant INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100) NOT NULL,
    prenom VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    mot_de_passe VARCHAR(255) NOT NULL,
    role VARCHAR(255) NOT NULL DEFAULT 'Enseignant',
    statut_compte ENUM('en_attente', 'valide') DEFAULT 'en_attente',
    etablissement VARCHAR(150) DEFAULT NULL,
    numero_telephone VARCHAR(20) DEFAULT NULL,
    adresse_postale TEXT DEFAULT NULL,
    bio TEXT DEFAULT NULL,
    photo_profil VARCHAR(255) DEFAULT 'default.png'
) ENGINE=InnoDB;

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

CREATE TABLE Jury_de_soutenance (
    id_jury INT AUTO_INCREMENT PRIMARY KEY,
    numero_jury VARCHAR(50) NOT NULL
) ENGINE=InnoDB;

CREATE TABLE Recherche_de_stage (
    id_recherche INT AUTO_INCREMENT PRIMARY KEY,
    entreprise VARCHAR(150) NOT NULL,
    poste VARCHAR(150) NOT NULL,
    statut_candidature ENUM('attente', 'entretien', 'attente_validation', 'entretien_effectue', 'accepte', 'refus') DEFAULT 'attente',
    resume_entretien TEXT DEFAULT NULL,
    date_recherche TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    id_etudiant INT NOT NULL,
    FOREIGN KEY (id_etudiant) REFERENCES Etudiant(id_etudiant) ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE Prise_en_charge (
    id_etudiant INT,
    id_enseignant INT,
    annee VARCHAR(9),
    promotion VARCHAR(50),
    PRIMARY KEY (id_etudiant, id_enseignant),
    FOREIGN KEY (id_etudiant) REFERENCES Etudiant(id_etudiant) ON DELETE CASCADE,
    FOREIGN KEY (id_enseignant) REFERENCES Enseignant(id_enseignant) ON DELETE CASCADE
) ENGINE=InnoDB;

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

-- LE SEUL COMPTE PAR DÉFAUT : L'Admin
INSERT INTO Enseignant (nom, prenom, email, mot_de_passe, role, statut_compte) 
VALUES ('Admin', 'Général', 'admin@univ.fr', 'admin123', 'Administrateur', 'valide');