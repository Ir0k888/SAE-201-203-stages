<?php
session_start();
require_once '../config/database.php';

if (!isset($_SESSION['user_id'])) {
    die("Action non autorisée.");
}

$id_user = $_SESSION['user_id'];
$type_compte = $_SESSION['type_compte'];

$adresse = trim($_POST['adresse_postale'] ?? '');
$tel = trim($_POST['numero_telephone'] ?? '');
$bio = trim($_POST['bio'] ?? '');

$photo_nom = null;
if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
    if (!file_exists('../assets/uploads')) mkdir('../assets/uploads', 0777, true);
    $tmp_name = $_FILES['photo']['tmp_name'];
    $extension = pathinfo($_FILES['photo']['name'], PATHINFO_EXTENSION);
    $photo_nom = $type_compte . '_' . $id_user . '_' . time() . '.' . $extension;
    move_uploaded_file($tmp_name, '../assets/uploads/' . $photo_nom);
    $_SESSION['photo_profil'] = $photo_nom; // Mise à jour de la session pour la navbar
}

if ($type_compte === 'etudiant') {
    $num_etu = trim($_POST['numero_etudiant'] ?? '');
    $date_naiss = empty($_POST['date_naissance']) ? null : $_POST['date_naissance'];
    $lieu_naiss = trim($_POST['lieu_naissance'] ?? '');
    $promo = trim($_POST['promotion'] ?? '');
    $td = trim($_POST['groupe_td'] ?? '');
    $tp = trim($_POST['groupe_tp'] ?? '');

    $sql = "UPDATE Etudiant SET adresse_postale=?, numero_telephone=?, bio=?, numero_etudiant=?, date_naissance=?, lieu_naissance=?, promotion=?, groupe_td=?, groupe_tp=?";
    $params = [$adresse, $tel, $bio, $num_etu, $date_naiss, $lieu_naiss, $promo, $td, $tp];

    if ($photo_nom) {
        $sql .= ", photo_profil=?";
        $params[] = $photo_nom;
    }
    $sql .= " WHERE id_etudiant=?";
    $params[] = $id_user;

    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);

} else {
    $sql = "UPDATE Enseignant SET adresse_postale=?, numero_telephone=?, bio=?";
    $params = [$adresse, $tel, $bio];

    if ($photo_nom) {
        $sql .= ", photo_profil=?";
        $params[] = $photo_nom;
    }
    $sql .= " WHERE id_enseignant=?";
    $params[] = $id_user;

    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
}

header('Location: ../pages/profil.php?status=success');
exit();
?>