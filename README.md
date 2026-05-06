# SAé - Plateforme de Gestion des Stages 201/203

## Présentation du projet
Ce projet consiste à créer une application web complète permettant de gérer le suivi des stages pour le département MMI de l'IUT de Meaux. L'objectif est de remplacer l'outil actuel (ESUP) par une solution centralisée gérant les offres, les candidatures, le suivi des recherches, les évaluations et les soutenances.

## Stack Technique
* **Front-end :** HTML5, CSS3, JavaScript, [ PRÉCISER LA VERSION DE BOOTSTRAP, ex: Bootstrap 5 ]
* **Back-end :** PHP natif
* **Base de données :** MySQL
* **Hébergement :** AlwaysData, InfinityFree, O2Switch (déploiement multi-cibles)
* **Versionning :** Git / GitHub

## Acteurs et Rôles (Gestion des droits)
L'application intègre un système d'authentification et d'autorisation complexe divisé en 5 rôles :
* **Étudiant :** Gestion du profil, consultation des offres, déclaration de recherche personnelle, soutenance, rapport de stage.
* **Enseignants :** fonction --> ( donc ils sont tous enseignants )
* ***Responsable des stages :** Validation des comptes, publication des offres, affectation, suivi des étudiants, organisation des oraux, convention de stage.
* ***Jury de soutenance :** Saisie et consultation des notes (rapport + oral).
* ***Responsable de formation (Chef de département) :** Accès au tableau de bord global et aux statistiques.
* ***Administrateur :** Tous les droits + gestion technique des comptes.

## Charte Graphique & UI/UX
* **Couleur Principale (Primary) :** [ INSCRIRE LE CODE HEXA ICI, ex: #0D6EFD ]
* **Couleur Secondaire (Secondary) :** [ INSCRIRE LE CODE HEXA ICI ]
* **Couleur d'Accent / Alertes :** [ INSCRIRE LE CODE HEXA ICI ]
* **Typographie Titres (Headers) :** [ INSCRIRE LE NOM DE LA POLICE, ex: Montserrat ]
* **Typographie Textes (Body) :** [ INSCRIRE LE NOM DE LA POLICE, ex: Roboto ]
* **Maquette Figma :** [ INSÉRER LE LIEN VERS VOTRE FIGMA ICI ]

## Arborescence du projet
Structure des dossiers de base pour maintenir un code propre (séparation logique) :

* **`/assets`** : Fichiers statiques (CSS, JS, images, logos).
* **`/config`** : Fichiers de configuration (ex: `config.exemple.php` pour la BDD).
* **`/includes`** : Morceaux de pages répétés (header.php, footer.php, navbar.php).
* **`/pages`** : Les vues principales du site (login, dashboard, offres).
* **`/scripts`** : Les traitements PHP purs (traitement_login.php, requetes_sql.php).
* **`/database`** : Scripts SQL (fichiers de création des tables et MCD).
* **`index.php`** : Point d'entrée de l'application.

## Base de Données (MCD/MPD)
[ EXPLIQUER ICI BRIÈVEMENT NOS CHOIX DE MODÉLISATION QUAND ILS SERONT FAITS ]
* **Lien vers le MCD :** [ AJOUTER LE LIEN OU L'IMAGE DU MCD ]
* **Lien vers le dictionnaire de données :** [ AJOUTER LE LIEN ]
---
*Projet réalisé dans le cadre de la SAé du BUT MMI de Meaux par [ I-r0k ] et [ Alex Dum ].*

### 31/03 finalisation du READ ME en tant que fichier guide.
### 31/03 Finition de l'arbo ( provisoire )
### 31/03 tailwindcss + js pour la base police etc, style provisoire, intégration des features de VPtours SAE 105 ( I-r0k )
### 07/04 footer + js tps 3 et 5 offres et recherches, style global ajusté ( I-r0k )

##  Arborescence du projet (Front-end)

Voici la structure des fichiers de l'application. Elle est divisée entre l'espace public (connexion/inscription) et l'espace privé (le dashboard et ses fonctionnalités).

```text
 sae-gestion-stages/
├──  index.html                # Accueil & Connexion (Point d'entrée)
├──  inscription.html          # Formulaire de création de compte
│
├──  assets/                   # Ressources statiques
│   ├──  css/
│   │   └──  style.css         # Styles globaux (Variables :root, charte graphique)
│   ├──  js/
│   │   └──  script.js         # Logique front (Smooth scroll, menu dynamique)
│   └──  img/                  # Logos, illustrations, avatars
│
└──  pages/                    # Espace Privé (Dashboard complet)
    ├──  profil.html           # Saisie et modification des données personnelles
    ├──  offres.html           # Liste des stages, recherche, filtres et affectations
    ├──  suivi-recherches.html # Déclaration et suivi des recherches personnelles
    └──  soutenances.html      # Planning des oraux, jurys et affichage des notes 
    text```
