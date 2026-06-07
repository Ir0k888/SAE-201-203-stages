<?php
session_start();
require_once '../config/database.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: ../login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    $id = $_SESSION['user_id'];
    $table = ($_SESSION['type_compte'] === 'etudiant') ? 'Etudiant' : 'Enseignant';
    $col_id = ($_SESSION['type_compte'] === 'etudiant') ? 'id_etudiant' : 'id_enseignant';

    if ($action === 'accepter') {
        $stmt = $pdo->prepare("UPDATE $table SET politique_acceptee = 1 WHERE $col_id = ?");
        $stmt->execute([$id]);
        $_SESSION['politique_acceptee'] = 1;
        
        // Redirection ciblée
        $target = '../index.php';
        if ($_SESSION['role'] === 'Etudiant') $target = '../pages/offres.php';
        elseif ($_SESSION['role'] === 'Administrateur') $target = '../pages/validation_comptes.php';
        elseif ($_SESSION['type_compte'] === 'enseignant') $target = '../pages/suivi_etudiants.php';
        
        header("Location: $target");
        exit();
    } elseif ($action === 'refuser') {
        session_unset();
        session_destroy();
        header('Location: ../login.php?msg=refus_politique');
        exit();
    }
}
header('Location: ../index.php');
exit();
?>