<?php
session_start();
require_once '../config/database.php';

// SÉCURITÉ : On vérifie que c'est bien l'admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'Administrateur') {
    die("Accès refusé.");
}

// On récupère les paramètres dans l'URL (ex: ?id=4&action=valider)
$id_enseignant = $_GET['id'] ?? null;
$action = $_GET['action'] ?? null;

if ($id_enseignant && $action) {
    try {
        if ($action === 'valider') {
            // On passe le statut à 'valide'
            $query = "UPDATE Enseignant SET statut_compte = 'valide' WHERE id_enseignant = :id";
            $stmt = $pdo->prepare($query);
            $stmt->execute(['id' => $id_enseignant]);

        } elseif ($action === 'refuser') {
            // Si refusé, on supprime carrément la demande de la base
            $query = "DELETE FROM Enseignant WHERE id_enseignant = :id AND statut_compte = 'en_attente'";
            $stmt = $pdo->prepare($query);
            $stmt->execute(['id' => $id_enseignant]);
        }
    } catch (PDOException $e) {
        die("Erreur base de données : " . $e->getMessage());
    }
}

// Retour au tableau de bord
header('Location: ../pages/validation_comptes.php');
exit();