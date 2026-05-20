<?php
session_start();
require_once '../config/database.php';

// On vérifie que la requête vient bien du formulaire
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    // Récupération des données du formulaire
    $type_compte = $_POST['type_compte'] ?? '';
    $nom = trim($_POST['nom'] ?? '');
    $prenom = trim($_POST['prenom'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    
    // Si c'est un enseignant, il aura choisi un rôle. Sinon, on met null.
    $role_souhaite = $_POST['role_souhaite'] ?? null;

    // Vérification basique
    if (empty($nom) || empty($prenom) || empty($email) || empty($password)) {
        die("Tous les champs sont obligatoires. <a href='../login.php'>Retour</a>");
    }

    try {
        if ($type_compte === 'etudiant') {
            
            // INSCRIPTION ÉTUDIANT (Automatiquement valide)
            $query = "INSERT INTO Etudiant (nom, prenom, email, mot_de_passe) VALUES (:nom, :prenom, :email, :mdp)";
            $stmt = $pdo->prepare($query);
            $stmt->execute([
                'nom' => $nom,
                'prenom' => $prenom,
                'email' => $email,
                'mdp' => $password
            ]);
            
            // On le redirige vers le login avec un message de succès dans l'URL
            header("Location: ../login.php?msg=success_etu");
            exit();

        } elseif ($type_compte === 'enseignant') {
            
            // INSCRIPTION ENSEIGNANT (Mis 'en_attente' d'office + enregistrement du rôle demandé)
            $query = "INSERT INTO Enseignant (nom, prenom, email, mot_de_passe, role, statut_compte) 
                      VALUES (:nom, :prenom, :email, :mdp, :role, 'en_attente')";
            $stmt = $pdo->prepare($query);
            $stmt->execute([
                'nom' => $nom,
                'prenom' => $prenom,
                'email' => $email,
                'mdp' => $password,
                'role' => $role_souhaite
            ]);
            
            // On le redirige avec un message spécifique
            header("Location: ../login.php?msg=success_prof");
            exit();

        } else {
            die("Type de compte non reconnu. <a href='../login.php'>Retour</a>");
        }

    } catch (PDOException $e) {
        // Le code 23000 correspond à une erreur de contrainte UNIQUE (l'email existe déjà)
        if ($e->getCode() == 23000) {
            die("Erreur : Cet email est déjà utilisé. Veuillez vous connecter. <a href='../login.php'>Retour</a>");
        }
        // Autre erreur
        die("Erreur de base de données : " . $e->getMessage());
    }
} else {
    header("Location: ../login.php");
    exit();
}