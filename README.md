# SAÉ 201/203 - Plateforme de Gestion des Stages MMI

## Ce Projet a été réalisé par Alexis Dumoulin et Matt Rudman MMI1 TD2

## Présentation du projet
Ce projet consiste à créer une application web complète permettant de gérer le suivi des stages pour le département MMI de l'IUT de Meaux. L'objectif est de remplacer l'outil actuel (ESUP) par une solution centralisée, moderne et interactive gérant les offres, les candidatures, le suivi des recherches, les évaluations et la planification des soutenances.

---

## Stack Technique
* **Front-end :** HTML5, CSS3, JavaScript natif, Tailwind CSS (via CDN).
* **Back-end :** PHP natif (Architecture orientée actions/traitements).
* **Base de données :** MySQL (PDO, requêtes préparées, encodage UTF-8).
* **Versionning :** Git / GitHub.

---

## Charte Graphique & UI/UX
* **Framework :** Tailwind CSS.
* **Police :** Poppins.
* **Style Global :** Design épuré façon "Notion", fond gris clair/bleuté (`bg-slate-50`), composants sur fond blanc avec des bordures nettes et épaisses (`border-2 border-slate-200`) pour une lisibilité maximale.
* **Couleur d'Accent :** Rose/Rouge (`#FD3956`) pour les actions principales, avec un effet au survol plus sombre (`#651617`).
* **Ergonomie :** Fenêtres modales plein écran (Règlement, Mentions Légales, Détails des offres) et gestion d'erreurs visuelles.

---

## Acteurs, Rôles et Permissions (RBAC)
L'application intègre un système d'authentification robuste avec routage intelligent par email (`@etudiant.univ.fr` vs `@univ.fr`).

* **Étudiant :** * Gestion du profil complet.
  * Acceptation obligatoire de la politique de confidentialité (RGPD) avant toute navigation.
  * Consultation du catalogue d'offres et candidature avec upload de CV au format PDF.
  * Suivi dynamique du statut des candidatures et acceptation/refus des offres validées.
  * Consultation des détails de la convocation à la soutenance.
* **Professeur (Cumul de rôles possible) :** * **Responsable de stage :** Pleins pouvoirs sur le catalogue d'offres (Ajout, Modification, Suppression). Validation des candidatures étudiantes pour débloquer l'étape de l'entretien et l'acceptation finale.
  * **Responsable de soutenance / Tuteur :** Suivi pédagogique de ses élèves assignés, soumission de dates et d'horaires de soutenance à l'administration.
* **Administrateur :** * Validation des nouveaux comptes enseignants (sécurité).
  * Attribution ou révocation des différents rôles aux professeurs.
  * **Validation définitive des dates de soutenances** proposées par l'équipe pédagogique.

---

## Le Workflow Pédagogique (Pipeline des stages)
1. **Création & RGPD :** Inscription, puis acceptation obligatoire de la politique de protection des données au premier login.
2. **Publication :** Un professeur "Responsable de stage" publie une offre dans le catalogue.
3. **Candidature :** L'étudiant postule à l'offre en joignant son CV.
4. **Validation Pédagogique :** Le responsable examine la demande et valide la candidature de l'étudiant.
5. **Acceptation & Nettoyage :** L'étudiant accepte le stage dans son espace de suivi. L'offre correspondante est **automatiquement retirée** du catalogue global pour les autres étudiants.
6. **Planification :** Un professeur propose une date de soutenance (Jury, Date, Heure, Lieu).
7. **Validation Administrative :** L'Administrateur valide la date depuis son panel de contrôle. La soutenance est alors officialisée et visible par l'étudiant.

---

## Arborescence du projet
L'architecture sépare rigoureusement les vues (pages) et les traitements (actions).

```text
sae-stages/
├── actions/                           # Scripts PHP de traitement pur (Sécurité, SQL, Redirections)
│   ├── accepter_politique_action.php  # Validation RGPD bloquante
│   ├── admin_roles_action.php         # Gestion des accès professeurs
│   ├── etudiant_recherche_action.php  # Postuler, uploader CV, suppression auto des offres
│   ├── login_action.php               # Routage de la connexion
│   ├── logout_action.php              # Déconnexion propre avec destruction du cache
│   ├── prof_offres_action.php         # CRUD complet du catalogue par les professeurs
│   ├── proposer_soutenance_action.php # Soumission d'une date de soutenance
│   ├── valider_compte_action.php      # Validation des comptes profs
│   └── valider_soutenance_action.php  # Approbation finale de la soutenance par l'Admin
│   
├── assets/                            
│   ├── css/style.css                  # Import des polices
│   ├── js/script.js                   # Gestion des modales et interactions
│   └── uploads/                       # Stockage des bannières, photos de profil et CV
│   
├── config/                      
│   └── database.php                   # Connexion PDO centralisée
│   
├── database/                    
│   └── init_db.sql                    # Création des tables
│   
├── includes/                          
│   ├── footer.php                     # Navigation de pied de page et Modale Mentions Légales
│   └── navbar.php                     # Navigation dynamique avec initiales de session
│   
├── pages/                             # Vues spécifiques protégées par vérification de session
│   ├── admin_soutenances.php          # (Admin) Dashboard de validation des dates de soutenances
│   ├── faq.php                        # (Tous) Foire aux questions accordéon
│   ├── gestion_soutenances.php        # (Prof) Planification des soutenances
│   ├── gestion_stages.php             # (Resp. Stage) Validation des candidatures étudiantes
│   ├── offres.php                     # (Tous) Catalogue dynamique des offres de stage
│   ├── profil.php                     # (Tous) Formulaire de mise à jour des infos personnelles
│   ├── soutenances.php                # (Étu) Affichage de la convocation et du jury
│   ├── suivi-recherches.php           # (Étu) Dashboard interactif d'avancement des candidatures
│   ├── suivi_etudiants.php            # (Prof) Visualisation des élèves affiliés
│   └── validation_comptes.php         # (Admin) Centre de modération des utilisateurs
│   
├── index.php                          # Hub d'accueil dynamique avec affichage des rôles et règles
└── login.php                          # Interface UI (Connexion / Inscription)