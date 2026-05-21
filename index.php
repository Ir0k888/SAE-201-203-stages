<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}
$nom = $_SESSION['nom'];
$prenom = $_SESSION['prenom'];
$role = $_SESSION['role'];
$type_compte = $_SESSION['type_compte'];
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Accueil - Plateforme MMI</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-50 text-slate-800 min-h-screen flex flex-col">
    <nav class="bg-white border-b border-slate-200 py-4 px-8 flex justify-between items-center sticky top-0 z-50 shadow-sm">
        <div class="font-bold text-xl text-slate-800">MMI Stages</div>
        <ul class="flex items-center gap-6 text-sm font-medium">
            <li><a href="index.php" class="text-blue-600">Accueil</a></li>
            <?php if ($role === 'Etudiant'): ?>
                <li><a href="pages/suivi-recherches.php" class="text-slate-600 hover:text-blue-600">Mes Recherches & Offres</a></li>
                <li><a href="pages/soutenances.php" class="text-slate-600 hover:text-blue-600">Ma Soutenance</a></li>
            <?php elseif ($role === 'Administrateur'): ?>
                <li><a href="pages/validation_comptes.php" class="text-slate-600 hover:text-blue-600">Comptes & Rôles</a></li>
                <li><a href="pages/gestion_stages.php" class="text-slate-600 hover:text-blue-600">Gestion des Stages & Affiliations</a></li>
                <li><a href="pages/gestion_soutenances.php" class="text-slate-600 hover:text-blue-600">Validation Soutenances</a></li>
            <?php elseif (in_array($role, ['Enseignant', 'Responsable de stage', 'Membre du jury'])): ?>
                <li><a href="pages/suivi_etudiants.php" class="text-slate-600 hover:text-blue-600">Mes Étudiants affiliés</a></li>
            <?php endif; ?>
            <li><a href="pages/profil.php" class="text-slate-600 hover:text-blue-600">Profil</a></li>
            <li><a href="actions/logout_action.php" class="bg-red-50 text-red-600 px-4 py-2 rounded-full text-xs font-bold hover:bg-red-100 transition-colors">Déconnexion</a></li>
        </ul>
    </nav>

    <main class="flex-grow flex items-center justify-center p-8">
        <div class="max-w-2xl bg-white p-12 rounded-2xl shadow-sm border border-slate-100 text-center">
            <span class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider mb-4 inline-block">Espace <?= htmlspecialchars($role) ?></span>
            <h1 class="text-3xl font-black text-slate-800 mb-4">Ravi de vous revoir, <?= htmlspecialchars($prenom) ?> !</h1>
            <p class="text-slate-500 text-sm mb-6">Plateforme universitaire de centralisation, d'affectation et de validation des soutenances de stages de l'IUT de Meaux.</p>
            <?php if ($role === 'Administrateur'): ?>
                <a href="pages/gestion_stages.php" class="inline-block bg-slate-800 text-white font-bold text-xs uppercase px-6 py-3 rounded-xl shadow-md hover:bg-slate-700">Gérer les Stages</a>
            <?php elseif ($role === 'Etudiant'): ?>
                <a href="pages/suivi-recherches.php" class="inline-block bg-blue-600 text-white font-bold text-xs uppercase px-6 py-3 rounded-xl shadow-md hover:bg-blue-500">Gérer mes démarches</a>
            <?php else: ?>
                <a href="pages/suivi_etudiants.php" class="inline-block bg-indigo-600 text-white font-bold text-xs uppercase px-6 py-3 rounded-xl shadow-md hover:bg-indigo-500">Voir mes étudiants</a>
            <?php endif; ?>
        </div>
    </main>
</body>
</html>