<?php
session_start();
require_once '../config/database.php';

if (!isset($_SESSION['user_id']) || $_SESSION['type_compte'] !== 'enseignant') {
    die("Action non autorisée.");
}

$id_enseignant = $_SESSION['user_id'];
$id_etudiant = $_POST['id_etudiant'] ?? null;
$date = $_POST['date'] ?? null;
$heure = $_POST['heure'] ?? null;
$lieu = trim($_POST['lieu'] ?? '');

if ($id_etudiant && $date && $heure && $lieu) {
    $stmt = $pdo->prepare("INSERT INTO Soutenance (date_soutenance, horaire, lieu, id_etudiant, id_enseignant, statut_soutenance) VALUES (?, ?, ?, ?, ?, 'en_attente')");
    $stmt->execute([$date, $heure, $lieu, $id_etudiant, $id_enseignant]);
}

header('Location: ../pages/suivi_etudiants.php');
exit();
?>