<?php
session_start();
require_once '../config/database.php';

if (!isset($_SESSION['user_id'])) {
    die("Action non autorisée.");
}

$id_user = $_SESSION['user_id'];
$type_compte = $_SESSION['type_compte'];

$bio = trim($_POST['bio'] ?? '');
$annee_mmi = $_POST['annee_mmi'] ?? null;

// GESTION DE LA PHOTO DE PROFIL
$photo_nom = null;
if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
    // Création du dossier uploads s'il n'existe pas
    if (!file_exists('../assets/uploads')) {
        mkdir('../assets/uploads', 0777, true);
    }
    
    $tmp_name = $_FILES['photo']['tmp_name'];
    $extension = pathinfo($_FILES['photo']['name'], PATHINFO_EXTENSION);
    $photo_nom = $type_compte . '_' . $id_user . '_' . time() . '.' . $extension;
    
    move_uploaded_file($tmp_name, '../assets/uploads/' . $photo_nom);
}

// MISE À JOUR BDD
if ($type_compte === 'etudiant') {
    if ($photo_nom) {
        $stmt = $pdo->prepare("UPDATE Etudiant SET bio = ?, annee_mmi = ?, photo_profil = ? WHERE id_etudiant = ?");
        $stmt->execute([$bio, empty($annee_mmi) ? null : $annee_mmi, $photo_nom, $id_user]);
    } else {
        $stmt = $pdo->prepare("UPDATE Etudiant SET bio = ?, annee_mmi = ? WHERE id_etudiant = ?");
        $stmt->execute([$bio, empty($annee_mmi) ? null : $annee_mmi, $id_user]);
    }
} else {
    if ($photo_nom) {
        $stmt = $pdo->prepare("UPDATE Enseignant SET bio = ?, photo_profil = ? WHERE id_enseignant = ?");
        $stmt->execute([$bio, $photo_nom, $id_user]);
    } else {
        $stmt = $pdo->prepare("UPDATE Enseignant SET bio = ? WHERE id_enseignant = ?");
        $stmt->execute([$bio, $id_user]);
    }
}

header('Location: ../pages/profil.php?status=success');
exit();
?>