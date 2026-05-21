<?php
session_start();
require_once '../config/database.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'Administrateur') {
    die("Accès non autorisé.");
}

$id = $_GET['id'] ?? null;
$action = $_GET['action'] ?? null;
$target = $_GET['target'] ?? 'compte'; // 'compte' (nouveau prof) ou 'role' (évolution interne)

if ($id && $action) {
    if ($target === 'compte') {
        if ($action === 'valider') {
            $stmt = $pdo->prepare("UPDATE Enseignant SET statut_compte = 'valide' WHERE id_enseignant = :id");
            $stmt->execute(['id' => $id]);
        } else {
            $stmt = $pdo->prepare("DELETE FROM Enseignant WHERE id_enseignant = :id AND statut_compte = 'en_attente'");
            $stmt->execute(['id' => $id]);
        }
    } elseif ($target === 'role') {
        if ($action === 'valider') {
            // Lecture du rôle demandé
            $stmt = $pdo->prepare("SELECT role_demande FROM Enseignant WHERE id_enseignant = :id");
            $stmt->execute(['id' => $id]);
            $res = $stmt->fetch();
            
            if ($res && $res['role_demande']) {
                $stmt = $pdo->prepare("UPDATE Enseignant SET role = :new_role, role_demande = NULL WHERE id_enseignant = :id");
                $stmt->execute(['new_role' => $res['role_demande'], 'id' => $id]);
            }
        } else {
            // Rejet simple de la demande d'évolution
            $stmt = $pdo->prepare("UPDATE Enseignant SET role_demande = NULL WHERE id_enseignant = :id");
            $stmt->execute(['id' => $id]);
        }
    }
}

header('Location: ../pages/validation_comptes.php');
exit();
?>