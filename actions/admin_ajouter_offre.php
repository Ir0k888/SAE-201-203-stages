<?php
session_start();
require_once '../config/database.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'Administrateur') {
    die("Action non autorisée.");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titre = trim($_POST['titre_offre'] ?? '');
    $entreprise = trim($_POST['entreprise'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $remuneration = trim($_POST['remuneration'] ?? '');

    if ($titre && $entreprise && $description) {
        $stmt = $pdo->prepare("INSERT INTO Offre_de_stage (titre_offre, entreprise, description, remuneration) VALUES (?, ?, ?, ?)");
        $stmt->execute([$titre, $entreprise, $description, $remuneration]);
    }
}

header('Location: ../pages/offres.php');
exit();
?>