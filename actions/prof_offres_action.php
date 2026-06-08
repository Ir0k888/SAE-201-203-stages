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

    $banniere_nom = null;
    if (isset($_FILES['banniere']) && $_FILES['banniere']['error'] === UPLOAD_ERR_OK) {
        if (!file_exists('../assets/uploads/bannieres')) mkdir('../assets/uploads/bannieres', 0777, true);
        $tmp_name = $_FILES['banniere']['tmp_name'];
        $extension = pathinfo($_FILES['banniere']['name'], PATHINFO_EXTENSION);
        $banniere_nom = 'ban_' . time() . '.' . $extension;
        move_uploaded_file($tmp_name, '../assets/uploads/bannieres/' . $banniere_nom);
    }

    if ($titre && $entreprise && $description) {
        // Retrait de niveau_requis
        $stmt = $pdo->prepare("INSERT INTO Offre_de_stage (titre_offre, entreprise, description, image_banniere) VALUES (?, ?, ?, ?)");
        $stmt->execute([$titre, $entreprise, $description, $banniere_nom]);
    }
} elseif ($action === 'supprimer') {
    $id_offre = $_POST['id_offre'] ?? null;
    if ($id_offre) {
        $stmt = $pdo->prepare("DELETE FROM Offre_de_stage WHERE id_offre_de_stage = ?");
        $stmt->execute([$id_offre]);
    }
}

header('Location: ../pages/offres.php');
exit();
?>