<?php
session_start();
require_once '../config/database.php';

if (!isset($_SESSION['user_id']) || $_SESSION['type_compte'] !== 'enseignant') {
    header('Location: ../index.php');
    exit();
}

$nouveau_role = $_POST['nouveau_role'] ?? '';
$id_enseignant = $_SESSION['user_id'];

if (!empty($nouveau_role)) {
    $stmt = $pdo->prepare("UPDATE Enseignant SET role_demande = :role WHERE id_enseignant = :id");
    $stmt->execute(['role' => $nouveau_role, 'id' => $id_enseignant]);
    header('Location: ../pages/profil.php?status=demande_ok');
    exit();
}
header('Location: ../pages/profil.php?status=error');
exit();
?>