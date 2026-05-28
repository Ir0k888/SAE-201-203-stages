<?php
session_start();
require_once '../config/database.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'Administrateur') {
    die("Accès refusé.");
}

$id_enseignant = $_POST['id_enseignant'] ?? null;
$roles = isset($_POST['roles']) ? $_POST['roles'] : [];

if ($id_enseignant) {
    // Si aucune case n'est cochée, on le remet "Enseignant" classique. Sinon on assemble les rôles.
    $role_string = empty($roles) ? 'Enseignant' : implode(', ', $roles);
    
    $stmt = $pdo->prepare("UPDATE Enseignant SET role = :role WHERE id_enseignant = :id");
    $stmt->execute(['role' => $role_string, 'id' => $id_enseignant]);
}

header('Location: ../pages/validation_comptes.php');
exit();
?>