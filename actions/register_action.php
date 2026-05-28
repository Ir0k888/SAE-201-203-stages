<?php
session_start();
require_once '../config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = trim($_POST['nom'] ?? '');
    $prenom = trim($_POST['prenom'] ?? '');
    $email = trim(strtolower($_POST['email'] ?? ''));
    $password = $_POST['password'] ?? '';
    $password_confirm = $_POST['password_confirm'] ?? '';

    if (empty($nom) || empty($prenom) || empty($email) || empty($password)) {
        die("Erreur : Formulaire incomplet. <a href='../login.php'>Retour</a>");
    }

    if ($password !== $password_confirm) {
        die("Erreur : Les mots de passe ne correspondent pas. <a href='../login.php'>Retour</a>");
    }

    // REGEX : Au moins 1 majuscule, 1 chiffre, 1 caractère spécial
    if (!preg_match('/^(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).+$/', $password)) {
        die("Erreur : Le mot de passe doit contenir au moins 1 majuscule, 1 chiffre et 1 caractère spécial. <a href='../login.php'>Retour</a>");
    }

    if (str_ends_with($email, '@etudiant.univ.fr')) {
        try {
            $stmt = $pdo->prepare("INSERT INTO Etudiant (nom, prenom, email, mot_de_passe) VALUES (:nom, :prenom, :email, :mdp)");
            $stmt->execute(['nom' => $nom, 'prenom' => $prenom, 'email' => $email, 'mdp' => $password]);
            header('Location: ../login.php?msg=success');
            exit();
        } catch (PDOException $e) {
            die("Erreur : Cet email étudiant est déjà utilisé. <a href='../login.php'>Retour</a>");
        }
    } elseif (str_ends_with($email, '@univ.fr')) {
        try {
            $stmt = $pdo->prepare("INSERT INTO Enseignant (nom, prenom, email, mot_de_passe, role, statut_compte) VALUES (:nom, :prenom, :email, :mdp, 'Enseignant', 'en_attente')");
            $stmt->execute(['nom' => $nom, 'prenom' => $prenom, 'email' => $email, 'mdp' => $password]);
            header('Location: ../login.php?msg=success');
            exit();
        } catch (PDOException $e) {
            die("Erreur : Ce compte académique est déjà enregistré. <a href='../login.php'>Retour</a>");
        }
    } else {
        die("Erreur : Accès refusé. Vous devez utiliser une adresse @etudiant.univ.fr ou @univ.fr. <a href='../login.php'>Retour</a>");
    }
}
?>