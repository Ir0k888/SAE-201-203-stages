<?php
session_start();
require_once '../config/database.php';

// Sécurité : On vérifie que l'utilisateur est bien un enseignant connecté
if (!isset($_SESSION['user_id']) || $_SESSION['type_compte'] !== 'enseignant') {
    header('Location: ../index.php');
    exit();
}

$id_enseignant = $_SESSION['user_id'];

// On récupère le tableau des cases cochées (vide par défaut si rien n'est coché)
$nouveaux_roles = isset($_POST['nouveaux_roles']) ? $_POST['nouveaux_roles'] : [];

if (is_array($nouveaux_roles) && !empty($nouveaux_roles)) {
    // Si plusieurs rôles sont cochés, on les rassemble en une seule chaîne de caractères
    $role_string = implode(', ', $nouveaux_roles);
} else {
    // Si aucune case n'est cochée, le prof demande à redevenir un enseignant classique
    $role_string = 'Enseignant';
}

// Mise à jour de la colonne role_demande dans la base de données
$stmt = $pdo->prepare("UPDATE Enseignant SET role_demande = :role WHERE id_enseignant = :id");
$stmt->execute([
    'role' => $role_string,
    'id'   => $id_enseignant
]);

header('Location: ../pages/profil.php?status=demande_ok');
exit();
?>