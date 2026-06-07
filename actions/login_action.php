<?php
session_start();
require_once '../config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $type_compte = $_POST['type_compte'] ?? '';
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if (empty($email) || empty($password)) {
        die("Erreur : Données incomplètes. <a href='../login.php'>Retour</a>");
    }

    if ($type_compte === 'etudiant') {
        $stmt = $pdo->prepare("SELECT * FROM Etudiant WHERE email = :email");
        $stmt->execute(['email' => $email]);
        $user = $stmt->fetch();

        if ($user && $password === $user['mot_de_passe']) {
            $_SESSION['user_id'] = $user['id_etudiant'];
            $_SESSION['type_compte'] = 'etudiant';
            $_SESSION['role'] = 'Etudiant';
            $_SESSION['nom'] = $user['nom'];
            $_SESSION['prenom'] = $user['prenom'];
            $_SESSION['politique_acceptee'] = $user['politique_acceptee']; // Ajout
            header('Location: ../index.php');
            exit();
        }
    } else {
        $stmt = $pdo->prepare("SELECT * FROM Enseignant WHERE email = :email");
        $stmt->execute(['email' => $email]);
        $user = $stmt->fetch();

        if ($user && $password === $user['mot_de_passe']) {
            if ($user['statut_compte'] === 'en_attente') {
                die("Validation requise : Votre inscription est bloquée jusqu'à examen par l'Admin. <a href='../login.php'>Retour</a>");
            }
            $_SESSION['user_id'] = $user['id_enseignant'];
            $_SESSION['type_compte'] = 'enseignant';
            $_SESSION['role'] = $user['role'];
            $_SESSION['nom'] = $user['nom'];
            $_SESSION['prenom'] = $user['prenom'];
            $_SESSION['politique_acceptee'] = $user['politique_acceptee']; // Ajout
            header('Location: ../index.php');
            exit();
        }
    }
    die("Identifiants de connexion erronés ou invalides. <a href='../login.php'>Retour</a>");
}
?>