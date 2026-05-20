<?php
// actions/login_action.php

// 1. On démarre la session pour pouvoir stocker les informations de l'utilisateur connecté
session_start();

// 2. On inclut le fichier de connexion à la base de données
// On utilise ../config/ pour remonter d'un dossier car login_action.php est dans le dossier actions/
require_once '../config/database.php';

// 3. On vérifie que le formulaire a bien été envoyé en méthode POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    // On récupère et on sécurise les données saisies
    $type_compte = $_POST['type_compte'] ?? '';
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    // Vérification de sécurité de base : champs vides
    if (empty($email) || empty($password)) {
        die("Veuillez remplir tous les champs. <a href='../login.php'>Retour</a>");
    }

    try {
        // 4. Traitement selon le type de compte sélectionné
        if ($type_compte === 'etudiant') {
            
            // Requête pour chercher l'étudiant par son email
            $query = "SELECT * FROM Etudiant WHERE email = :email";
            $stmt = $pdo->prepare($query);
            $stmt->execute(['email' => $email]);
            $user = $stmt->fetch();

            // Vérification du mot de passe (comparaison simple pour ton prototype local)
            if ($user && $password === $user['mot_de_passe']) {
                // Connexion réussie ! On remplit la session
                $_SESSION['user_id'] = $user['id_etudiant'];
                $_SESSION['type_compte'] = 'etudiant';
                $_SESSION['role'] = 'Etudiant';
                $_SESSION['nom'] = $user['nom'];
                $_SESSION['prenom'] = $user['prenom'];

                // Redirection vers l'accueil de l'espace connecté
                header('Location: ../index.php');
                exit();
            } else {
                die("Identifiants incorrects pour l'espace Étudiant. <a href='../login.php'>Retour</a>");
            }

        } elseif ($type_compte === 'enseignant') {
            
            // Requête pour chercher l'enseignant/staff par son email
            $query = "SELECT * FROM Enseignant WHERE email = :email";
            $stmt = $pdo->prepare($query);
            $stmt->execute(['email' => $email]);
            $user = $stmt->fetch();

            if ($user && $password === $user['mot_de_passe']) {
                
                // NOUVEAU : On vérifie si l'administrateur a validé le compte
                if ($user['statut_compte'] === 'en_attente') {
                    die("Votre compte enseignant est en attente de validation par l'administrateur. <a href='../login.php'>Retour</a>");
                }

                // Connexion réussie ! On remplit la session
                $_SESSION['user_id'] = $user['id_enseignant'];
                $_SESSION['type_compte'] = 'enseignant';
                $_SESSION['role'] = $user['role']; // Récupère le rôle précis (Admin, Chef de dép, etc.)
                $_SESSION['nom'] = $user['nom'];
                $_SESSION['prenom'] = $user['prenom'];

                // Redirection vers l'accueil général
                header('Location: ../index.php');
                exit();
            } else {
                die("Identifiants incorrects pour l'espace Staff. <a href='../login.php'>Retour</a>");
            }

        } else {
            die("Type de compte invalide. <a href='../login.php'>Retour</a>");
        }

    } catch (PDOException $e) {
        die("Erreur lors de la tentative de connexion : " . $e->getMessage());
    }

} else {
    // Si quelqu'un tente d'accéder à ce fichier directement sans passer par le formulaire
    header('Location: ../login.php');
    exit();
}