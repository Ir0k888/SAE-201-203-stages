<?php
session_start();
require_once '../config/database.php';

// Sécurité : Seul l'Administrateur peut valider les dates
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'Administrateur') {
    die("Action non autorisée.");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'valider') {
    $id_soutenance = $_POST['id_soutenance'] ?? null;

    if ($id_soutenance) {
        // Mise à jour de "statut_soutenance" vers "validee" comme défini dans l'ENUM
        $stmt = $pdo->prepare("UPDATE Soutenance SET statut_soutenance = 'validee' WHERE id_soutenance = ?");
        $stmt->execute([$id_soutenance]);
    }
}

// Redirection vers la page admin des soutenances pour voir que la liste s'est bien vidée
header('Location: ../pages/admin_soutenances.php');
exit();
?>