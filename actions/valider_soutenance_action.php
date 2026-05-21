<?php
session_start();
require_once '../config/database.php';

if (!isset($_SESSION['user_id']) || !str_contains($_SESSION['role'], 'Responsable de stage')) {
    die("Accès refusé.");
}

$id_soutenance = $_GET['id'] ?? null;
$action = $_GET['action'] ?? null;

if ($id_soutenance && $action === 'valider') {
    $stmt = $pdo->prepare("UPDATE Soutenance SET statut_soutenance = 'validee' WHERE id_soutenance = :id");
    $stmt->execute(['id' => $id_soutenance]);
} elseif ($id_soutenance && $action === 'refuser') {
    $stmt = $pdo->prepare("DELETE FROM Soutenance WHERE id_soutenance = :id AND statut_soutenance = 'en_attente'");
    $stmt->execute(['id' => $id_soutenance]);
}

header('Location: ../pages/gestion_soutenances.php');
exit();
?>