<?php
session_start();
require_once '../config/database.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'Administrateur') {
    die("Accès non autorisé.");
}

$id = $_GET['id'] ?? null;
$action = $_GET['action'] ?? null;

if ($id && $action) {
    if ($action === 'valider') {
        $stmt = $pdo->prepare("UPDATE Enseignant SET statut_compte = 'valide' WHERE id_enseignant = :id");
        $stmt->execute(['id' => $id]);
    } elseif ($action === 'refuser') {
        $stmt = $pdo->prepare("DELETE FROM Enseignant WHERE id_enseignant = :id AND statut_compte = 'en_attente'");
        $stmt->execute(['id' => $id]);
    }
}

header('Location: ../pages/validation_comptes.php');
exit();
?>