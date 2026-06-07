CREATE DATABASE IF NOT EXISTS sae_stages_mmi CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE sae_stages_mmi;

DROP TABLE IF EXISTS Prise_en_charge, Soutenance, Recherche_de_stage, Offre_de_stage, Enseignant, Etudiant, Jury_de_soutenance;

CREATE TABLE Etudiant (
    id_etudiant INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100) NOT NULL,
    prenom VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    mot_de_passe VARCHAR(255) NOT NULL,
    numero_etudiant VARCHAR(50) UNIQUE DEFAULT NULL,
    numero_telephone VARCHAR(20) DEFAULT NULL,
    adresse_postale TEXT DEFAULT NULL,
    date_naissance DATE DEFAULT NULL,
    lieu_naissance VARCHAR(100) DEFAULT NULL,
    groupe_tp VARCHAR(10) DEFAULT NULL,
    groupe_td VARCHAR(10) DEFAULT NULL,
    promotion VARCHAR(50) DEFAULT NULL,
    bio TEXT DEFAULT NULL,
    photo_profil VARCHAR(255) DEFAULT 'default.png',
    politique_acceptee TINYINT(1) DEFAULT 0
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
    photo_profil VARCHAR(255) DEFAULT 'default.png',
    politique_acceptee TINYINT(1) DEFAULT 0
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

CREATE TABLE Recherche_de_stage (
    id_recherche INT AUTO_INCREMENT PRIMARY KEY,
    entreprise VARCHAR(150) NOT NULL,
    poste VARCHAR(150) NOT NULL,
    statut_candidature ENUM('attente', 'entretien', 'attente_validation', 'entretien_effectue', 'accepte', 'refus') DEFAULT 'attente',
    resume_entretien TEXT DEFAULT NULL,
    piece_jointe VARCHAR(255) DEFAULT NULL,
    date_recherche TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    id_etudiant INT NOT NULL,
    FOREIGN KEY (id_etudiant) REFERENCES Etudiant(id_etudiant) ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE Prise_en_charge (
    id_etudiant INT,
    id_enseignant INT,
    annee VARCHAR(9),
    PRIMARY KEY (id_etudiant, id_enseignant),
    FOREIGN KEY (id_etudiant) REFERENCES Etudiant(id_etudiant) ON DELETE CASCADE,
    FOREIGN KEY (id_enseignant) REFERENCES Enseignant(id_enseignant) ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE Soutenance (
    id_soutenance INT AUTO_INCREMENT PRIMARY KEY,
    date_soutenance DATE,
    horaire TIME,
    lieu VARCHAR(100),
    statut_soutenance ENUM('en_attente', 'validee') DEFAULT 'en_attente',
    id_etudiant INT NOT NULL,
    id_enseignant INT NOT NULL,
    FOREIGN KEY (id_etudiant) REFERENCES Etudiant(id_etudiant) ON DELETE CASCADE,
    FOREIGN KEY (id_enseignant) REFERENCES Enseignant(id_enseignant) ON DELETE CASCADE
) ENGINE=InnoDB;

INSERT INTO Enseignant (nom, prenom, email, mot_de_passe, role, statut_compte, politique_acceptee) 
VALUES ('Admin', 'Général', 'admin@univ.fr', 'admin123', 'Administrateur', 'valide', 1);

INSERT INTO Offre_de_stage (titre_offre, entreprise, description, remuneration, periode, contact) VALUES 
('Développeur Front-End Vue.js', 'TechVision', 'Rejoignez notre équipe pour développer des interfaces web innovantes. Maîtrise de HTML, CSS, JS et Vue.js requise. Télétravail partiel possible.', '800€ / mois', 'Avril - Juin', 'rh@techvision.com'),
('Assistant Webmarketing & SEO', 'DigitalBoost', 'Nous recherchons un profil créatif pour gérer nos campagnes SEO/SEA et animer nos réseaux sociaux. Excellente plume exigée.', '650€ / mois', 'Mai - Juillet', 'contact@digitalboost.fr'),
('UI/UX Designer', 'CreativeStudio', 'Vous participerez à la refonte de nos applications mobiles. Prototypage sur Figma, tests utilisateurs et design system.', '700€ / mois', 'Avril - Juin', 'jobs@creativestudio.com'),
('Développeur Back-End PHP/Symfony', 'WebAgency Paris', 'Mission de développement sur un projet e-commerce. Connaissance de PHP 8, Symfony et MySQL.', '900€ / mois', 'Mars - Mai', 'recrutement@webagency.paris'),
('Motion Designer Junior', 'AnimPix', 'Création d''animations 2D/3D pour nos clients institutionnels. After Effects et Premiere Pro sont vos meilleurs amis.', 'Légale', 'Mai - Août', 'hello@animpix.studio'),
('Chef de Projet Digital', 'InnovGroup', 'Assistance au pilotage de projets web : rédaction de cahier des charges, suivi des plannings, recette et relation client.', '850€ / mois', 'Avril - Septembre', 'talent@innovgroup.com');