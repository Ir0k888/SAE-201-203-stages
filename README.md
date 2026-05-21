# SAÉ 201/203 - Plateforme de Gestion des Stages MMI

## Présentation du projet
Ce projet consiste à créer une application web complète permettant de gérer le suivi des stages pour le département MMI de l'IUT de Meaux. L'objectif est de remplacer l'outil actuel (ESUP) par une solution centralisée, moderne et interactive gérant les offres, les candidatures, le suivi des recherches, les évaluations et la planification des soutenances.

## Stack Technique
* **Front-end :** HTML5, CSS3, JavaScript natif, Tailwind CSS (via CDN et fichier de configuration personnalisé).
* **Back-end :** PHP natif (Architecture orientée actions/traitements).
* **Base de données :** MySQL (PDO, requêtes préparées, encodage UTF-8).
* **Hébergement cibles :** AlwaysData, InfinityFree, O2Switch.
* **Versionning :** Git / GitHub.

## Acteurs, Rôles et Permissions (RBAC)
L'application intègre un système d'authentification robuste avec routage intelligent par email (@etudiant.univ.fr vs @univ.fr) et un système de cumul des rôles pour le personnel pédagogique :

* **Étudiant :** Gestion du profil, suivi dynamique du pipeline de candidature (ajout, compte-rendu d'entretien, acceptation d'offre), consultation des dates de soutenance.
* **Enseignant (Tuteur) :** Rôle de base post-inscription (nécessite validation Admin). Affichage de la liste de ses étudiants affiliés, proposition de dates et lieux de soutenances.
* **Responsable de stage :** Rôle à hautes responsabilités. Validation des démarches étudiantes (déblocage des entretiens, validation finale des stages), affiliation manuelle des tuteurs aux étudiants, approbation des dates de soutenance proposées par les enseignants.
* **Membre du jury :** Rôle cumulable permettant l'évaluation (Consultation/Saisie des notes prévues dans le scope futur).
* **Administrateur :** Modération pure du système. Validation des nouveaux comptes enseignants, et approbation des demandes d'évolution de rôles (cumulables via le profil).

## Le Workflow Pédagogique (Pipeline des stages)
Le système informatique calque le processus réel de l'IUT :
1. **Déclaration :** L'étudiant déclare une piste de stage (Entreprise/Poste).
2. **Entretien :** Le Responsable de stage valide la pertinence et passe le statut en "Entretien".
3. **Compte-rendu :** L'étudiant saisit un résumé de son entretien.
4. **Validation :** Le Responsable va lire le résumé et débloque l'offre.
5. **Acceptation :** L'étudiant accepte officiellement le stage sur son espace.
6. **Affiliation :** Le Responsable assigne un Enseignant tuteur à cet étudiant.
7. **Planification :** L'Enseignant tuteur propose une date de soutenance.
8. **Confirmation :** Le Responsable valide la date, qui apparaît enfin sur le dashboard de l'étudiant.

## Charte Graphique & UI/UX
* **Framework :** 
* **Couleur Principale (Brand) :** 
* **Couleur d'Accent :** 
* **Animations :** 

## Arborescence du projet
Structure des dossiers basée sur la séparation logique (Vues vs Traitements) :

```text
sae-stages/
├── actions/                           # Scripts PHP de traitement pur (Sécurité, SQL, Redirections)
│   ├── admin_stages_action.php        # Changement de statuts des stages et affiliation des tuteurs
│   ├── demande_role_action.php        # Traitement du cumul des rôles demandés par les profs
│   ├── etudiant_recherche_action.php  # Ajout, résumé et acceptation des offres côté étudiant
│   ├── login_action.php               # Routage de la connexion et création des sessions
│   ├── logout_action.php              # Destruction propre de la session
│   ├── proposer_soutenance_action.ph  p # Insertion d'une date en attente par le tuteur
│   ├── register_action.php            # Inscription avec filtrage regex sur l'email
│   ├── valider_compte_action.php      # Validation des comptes et rôles par l'Admin
│   └── valider_soutenance_action.php  # Validation finale des dates par le Responsable
│   
├── assets/                            # Ressources statiques frontend
│   ├── css/   
│   │   └── style.css                  # Animations (Reveal) et classes custom non-Tailwind
│   └── js/   
│       ├── script.js                  # Modals, Burger menu, animations
│       └── tailwind.config.js         # Configuration centralisée de la charte graphique
│   
├── config/                      
│   └── database.php                   # Connexion PDO centralisée (gestion d'erreurs)
│   
├── database/                    
│   └── init_db.sql                    # MCD traduit en SQL, création des tables et compte Admin natif
│   
├── pages/                             # Vues spécifiques protégées par "Videurs" de session
│   ├── gestion_soutenances.php        # (Resp) Validation des dates proposées par les tuteurs
│   ├── gestion_stages.php             # (Resp) Pipeline de validation des candidatures
│   ├── offres.php                     # (Étu) Liste globale des offres validées
│   ├── profil.php                     # (Tous) Consultation infos et système de demande de rôles (Profs)
│   ├── soutenances.php                # (Étu) Affichage de la convocation et des notes
│   ├── suivi-recherches.php           # (Étu) Dashboard interactif des démarches de l'élève
│   ├── suivi_etudiants.php            # (Prof) Visualisation des élèves affiliés et planification
│   └── validation_comptes.php         # (Admin) Centre de modération des utilisateurs
│   
├── index.php                          # Hub d'accueil dynamique (s'adapte au rôle de la session)
└── login.php                          # Interface UI double-panneau (Connexion / Inscription)