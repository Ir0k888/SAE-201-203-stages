<?php
session_start();
require_once '../config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = trim($_POST['nom'] ?? '');
    $prenom = trim($_POST['prenom'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if (empty($nom) || empty($prenom) || empty($email) || empty($password)) {
        die("Erreur : Formulaire incomplet. <a href='../login.php'>Retour</a>");
    }

    // Routage sémantique automatique selon le nom de domaine de l'email
    if (str_ends_with($email, '@etudiant.univ.fr')) {
        try {
            $stmt = $pdo->prepare("INSERT INTO Etudiant (nom, prenom, email, mot_de_passe) VALUES (:nom, :prenom, :email, :mdp)");
            $stmt->execute(['nom' => $nom, 'prenom' => $prenom, 'email' => $email, 'mdp' => $password]);
            header('Location: ../login.php?msg=success');
            exit();
        } catch (PDOException $e) {
            die("Erreur : Email redondant ou conflit BDD. <a href='../login.php'>Retour</a>");
        }
    } else {
        try {
            // Tous les enseignants s'inscrivent de base comme 'Enseignant' standard et en attente
            $stmt = $pdo->prepare("INSERT INTO Enseignant (nom, prenom, email, mot_de_passe, role, statut_compte) VALUES (:nom, :prenom, :email, :mdp, 'Enseignant', 'en_attente')");
            $stmt->execute(['nom' => $nom, 'prenom' => $prenom, 'email' => $email, 'mdp' => $password]);
            header('Location: ../login.php?msg=success');
            exit();
        } catch (PDOException $e) {
            die("Erreur : Compte académique déjà enregistré. <a href='../login.php'>Retour</a>");
        }
    }
}
?>