<?php
session_start();
require_once '../config/database.php';

// SEUL LE PROF PEUT AGIR ICI
if (!isset($_SESSION['user_id']) || $_SESSION['type_compte'] !== 'enseignant') {
    die("Action non autorisée.");
}

$action = $_POST['action'] ?? '';

if ($action === 'ajouter') {
    $titre = trim($_POST['titre_offre'] ?? '');
    $entreprise = trim($_POST['entreprise'] ?? '');
    $description = trim($_POST['description'] ?? '');

    // Si les champs sont remplis, on insère (sans l'image_banniere qui causait l'erreur)
    if ($titre && $entreprise && $description) {
        $stmt = $pdo->prepare("INSERT INTO Offre_de_stage (titre_offre, entreprise, description) VALUES (?, ?, ?)");
        $stmt->execute([$titre, $entreprise, $description]);
    }
} elseif ($action === 'supprimer') {
    $id_offre = $_POST['id_offre'] ?? null;
    if ($id_offre) {
        $stmt = $pdo->prepare("DELETE FROM Offre_de_stage WHERE id_offre_de_stage = ?");
        $stmt->execute([$id_offre]);
    }
}

// Retour à la page des offres
header('Location: ../pages/offres.php');
exit();
?>