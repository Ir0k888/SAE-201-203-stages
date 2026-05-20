<?php
// 1. Démarrer la session TOUJOURS tout en haut du fichier
session_start();

// 2. Sécurité : Si l'utilisateur n'est pas connecté, on le vire vers la page de login
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

// 3. On récupère les infos de la session pour s'en servir dans le HTML
$nom = $_SESSION['nom'];
$prenom = $_SESSION['prenom'];
$role = $_SESSION['role']; // 'Etudiant', 'Administrateur', 'Enseignant', etc.
$type_compte = $_SESSION['type_compte']; // 'etudiant' ou 'enseignant'
?>

<!DOCTYPE html>
<html lang="fr" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <title>Accueil - Stages MMI</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="assets/js/tailwind.config.js"></script>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body class="bg-slate-100 text-slate-800 font-sans flex flex-col min-h-screen">

    <nav class="fixed top-0 w-full flex justify-between items-center py-4 px-8 bg-white border-b border-slate-200 z-50">
        <div class="font-bold text-xl text-transparent bg-clip-text bg-gradient-to-r from-brandStart to-brandEnd">MMI Stages</div>
        <div class="burger hidden flex-col justify-center gap-1.5 w-7 h-5 cursor-pointer z-[1100] md:hidden" id="burger">
            <span class="block h-0.5 w-full bg-slate-800 rounded transition-transform duration-300"></span>
            <span class="block h-0.5 w-full bg-slate-800 rounded transition-opacity duration-300"></span>
            <span class="block h-0.5 w-full bg-slate-800 rounded transition-transform duration-300"></span>
        </div>
        
        <ul id="nav-links" class="hidden absolute top-full left-0 w-full bg-white shadow-lg flex-col py-6 md:static md:flex md:flex-row md:w-auto md:bg-transparent md:shadow-none md:py-0 gap-8 items-center">
            <li><a href="index.php" class="nav-link active font-medium text-slate-700 hover:text-brandStart transition-colors">Accueil</a></li>
            
            <?php if ($role === 'Etudiant'): ?>
                <li><a href="pages/offres.php" class="nav-link font-medium text-slate-600 hover:text-brandStart transition-colors">Offres</a></li>
                <li><a href="pages/suivi-recherches.php" class="nav-link font-medium text-slate-600 hover:text-brandStart transition-colors">Mes Recherches</a></li>
                <li><a href="pages/soutenances.php" class="nav-link font-medium text-slate-600 hover:text-brandStart transition-colors">Ma Soutenance</a></li>
            
            <?php elseif ($role === 'Administrateur'): ?>
                <li><a href="pages/validation_comptes.php" class="nav-link font-medium text-slate-600 hover:text-brandStart transition-colors">Validation des comptes</a></li>
                <li><a href="#" class="nav-link font-medium text-slate-600 hover:text-brandStart transition-colors">Gestion Base de données</a></li>
            
            <?php elseif ($role === 'Enseignant' || $role === 'Responsable de stage' || $role === 'Chef de departement'): ?>
                <li><a href="#" class="nav-link font-medium text-slate-600 hover:text-brandStart transition-colors">Mes étudiants</a></li>
                <li><a href="#" class="nav-link font-medium text-slate-600 hover:text-brandStart transition-colors">Jurys</a></li>
            <?php endif; ?>

            <li><a href="pages/profil.php" class="nav-link font-medium text-slate-600 hover:text-brandStart transition-colors">Profil</a></li>
            
            <li><a href="actions/logout_action.php" class="md:ml-4 bg-red-50 text-red-600 px-5 py-2 rounded-full text-sm font-bold hover:bg-red-100 transition-colors">Déconnexion</a></li>
        </ul>
    </nav>

    <main class="flex-grow flex flex-col items-center justify-center pt-28 pb-16 px-8 text-center w-full">
        <div class="reveal opacity-0 translate-y-7 transition-all duration-700 ease-out max-w-3xl bg-white p-10 md:p-16 rounded-2xl border border-slate-100 shadow-sm">
            
            <span class="bg-purple-100 text-brandStart px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider mb-4 inline-block">
                Espace <?= htmlspecialchars($role) ?>
            </span>
            <h1 class="text-4xl md:text-5xl font-bold text-slate-800 mb-6">Bonjour, <?= htmlspecialchars($prenom) ?></h1>
            
            <?php if ($role === 'Etudiant'): ?>
                <p class="text-lg text-slate-500 mb-10 leading-relaxed">Bienvenue sur votre espace de gestion des stages. Utilisez le menu pour consulter les offres ou déclarer vos recherches personnelles.</p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="pages/offres.php" class="rounded-full bg-gradient-to-r from-brandStart to-brandEnd text-white font-bold py-3 px-8 hover:scale-105 transition-transform shadow-md">Voir les offres</a>
                </div>
            
            <?php elseif ($role === 'Administrateur'): ?>
                <p class="text-lg text-slate-500 mb-10 leading-relaxed">Bienvenue sur l'espace de gestion. Vous avez de nouvelles demandes d'inscription de la part de l'équipe pédagogique.</p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="pages/validation_comptes.php" class="rounded-full bg-slate-800 text-white font-bold py-3 px-8 hover:scale-105 transition-transform shadow-md">Gérer les inscriptions</a>
                </div>

            <?php else: ?>
                <p class="text-lg text-slate-500 mb-10 leading-relaxed">Bienvenue sur l'espace pédagogique. Retrouvez ici le suivi de vos étudiants et vos assignations aux jurys de soutenance.</p>
            <?php endif; ?>

        </div>
    </main>

    <footer class="bg-slate-900 pt-16 pb-8 mt-auto border-t-4 border-brandStart">
        <div class="max-w-7xl mx-auto px-6 lg:px-8 w-full">
            <div class="border-t border-slate-800 pt-8 flex justify-center items-center">
                <p class="text-slate-500 text-sm">© 2026 MMI Meaux. Tous droits réservés.</p>
            </div>
        </div>
    </footer>

    <script src="assets/js/script.js"></script>
</body>
</html>