<?php
session_start();
require_once '../config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = trim($_POST['nom'] ?? '');
    $prenom = trim($_POST['prenom'] ?? '');
    $email = trim(strtolower($_POST['email'] ?? ''));
    $password = $_POST['password'] ?? '';

    if (empty($nom) || empty($prenom) || empty($email) || empty($password)) {
        die("Erreur : Formulaire incomplet. <a href='../login.php'>Retour</a>");
    }

    // VÉRIFICATION STRICTE DES DOMAINES D'EMAIL
    if (str_ends_with($email, '@etudiant.univ.fr')) {
        // C'est un étudiant
        try {
            $stmt = $pdo->prepare("INSERT INTO Etudiant (nom, prenom, email, mot_de_passe) VALUES (:nom, :prenom, :email, :mdp)");
            $stmt->execute(['nom' => $nom, 'prenom' => $prenom, 'email' => $email, 'mdp' => $password]);
            header('Location: ../login.php?msg=success');
            exit();
        } catch (PDOException $e) {
            die("Erreur : Cet email étudiant est déjà utilisé. <a href='../login.php'>Retour</a>");
        }

    } elseif (str_ends_with($email, '@univ.fr')) {
        // C'est un enseignant / personnel staff
        try {
            $stmt = $pdo->prepare("INSERT INTO Enseignant (nom, prenom, email, mot_de_passe, role, statut_compte) VALUES (:nom, :prenom, :email, :mdp, 'Enseignant', 'en_attente')");
            $stmt->execute(['nom' => $nom, 'prenom' => $prenom, 'email' => $email, 'mdp' => $password]);
            header('Location: ../login.php?msg=success');
            exit();
        } catch (PDOException $e) {
            die("Erreur : Ce compte académique est déjà enregistré. <a href='../login.php'>Retour</a>");
        }

    } else {
        // Domaine non reconnu
        die("Erreur : Accès refusé. Vous devez utiliser une adresse @etudiant.univ.fr ou @univ.fr. <a href='../login.php'>Retour</a>");
    }
}
?>