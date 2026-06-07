<?php
session_start();
require_once '../config/database.php';

// VERROU STRICT : Responsable de stage uniquement
if (!isset($_SESSION['user_id']) || !str_contains($_SESSION['role'] ?? '', 'Responsable de stage')) {
    die("Action non autorisée.");
}

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $id_recherche = $_GET['id'] ?? null;
    $action = $_GET['action'] ?? null;

    if ($id_recherche) {
        if ($action === 'valider_attente') {
            $stmt = $pdo->prepare("UPDATE Recherche_de_stage SET statut_candidature = 'entretien' WHERE id_recherche = ?");
            $stmt->execute([$id_recherche]);
        } elseif ($action === 'valider_entretien') {
            $stmt = $pdo->prepare("UPDATE Recherche_de_stage SET statut_candidature = 'entretien_effectue' WHERE id_recherche = ?");
            $stmt->execute([$id_recherche]);
        } elseif ($action === 'refuser') {
            $stmt = $pdo->prepare("UPDATE Recherche_de_stage SET statut_candidature = 'refus' WHERE id_recherche = ?");
            $stmt->execute([$id_recherche]);
        }
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? null;
    
    if ($action === 'affilier_tuteur') {
        $id_etudiant = $_POST['id_etudiant'];
        $id_enseignant = $_POST['id_enseignant'];
        
        if ($id_etudiant && $id_enseignant) {
            $stmt = $pdo->prepare("INSERT INTO Prise_en_charge (id_etudiant, id_enseignant, annee) VALUES (?, ?, '2025-2026')");
            $stmt->execute([$id_etudiant, $id_enseignant]);
        }
    }
}

header('Location: ../pages/gestion_stages.php');
exit();
?>