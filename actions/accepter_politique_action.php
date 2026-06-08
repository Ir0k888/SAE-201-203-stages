<?php
session_start();
require_once '../config/database.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: ../login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_user = $_SESSION['user_id'];
    $type_compte = $_POST['type_compte'] ?? '';

    // Définir la bonne table
    $table = ($type_compte === 'enseignant') ? 'Enseignant' : 'Etudiant';
    $id_col = ($type_compte === 'enseignant') ? 'id_enseignant' : 'id_etudiant';

    // Mettre à jour la base de données
    $stmt = $pdo->prepare("UPDATE $table SET politique_acceptee = 1 WHERE $id_col = ?");
    if ($stmt->execute([$id_user])) {
        // Mettre à jour la session
        $_SESSION['politique_acceptee'] = 1;
    }
}

// Rediriger vers l'accueil
header('Location: ../index.php');
exit();
?>