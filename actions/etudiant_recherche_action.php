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
    
    // Upload de la pièce jointe
    $pj_nom = null;
    if (isset($_FILES['piece_jointe']) && $_FILES['piece_jointe']['error'] === UPLOAD_ERR_OK) {
        if (!file_exists('../assets/uploads/cv')) mkdir('../assets/uploads/cv', 0777, true);
        $tmp_name = $_FILES['piece_jointe']['tmp_name'];
        $extension = pathinfo($_FILES['piece_jointe']['name'], PATHINFO_EXTENSION);
        $pj_nom = 'CV_' . $id_etudiant . '_' . time() . '.' . $extension;
        move_uploaded_file($tmp_name, '../assets/uploads/cv/' . $pj_nom);
    }

    if ($entreprise && $poste) {
        $stmt_check = $pdo->prepare("SELECT COUNT(*) FROM Recherche_de_stage WHERE id_etudiant = ? AND entreprise = ? AND poste = ?");
        $stmt_check->execute([$id_etudiant, $entreprise, $poste]);
        if ($stmt_check->fetchColumn() == 0) {
            $stmt = $pdo->prepare("INSERT INTO Recherche_de_stage (entreprise, poste, id_etudiant, piece_jointe) VALUES (?, ?, ?, ?)");
            $stmt->execute([$entreprise, $poste, $id_etudiant, $pj_nom]);
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
    
    // 1. On récupère le poste et l'entreprise liés à cette candidature
    $stmt_info = $pdo->prepare("SELECT poste, entreprise FROM Recherche_de_stage WHERE id_recherche = ? AND id_etudiant = ?");
    $stmt_info->execute([$id_recherche, $id_etudiant]);
    $recherche = $stmt_info->fetch();

    // 2. On met à jour le statut de la candidature pour valider le stage
    $stmt = $pdo->prepare("UPDATE Recherche_de_stage SET statut_candidature = 'accepte' WHERE id_recherche = ? AND id_etudiant = ?");
    $stmt->execute([$id_recherche, $id_etudiant]);

    // 3. Suppression automatique de l'offre du catalogue global
    if ($recherche) {
        $stmt_del = $pdo->prepare("DELETE FROM Offre_de_stage WHERE titre_offre = ? AND entreprise = ?");
        $stmt_del->execute([$recherche['poste'], $recherche['entreprise']]);
    }
    
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