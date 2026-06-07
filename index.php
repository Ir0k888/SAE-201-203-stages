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
    
    <?php include 'includes/navbar.php'; ?>

    <main class="flex-grow flex items-center justify-center p-8">
        <div class="max-w-2xl bg-white p-12 rounded-2xl shadow-sm border border-slate-100 text-center">
            <span class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider mb-4 inline-block">Rôles : <?= htmlspecialchars($role) ?></span>
            <h1 class="text-3xl font-black text-slate-800 mb-4">Ravi de vous revoir, <?= htmlspecialchars($prenom) ?> !</h1>
            <p class="text-slate-500 text-sm mb-6">Plateforme universitaire de centralisation, d'affectation et de validation des soutenances de stages de l'IUT de Meaux.</p>
            
            <?php if ($role === 'Administrateur'): ?>
                <a href="pages/validation_comptes.php" class="inline-block bg-slate-800 text-white font-bold text-xs uppercase px-6 py-3 rounded-xl shadow-md hover:bg-slate-700">Modérer les comptes</a>
            <?php elseif ($role === 'Etudiant'): ?>
                <a href="pages/suivi-recherches.php" class="inline-block bg-blue-600 text-white font-bold text-xs uppercase px-6 py-3 rounded-xl shadow-md hover:bg-blue-500">Gérer mes démarches</a>
            <?php else: ?>
                <?php if (str_contains($role, 'Responsable de stage')): ?>
                    <a href="pages/gestion_stages.php" class="inline-block bg-amber-600 text-white font-bold text-xs uppercase px-6 py-3 rounded-xl shadow-md hover:bg-amber-500 mr-2">Gérer les Stages (Responsable)</a>
                <?php endif; ?>
                <a href="pages/suivi_etudiants.php" class="inline-block bg-indigo-600 text-white font-bold text-xs uppercase px-6 py-3 rounded-xl shadow-md hover:bg-indigo-500 mt-2 sm:mt-0">Voir mes étudiants</a>
            <?php endif; ?>
        </div>
    </main>
    <?php include ($is_root ? '' : '../') . 'includes/footer.php'; ?>
</body>
</html>