<?php
session_start();
require_once '../config/database.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'Administrateur') {
    die("Accès refusé.");
}

$id_enseignant = $_POST['id_enseignant'] ?? null;
$roles_coches = isset($_POST['roles']) ? $_POST['roles'] : [];

if ($id_enseignant) {
    if (!in_array('Enseignant', $roles_coches)) {
        array_unshift($roles_coches, 'Enseignant');
    }
    
    $role_string = implode(', ', $roles_coches);
    
    $stmt = $pdo->prepare("UPDATE Enseignant SET role = :role WHERE id_enseignant = :id");
    $stmt->execute(['role' => $role_string, 'id' => $id_enseignant]);
}

header('Location: ../pages/validation_comptes.php');
exit();
?>