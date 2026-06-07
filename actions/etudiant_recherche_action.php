<?php
session_start();
require_once '../config/database.php';

if (!isset($_SESSION['user_id']) || $_SESSION['type_compte'] !== 'etudiant') {
    die("Action non autorisée.");
}

$action = $_POST['action'] ?? '';
$id_etudiant = $_SESSION['user_id'];

if ($action === 'postuler_offre') {
    $entreprise = trim($_POST['entreprise'] ?? '');
    $poste = trim($_POST['poste'] ?? '');
    
    if ($entreprise && $poste) {
        // Vérifie si l'étudiant a déjà postulé à cette offre exacte pour éviter les doublons
        $stmt_check = $pdo->prepare("SELECT COUNT(*) FROM Recherche_de_stage WHERE id_etudiant = ? AND entreprise = ? AND poste = ?");
        $stmt_check->execute([$id_etudiant, $entreprise, $poste]);
        if ($stmt_check->fetchColumn() == 0) {
            $stmt = $pdo->prepare("INSERT INTO Recherche_de_stage (entreprise, poste, id_etudiant) VALUES (?, ?, ?)");
            $stmt->execute([$entreprise, $poste, $id_etudiant]);
        }
    }
    header('Location: ../pages/suivi-recherches.php');
    exit();

} elseif ($action === 'soumettre_resume') {
    $id_recherche = $_POST['id_recherche'];
    $resume = trim($_POST['resume']);
    if ($id_recherche && $resume) {
        $stmt = $pdo->prepare("UPDATE Recherche_de_stage SET resume_entretien = ?, statut_candidature = 'attente_validation' WHERE id_recherche = ? AND id_etudiant = ?");
        $stmt->execute([$resume, $id_recherche, $id_etudiant]);
    }
    header('Location: ../pages/suivi-recherches.php');
    exit();

} elseif ($action === 'accepter_offre') {
    $id_recherche = $_POST['id_recherche'];
    $stmt = $pdo->prepare("UPDATE Recherche_de_stage SET statut_candidature = 'accepte' WHERE id_recherche = ? AND id_etudiant = ?");
    $stmt->execute([$id_recherche, $id_etudiant]);
    header('Location: ../pages/suivi-recherches.php');
    exit();

} elseif ($action === 'refuser_offre') {
    $id_recherche = $_POST['id_recherche'];
    $stmt = $pdo->prepare("UPDATE Recherche_de_stage SET statut_candidature = 'refus' WHERE id_recherche = ? AND id_etudiant = ?");
    $stmt->execute([$id_recherche, $id_etudiant]);
    header('Location: ../pages/suivi-recherches.php');
    exit();
}

header('Location: ../index.php');
exit();
?>