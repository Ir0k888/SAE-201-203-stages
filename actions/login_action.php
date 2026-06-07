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

    $table = ($type_compte === 'etudiant') ? 'Etudiant' : 'Enseignant';
    $stmt = $pdo->prepare("SELECT * FROM $table WHERE email = :email");
    $stmt->execute(['email' => $email]);
    $user = $stmt->fetch();

    if ($user && $password === $user['mot_de_passe']) {
        if ($type_compte === 'enseignant' && $user['statut_compte'] === 'en_attente') {
            die("Validation requise par l'Admin. <a href='../login.php'>Retour</a>");
        }

        $_SESSION['user_id'] = ($type_compte === 'etudiant') ? $user['id_etudiant'] : $user['id_enseignant'];
        $_SESSION['type_compte'] = $type_compte;
        $_SESSION['role'] = $user['role'] ?? 'Etudiant';
        $_SESSION['nom'] = $user['nom'];
        $_SESSION['prenom'] = $user['prenom'];
        $_SESSION['politique_acceptee'] = $user['politique_acceptee'];
        $_SESSION['photo_profil'] = $user['photo_profil'] ?? 'default.png';

        // Redirection ciblée selon le rôle
        $target = '../index.php';
        if ($_SESSION['role'] === 'Etudiant') {
            $target = '../pages/offres.php';
        } elseif ($_SESSION['role'] === 'Administrateur') {
            $target = '../pages/validation_comptes.php';
        } elseif ($type_compte === 'enseignant') {
            $target = '../pages/suivi_etudiants.php';
        }
        
        header("Location: $target");
        exit();
    }
    die("Identifiants de connexion erronés ou invalides. <a href='../login.php'>Retour</a>");
}
?>